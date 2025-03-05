<?php
include "common.php";
include "main_top.php";

// 기존 쿠키에서 장바구니를 가져옵니다
$n_cart = isset($_COOKIE['n_cart']) ? intval($_COOKIE['n_cart']) : 0;
$cart = $_COOKIE["cart"];

// 주문자 정보를 위한 변수 초기화
$o_name = $o_tel = $o_email = $o_zip = $o_juso = "";
$r_name = $r_tel = $r_email = $r_zip = $r_juso = "";

// 쿠키로 로그인했는지 조사
if (isset($_COOKIE['cookie_id'])) {
    $cookie_id = $_COOKIE['cookie_id'];
    $sql = "SELECT * FROM member WHERE id='$cookie_id'";
    $result = mysqli_query($db, $sql);
    if (!$result) {
        die("쿼리 오류: " . mysqli_error($db));
    }
    if ($row = mysqli_fetch_assoc($result)) {
        $o_name = $row['name'];
        $o_tel = $row['tel'];
        $o_email = $row['email'];
        $o_zip = $row['zip'];
        $o_juso = $row['juso'];
    }
}

?>

<script>
function Check_Value() {
    if (!form2.o_name.value) {
        alert("주문자 이름이 잘못 되었습니다."); form2.o_name.focus(); return;
    }
    if (!form2.o_tel1.value || !form2.o_tel2.value || !form2.o_tel3.value) {
        alert("핸드폰이 잘못 되었습니다."); form2.o_tel1.focus(); return;
    }
    if (!form2.o_email.value) {
        alert("이메일이 잘못 되었습니다."); form2.o_email.focus(); return;
    }
    if (!form2.o_zip.value) {
        alert("우편번호가 잘못 되었습니다."); form2.o_zip.focus(); return;
    }
    if (!form2.o_juso.value) {
        alert("주소가 잘못 되었습니다."); form2.o_juso.focus(); return;
    }

    if (!form2.r_name.value) {
        alert("받으실 분의 이름이 잘못 되었습니다."); form2.r_name.focus(); return;
    }
    if (!form2.r_tel1.value || !form2.r_tel2.value || !form2.r_tel3.value) {
        alert("핸드폰이 잘못 되었습니다."); form2.r_tel1.focus(); return;
    }
    if (!form2.r_email.value) {
        alert("이메일이 잘못 되었습니다."); form2.r_email.focus(); return;
    }
    if (!form2.r_zip.value) {
        alert("우편번호가 잘못 되었습니다."); form2.r_zip.focus(); return;
    }
    if (!form2.r_juso.value) {
        alert("주소가 잘못 되었습니다."); form2.r_juso.focus(); return;
    }

    form2.submit();
}

function FindZip(zip_kind) 
{
    window.open("zipcode.php?zip_kind="+zip_kind, "", "scrollbars=no,width=490,height=320");
}

function SameCopy(str) {
    if (str == "Y") {
        form2.r_name.value = form2.o_name.value;
        form2.r_zip.value = form2.o_zip.value;
        form2.r_juso.value = form2.o_juso.value;
        form2.r_tel1.value = form2.o_tel1.value;
        form2.r_tel2.value = form2.o_tel2.value;
        form2.r_tel3.value = form2.o_tel3.value;
        form2.r_email.value = form2.o_email.value;
    }
    else {
        form2.r_name.value = "";
        form2.r_zip.value = "";
        form2.r_juso.value = "";
        form2.r_tel1.value = "";
        form2.r_tel2.value = "";
        form2.r_tel3.value = "";
        form2.r_email.value = "";
    }
}
</script>

<div class="row m-1 mb-0">
    <div class="col" align="center">

        <h4 class="m-3">주문(배송정보)</h4>
        <hr class="m-0">
        
        <table class="table table-sm mb-5">
            <thead>
                <tr height="40" class="bg-light">
                    <th width="10%">이미지</th>
                    <th width="35%">상품정보</th>
                    <th width="10%">판매가</th>
                    <th width="20%">수량</th>
                    <th width="10%">금액</th>
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
                            if (!$result1) {
                                die("쿼리 오류2: " . mysqli_error($db));
                            }
                            if ($row1 = mysqli_fetch_array($result1)) {
                                $opt1 = $row1['name'];
                            }
                        }
                        if (!empty($opts_id2)) {
                            $sql2 = "SELECT name FROM opts WHERE id = $opts_id2";
                            $result2 = mysqli_query($db, $sql2);
                            if (!$result2) {
                                die("쿼리 오류3: " . mysqli_error($db));
                            }
                            if ($row2 = mysqli_fetch_array($result2)) {
                                $opt2 = $row2['name'];
                            }
                        }

                        // 제품 정보 알아내기
                        $sql = "SELECT * FROM product WHERE id = $id";
                        $result = mysqli_query($db, $sql);
                        if (!$result) {
                            die("쿼리 오류4: " . mysqli_error($db));
                        }
                        if ($row = mysqli_fetch_array($result)) {

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
                            <?=$num?>
                        </div>
                    <td><?=number_format($item_total)?>원</td>
                </tr>
                <?php
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
    </div>
</div>

<!-- form2 시작 -->
<form name="form2" method="post" action="order_pay.php">

<div class="row mx-1 my-0">
    <div class="col" align="center">

        <font size="4" color="#B90319">주문정보</font>
        <hr class="m-0 my-2">
        
        <table  style="font-size:13px;">
            <tr height="40">
                <td align="left" width="100">이름 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex">
                        <input type="text" name="o_name" size="20" value="<?=$o_name?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr height="40">
                <td align="left" width="20%">휴대폰 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex">
                    <?php
                        // 전화번호 토막내기
                        $o_tel1 = trim(substr($o_tel, 0, 3)); // 0번 위치에서 3자리 문자열 추출
                        $o_tel2 = trim(substr($o_tel, 3, 4)); // 3번 위치에서 4자리
                        $o_tel3 = trim(substr($o_tel, 7, 4)); // 7번 위치에서 4자리
                    ?>
                        <input type="text" name="o_tel1" size="3" maxlength="3" value="<?=$o_tel1?>" class="form-control form-control-sm">-
                        <input type="text" name="o_tel2" size="4" maxlength="4" value="<?=$o_tel2?>" class="form-control form-control-sm">-
                        <input type="text" name="o_tel3" size="4" maxlength="4" value="<?=$o_tel3?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>

            <tr height="40">
                <td align="left">이메일 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex">
                        <input type="text" name="o_email" size="50" value="<?=$o_email?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr height="80">
                <td align="left">주소 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex mb-1">
                        <input type="text" name="o_zip" size="5" maxlength="5" value="<?=$o_zip?>" class="form-control form-control-sm">&nbsp;
                    </div>
                    <a href="javascript:FindZip(1)"  class="btn btn-sm btn-secondary text-white mb-1" style="font-size:12px">우편번호 찾기</a><br>
                    <div class="d-inline-flex">
                        <input type="text" name="o_juso" size="50" value="<?=$o_juso?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
        </table>
        
    </div>
</div>

<br>

<div class="row mx-1 my-3">
    <div class="col" align="center">
    
        <font size="4" color="#B90319">배송정보</font>
        <hr class="m-0 my-2">
    
        <table style="font-size:13px;">
            <tr height="40">
                <td align="left" width="20%">위 복사</td>
                <td align="left">
                    <div class="d-inline-flex">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="same" onclick="javascript:SameCopy('Y')">
                            <label class="form-check-label me-2">예</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="same" onclick="javascript:SameCopy('N')">
                            <label class="form-check-label">아니오</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr height="40">
                <td align="left">이름 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex">
                        <input type="text" name="r_name" size="20" value="<?=$r_name?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr height="40">
                <td align="left">휴대폰 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex">        
                    <?php
                        // 전화번호 조합 !이게 안됨!
                        $r_tel1 = trim(substr($r_tel, 0, 3));
                        $r_tel2 = trim(substr($r_tel, 3, 4));
                        $r_tel3 = trim(substr($r_tel, 7, 4));
			            $r_tel = $r_tel1 . $r_tel2 . $r_tel3;
                    ?>
                        <input type="text" name="r_tel1" size="3" maxlength="3" value="<?=$r_tel1?>" class="form-control form-control-sm">-
                        <input type="text" name="r_tel2" size="4" maxlength="4" value="<?=$r_tel2?>" class="form-control form-control-sm">-
                        <input type="text" name="r_tel3" size="4" maxlength="4" value="<?=$r_tel3?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>

            <tr height="40">
                <td align="left">이메일 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex">
                        <input type="text" name="r_email" size="50" value="<?=$r_email?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr height="80">
                <td align="left">주소 <font color="red">*</font></td>
                <td align="left">
                    <div class="d-inline-flex mb-1">
                        <input type="text" name="r_zip" size="5" maxlength="5" value="<?=$r_zip?>" class="form-control form-control-sm">&nbsp;
                    </div>
                    <a href="javascript:FindZip(2)"  class="btn btn-sm btn-secondary text-white mb-1" style="font-size:12px">우편번호 찾기</a><br>
                    <div class="d-inline-flex">
                        <input type="text" name="r_juso" size="50" value="<?=$r_juso?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr height="90">
                <td align="left">요구사항</td>
                <td align="left">
                    <div class="d-inline-flex">
                        <textarea name="memo" cols="50" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="row mx-5">
    <div class="col" align="center">
        <a href="javascript:Check_Value()" class="btn btn-sm btn-dark text-white">&nbsp;다 &nbsp;&nbsp; 음&nbsp;</a>
    </div>
</div>

</form>

<br><br><br>

<!-------------------------------------------------------------------------------------------->    
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<?php
include "main_bottom.php";
?>

</div>

</body>
</html>
