<?php
include "common.php";
$id = $_REQUEST["id"];
$sql = "SELECT * FROM product WHERE id=$id";
$result = mysqli_query($db, $sql);  
if (!$result) {
    exit("에러: " . mysqli_error($db));
} 
$row = mysqli_fetch_array($result); // 1레코드 읽기
?>

<?php
include "main_top.php";
?>

<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<!--  현재 페이지 Javascript  -------------------------------------------->
<script>
    function cal_price() {
        document.form2.prices.value = (document.form2.num.value * document.form2.price.value).toLocaleString();
        document.form2.num.focus();
    }

    function check_form2(action) {
        var form = document.forms['form2'];
        if (!form) {
            alert("Form not found");
            return;
        }

        if (form.opts1.value == 0) {
            alert("옵션1을 선택하십시요.");
            form.opts1.focus();
            return;
        }

        // opts2가 존재하는지 확인하고, 존재할 경우에만 값을 체크합니다.
        if (form.opts2 && form.opts2.value == 0) {
            alert("옵션2를 선택하십시요.");
            form.opts2.focus();
            return;
        }

        if (!form.num.value) {
            alert("수량을 입력하십시요.");
            form.num.focus();
            return;
        }

        if (action == "D") {
            form.action = "cart_edit.php";
            form.kind.value = "order";
            form.submit();
        } else {
            form.action = "cart_edit.php";
            form.submit();
        }
    }
</script>

<!-- form2 시작 -->
<form name="form2" method="post" action="">
    <input type="hidden" name="kind" value="insert">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <input type="hidden" name="price" value="<?= htmlspecialchars($row["price"]) ?>">

    <!-- 상품 사진/정보(제품명,가격,옵션) -->
    <div class="row mx-1 my-4">
        <div class="col" align="center">
            <table class="table table-sm table-borderless">
                <tr>
                    <td valign="top" align="left" width="50%">
                        <img src="product/<?= htmlspecialchars($row["image2"]) ?>" width="100%" 
                            class="img-thumbnail img-fluid mt-2" style="cursor:zoom-in" 
                            data-bs-toggle="modal" data-bs-target="#zoomModal">
                    </td>
                    <td width="50%" align="center" valign="top" class="px-0">
                        <hr size="5px" width="100%" class="my-2">
                        <table width="100%" style="font-size:12px;" class="table table-sm table-borderless p-0 m-0">
                            <tr height="50">
                                <td colspan="2" align="center" style="font-size:20px; color: #222222;">
                                    <?= htmlspecialchars($row["name"]) ?>
                                </td>
                            </tr>
                            <tr height="35">
                                <td colspan="2" align="center">
                                    <?php if ($row['icon_hit'] == 1) { ?>
                                        <img src="images/i_hit.gif">&nbsp;
                                    <?php } ?>
                                    <?php if ($row['icon_sale'] == 1) { ?>
                                        <img src="images/i_sale.gif">&nbsp; 
                                        <font color="red" size="3"><?= htmlspecialchars($row['discount']) ?>%</font>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr><td colspan="2"><hr class="my-2"></td></tr>
                            <tr height="35">
                                <td width="30%" align="center">판매가</td>
                                <td width="70%" align="left" style="font-size:15px;">
                                    <strike><?= number_format($row["price"]) ?>원</strike>
                                </td>
                            </tr>
                            <tr height="35">
                                <td align="center">할인가</td>
                                <td align="left" style="font-size:15px;">
                                    <?= number_format(round($row['price'] * (100 - $row['discount']) / 100, -3)) ?>원
                                </td>
                            </tr>
                            <tr><td colspan="2"><hr class="my-2"></td></tr>
                        <tr>
                            <td align="center">옵션</td>
                            <td align="left">
                                <?php
                                $sql1 = "SELECT o.id, o.opt_id, o.name FROM opts o INNER JOIN product p ON p.opt1 = o.opt_id WHERE p.id = $id";
                                $result1 = mysqli_query($db, $sql1);

                                if ($result1 !== false && mysqli_num_rows($result1) > 0) {
                                    ?>
                                    <select name="opts1" class="form-select form-select-sm mb-2" style="width:90%;font-size:12px;">
                                        <option value="0" selected>옵션을 선택하세요.</option>
                                        <?php
                                        while ($row1 = mysqli_fetch_assoc($result1)) {
                                            $value = htmlspecialchars($row1["id"]);
                                            $name = htmlspecialchars($row1["name"]);
                                            echo "<option value='$value'>$name</option>";
                                        }
                                        ?>
                                    </select>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                        $sql2 = "SELECT o.id, o.opt_id, o.name FROM opts o INNER JOIN product p ON p.opt2 = o.opt_id WHERE p.id = $id";
                        $result2 = mysqli_query($db, $sql2);

                        if ($result2 !== false && mysqli_num_rows($result2) > 0) {
                        ?>
                        <tr>
                            <td align="center">옵션2</td>
                            <td align="left">
                                <select name="opts2" class="form-select form-select-sm" style="width:90%;font-size:12px;">
                                    <option value="0" selected>옵션을 선택하세요.</option>
                                    <?php
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $value = htmlspecialchars($row2["id"]);
                                        $name = htmlspecialchars($row2["name"]);
                                        echo "<option value='$value'>$name</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>

                            <tr><td colspan="2"><hr class="my-2"></td></tr>
                            <tr>
                                <td align="center">수량</td>
                                <td align="left">
                                    <div class="d-inline-flex">
                                        <input type="text" name="num" size="5" value="1" 
                                            class="form-control form-control-sm" style="text-align:center;" onChange="javascript:cal_price()">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">금액</td>
                                <td align="left">
                                    <div class="d-inline-flex">
                                        <input type="text" name="prices" 
                                            value="<?= number_format(round($row['price'] * (100 - $row['discount']) / 100, -3)) ?> 원" size="10"
                                            class="form-control form-control-sm" style="border:0;background-color:white;text-align:left;font-size:18px;font-weight:bold;" readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="100" align="center">
                                    <a href="javascript:check_form2('D')" class="btn btn-sm btn-secondary text-light">바로 구매</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="javascript:check_form2('C')" class="btn btn-sm btn-outline-secondary">장바구니</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>
<!-- form2 끝 -->
<hr class="my-0 mx-3">
<div align="center">
    <?= htmlspecialchars($row["contents"]) ?>
    <br><br>
    <img src="product/<?= htmlspecialchars($row["image3"]) ?>" class="img-thumbnail" style="border:0">
</div>   
<br><br>
<!-- Zoom Modal 이미지 -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="zoomModalLabel"><?= htmlspecialchars($row["name"]) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div align="center" class="modal-body">
        <img src="product/<?= htmlspecialchars($row["image1"]) ?>" class="img-thumbnail" style="cursor:pointer" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
      </div>
    </div>
  </div>
</div>
<!-------------------------------------------------------------------------------------------->    
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    
<?php include "main_bottom.php"; ?>
</div>
</body>
</html>
