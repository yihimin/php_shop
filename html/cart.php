<?php
include "common.php";
include "main_top.php";

// 기존 쿠키에서 장바구니를 가져옵니다
$n_cart = isset($_COOKIE['n_cart']) ? intval($_COOKIE['n_cart']) : 0;
$cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : [];
?>

<script> 
    function cart_edit(kind, pos) {
        if (kind == "deleteall") 
            location.href = "cart_edit.php?kind=deleteall";
        else if (kind == "delete")
            location.href = "cart_edit.php?kind=delete&pos=" + pos;
        else if (kind == "insert") {
            var num = eval("form2.num" + pos).value;
            location.href = "cart_edit.php?kind=insert&pos=" + pos + "&num=" + num;
        }
        else if (kind == "update") {
            var num = eval("form2.num" + pos).value;
            location.href = "cart_edit.php?kind=update&pos=" + pos + "&num=" + num;
        }
    }
</script>

<!-- form2 시작 -->
<form name="form2" method="post" action="">

<div class="row m-3 mb-0">
    <div class="col" align="center">

        <h4 class="my-3">장바구니</h4>

        <hr class="m-0">
        <table class="table table-sm mb-5"> 
            <thead>
                <tr height="40" class="bg-light">
                    <th width="10%">이미지</th>
                    <th width="35%">상품정보</th>
                    <th width="10%">판매가</th>
                    <th width="20%">수량</th>
                    <th width="10%">금액</th>
                    <th width="10%">삭제</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $total_price = 0;
                if (!$n_cart) $n_cart = 0;
                for ($i = 1; $i <= $n_cart; $i++) {
                    if (isset($cart[$i])) {
                        list($id, $num, $opts_id1, $opts_id2) = explode("^", $cart[$i]);

                        // 옵션 이름 알아내기
                        $opt1 = "";
                        $opt2 = "";
                        if ($opts_id1 != 0) {
                            $sql1 = "SELECT name FROM opts WHERE id = $opts_id1";
                            $result1 = mysqli_query($db, $sql1);
                            if ($result1 && $row1 = mysqli_fetch_array($result1)) {
                                $opt1 = $row1['name'];
                            } else {
                                echo "<tr><td colspan='6'>옵션1 정보 조회 오류: " . mysqli_error($db) . "</td></tr>";
                                continue;
                            }
                        }
                        if (!empty($opts_id2)) {
                            $sql2 = "SELECT name FROM opts WHERE id = $opts_id2";
                            $result2 = mysqli_query($db, $sql2);
                            if ($result2 && $row2 = mysqli_fetch_array($result2)) {
                                $opt2 = $row2['name'];
                            } else {
                                echo "<tr><td colspan='6'>옵션2 정보 조회 오류: " . mysqli_error($db) . "</td></tr>";
                                continue;
                            }
                        }

                        // 제품 정보 알아내기
                        $sql = "SELECT * FROM product WHERE id = $id";
                        $result = mysqli_query($db, $sql);
                        if ($result && $row = mysqli_fetch_array($result)) {

                            // 판매가 계산
                            $item_price = $row['price'];
                            if ($row['icon_sale'] == 1) {
                                $item_price = round($row['price'] * (100 - $row['discount']) / 100, -3);
                            }
                            $item_total = $item_price * $num;
                            $total_price += $item_total;
            ?>
                <tr height="85" style="font-size:14px;">
                    <td>
                        <a href="product.php?id=<?=$id?>"><img src="product/<?=$row['image2']?>" width="60" height="70"></a>
                    </td>
                    <td align="left" valign="middle">
                        <a href="product.php?id=<?=$id?>" style="color:#0066CC"><?=$row['name']?></a><br>
                        <small><b>[옵션]</b> <?=$opt1?> &nbsp; <?=$opt2?></small>
                    </td>
                    <td><?=number_format($item_price)?>원</td>
                    <td>
                        <div class="d-inline-flex">
                            <input type="text" name="num<?=$i?>" size="2" value="<?=$num?>" class="form-control form-control-sm text-center">
                        </div>
                        <a href="javascript:cart_edit('update', '<?=$i?>')" class="btn btn-sm mybutton mb-1" style="color:#0066CC">수정</a> 
                    </td>
                    <td><?=number_format($item_total)?>원</td>
                    <td>
                        <a href="javascript:cart_edit('delete', '<?=$i?>')" class="btn btn-sm mybutton" style="color:#D06404">삭제</a> 
                    </td>
                </tr>
                <?php
                        } else {
                            echo "<tr><td colspan='6'>제품 정보 조회 오류: " . mysqli_error($db) . "</td></tr>";
                        }
                    }
                }
                $total_with_shipping = $total_price;
                $shipping_cost = 0;
                if ($total_price < $max_baesongbi) {
                    $total_with_shipping += $baesongbi;
                    $shipping_cost = $baesongbi;
                }
                ?>
                <tr height="40" align="right" class="bg-light" style="font-size:14px;">
                    <td colspan="6" class="pe-4">
                        <font color="#0066CC">총 합계금액</font> : 상품구매금액( <?=number_format($total_price)?>원 )
                        <?php if ($shipping_cost > 0): ?>
                            + 배송비( <?=number_format($shipping_cost)?>원 )
                        <?php endif; ?>
                        = <font style="font-size:16px"><b><?=number_format($total_with_shipping)?>원</b></font>
                    </td>
                </tr>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-sm btn-outline-secondary mx-1">&nbsp;계속 쇼핑하기&nbsp;</a>
        <a href="javascript:cart_edit('deleteall', 0)" class="btn btn-sm btn-outline-secondary mx-1">&nbsp;장바구니 비우기&nbsp;</a>
        <a href="order.php" class="btn btn-sm btn-dark text-white mx-1">&nbsp;결제하기&nbsp;</a>

    </div>
</div>

</form>
<br><br><br><br><br><br><br><br><br>

<?php include "main_bottom.php"; ?>

</div>

</body>
</html>
