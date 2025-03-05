<? 
include "main_top.php" ;

// 기존 쿠키에서 장바구니를 가져옵니다
$n_cart = isset($_COOKIE['n_cart']) ? intval($_COOKIE['n_cart']) : 0;
$cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : [];

// 쿠키로 로그인했는지 조사
if (isset($_COOKIE['cookie_id'])) {
    $cookie_id = $_COOKIE['cookie_id'];
    $sql = "SELECT * FROM member WHERE id='$cookie_id'";
    $result = mysqli_query($db, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $o_name = $row['name'];
        $o_tel = $row['tel'];
        $o_email = $row['email'];
        $o_zip = $row['zip'];
        $o_juso = $row['juso'];
    }
}

?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<script>
	function Check_Value() 
	{
		if (form2.pay_kind[0].checked)
		{
			if (form2.card_kind.value==0) {
				alert("카드종류를 선택하세요.");	form2.card_kind.focus();	return;
			}
			if (!form2.card_no1.value) {
				alert("카드번호를 입력하세요.");	form2.card_no1.focus();	return;
			}
			if (!form2.card_no2.value) {
				alert("카드번호를 입력하세요.");	form2.card_no2.focus();	return;
			}
			if (!form2.card_no3.value) {
				alert("카드번호를 입력하세요.");	form2.card_no3.focus();	return;
			}
			if (!form2.card_no4.value) {
				alert("카드번호를 입력하세요.");	form2.card_no4.focus();	return;
			}
			if (!form2.card_month.value) {
				alert("카드기간 월을 입력하세요.");	form2.card_month.focus();	return;
			}
			if (!form2.card_year.value) {
				alert("카드기간 년도를 입력하세요.");	form2.card_year.focus();	return;
			}
			if (!form2.card_pw.value) {
				alert("카드 비밀번호 뒷의 2자리를 입력하세요.");	form2.card_pw.focus();	return;
			}
		}
		else
		{
			if (form2.bank_kind.value==0) {
				alert("입금할 은행을 선택하세요.");	form2.bank_kind.focus();	return;
			}
			if (!form2.bank_sender.value) {
				alert("입금자 이름을 입력하세요.");	form2.bank_sender.focus();	return;
			}
		}
		form2.card_kind.disabled = false;
		form2.card_no1.disabled = false;
		form2.card_no2.disabled = false;
		form2.card_no3.disabled = false;
		form2.card_no4.disabled = false;
		form2.card_year.disabled = false;
		form2.card_month.disabled = false;
		form2.card_pw.disabled = false;
		form2.card_halbu.disabled = false;
		form2.bank_kind.disabled = false;
		form2.bank_sender.disabled = false;
		
		form2.submit();
	}

	function PaySel(n) 
	{
		if (n == 0) {
			form2.card_kind.disabled = false;
			form2.card_no1.disabled = false;
			form2.card_no2.disabled = false;
			form2.card_no3.disabled = false;
			form2.card_no4.disabled = false;
			form2.card_year.disabled = false;
			form2.card_month.disabled = false;
			form2.card_halbu.disabled = false;
			form2.card_pw.disabled = false;
			form2.bank_kind.disabled = true;
			form2.bank_sender.disabled = true;
		}
		else {
			form2.card_kind.disabled = true;
			form2.card_no1.disabled = true;
			form2.card_no2.disabled = true;
			form2.card_no3.disabled = true;
			form2.card_no4.disabled = true;
			form2.card_year.disabled = true;
			form2.card_month.disabled = true;
			form2.card_halbu.disabled = true;
			form2.card_pw.disabled = true;
			form2.bank_kind.disabled = false;
			form2.bank_sender.disabled = false;
		}
	}
</script>

<div class="row m-1 mb-0">
	<div class="col" align="center">

		<h4 class="m-3">주문(결제정보)</h4>
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
                            if ($row1 = mysqli_fetch_array($result1)) {
                                $opt1 = $row1['name'];
                            }
                        }
                        if ($opts_id2 != '') {
                            $sql2 = "SELECT name FROM opts WHERE id = $opts_id2";
                            $result2 = mysqli_query($db, $sql2);
                            if ($row2 = mysqli_fetch_array($result2)) {
                                $opt2 = $row2['name'];
                            }
                        }

                        // 제품 정보 알아내기
                        $sql = "SELECT * FROM product WHERE id = $id";
                        $result = mysqli_query($db, $sql);
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
<form name="form2" method="post" action="order_insert.php">

<?php
// $o_tel과 $r_tel 합치기
$o_tel = $_REQUEST['o_tel1'] . '-' . $_REQUEST['o_tel2'] . '-' . $_REQUEST['o_tel3'];
$r_tel = $_REQUEST['r_tel1'] . '-' . $_REQUEST['r_tel2'] . '-' . $_REQUEST['r_tel3'];
?>

	<input type="hidden" name="o_name" value="<?=$_REQUEST['o_name']?>">
	<input type="hidden" name="o_tel" value="<?=$o_tel?>">
    <input type="hidden" name="o_email" value="<?=$_REQUEST['o_email']?>">
    <input type="hidden" name="o_zip" value="<?=$_REQUEST['o_zip']?>">
    <input type="hidden" name="o_juso" value="<?=$_REQUEST['o_juso']?>">
    <input type="hidden" name="r_name" value="<?=$_REQUEST['r_name']?>">
    <input type="hidden" name="r_tel" value="<?=$r_tel?>">
    <input type="hidden" name="r_email" value="<?=$_REQUEST['r_email']?>">
    <input type="hidden" name="r_zip" value="<?=$_REQUEST['r_zip']?>">
    <input type="hidden" name="r_juso" value="<?=$_REQUEST['r_juso']?>">
    <input type="hidden" name="memo" value="<?=$_REQUEST['memo']?>">

<div class="row mx-1 my-0">
	<div class="col" align="center">

		<font size="4" color="#B90319">결제방법</font>
		<hr class="m-0 my-2">
					
		<table width="90%" style="font-size:13px;">
			<tr height="40">
				<td width="40%" align="right" class="pe-4">결제선택</td>
				<td align="left">
					<div class="d-inline-flex mt-2">
						<div class="form-check me-2">
							<input class="form-check-input" type="radio" name="pay_kind" value="0" 
								onclick="javascript:PaySel(0);" checked>
							<label class="form-check-label me-2">카드</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="pay_kind" value="1" 
								onclick="javascript:PaySel(1);">
							<label class="form-check-label">무통장</label>
						</div>
					</div>
				</td>
			</tr>
		</table>
		<br><br>
		
		<font size="4" color="#B90319">카드</font>
		<hr class="m-0 my-2">
		
		<table width="90%" style="font-size:13px;">
			<tr height="40">
				<td  width="40%" align="right" class="pe-4">카드종류</td>
				<td align="left">
					<div class="d-inline-flex">
						<select name="card_kind" class="form-select form-select-sm myfs13">
							<option value="0" selected>카드종류를 선택하세요.</option>
							<option value="1">국민카드</option>
							<option value="2">신한카드</option>
							<option value="3">우리카드</option>
							<option value="4">하나카드</option>
						</select>
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="right" align="right" class="pe-4">카드번호</td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="card_no1" size="4" maxlength="4" value="" 
							class="form-control form-control-sm">&nbsp;
						<input type="text" name="card_no2" size="4" maxlength="4" value="" 
							class="form-control form-control-sm">&nbsp;
						<input type="text" name="card_no3" size="4" maxlength="4" value="" 
							class="form-control form-control-sm">&nbsp;
						<input type="text" name="card_no4" size="4" maxlength="4" value="" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="right" align="right" class="pe-4">카드기간</td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="card_month" size="2" maxlength="2" value="" 
							class="form-control form-control-sm">
						<div class="ms-1 mt-2">월</div>&nbsp;&nbsp;
						<input type="text" name="card_year" size="2" maxlength="2" value="" 
							class="form-control form-control-sm">
						<div class="ms-1 mt-2">년</div>
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="right" align="right" class="pe-4">카드비밀번호</td>
				<td align="left">
					<div class="d-inline-flex">
						<div class="mt-2 fs-6">**</div>&nbsp;
						<input type="password" name="card_pw" size="2" maxlength="2" value="" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="right" align="right" class="pe-4">할부</td>
				<td align="left">
					<div class="d-inline-flex">
						<select name="card_halbu" class="form-select form-select-sm myfs13">
							<option value="0" selected>일시불</option>
							<option value="3">3 개월</option>
							<option value="6">6 개월</option>
							<option value="9">9 개월</option>
							<option value="12">12 개월</option>
						</select>
					</div>
				</td>
			</tr>
		</table>
				
		<br><br>
		<font size="4" color="#B90319">무통장</font>
		<hr class="m-0 my-2">
		
		<table width="90%" style="font-size:13px;">
			<tr height="40">
				<td width="40%" align="right" class="pe-4">카드종류</td>
				<td align="left">
					<div class="d-inline-flex">
						<select name="bank_kind" class="form-select form-select-sm myfs13"  disabled>
							<option value="0" selected>입금할 은행을 선택하세요.</option>
							<option value="1">국민은행 111-00000-0000</option>
							<option value="2">신한은행 222-00000-0000</option>
						</select>
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="right" class="pe-4">입금자이름</td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="bank_sender" size="20" value="" 
							class="form-control form-control-sm" disabled>
					</div>
				</td>
			</tr>
		</table>

	</div>
<div>
<br>

<div class="row">
	<div class="col" align="center">
		<a href="javascript:Check_Value()"  class="btn btn-sm btn-dark text-white">&nbsp;결제하기&nbsp;</a>
	</div>
</div>

</form>

<br><br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	
<? 
include "main_bottom.php" 
?>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
