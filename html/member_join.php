<? 
include "main_top.php" 
?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
	function FindZip(zip_kind) 
	{
		w=window.open("zipcode.php?zip_kind="+zip_kind, "zip", 
			"width=440,height=320,scrollbars=no");
	}

	function check_id()	{
		if (!form2.uid.value) {
			alert("ID를 입력하십시요.");	form2.uid.focus();	return;
		}
		window.open("member_idcheck.php?uid="+form2.uid.value,"",
			"width=300,height=200,scrollbar=no");
	}

	function Check_Value() {
		if (!form2.check_id.value) {
			alert("중복ID 조사를 먼저 하십시요.");	form2.uid.focus();	return;
		}
		if (!form2.uid.value) {
			alert("아이디가 잘못되었습니다.");	form2.uid.focus();	return;
		}
		if (!form2.pwd.value) {
			alert("암호가 잘못되었습니다.");	form2.pwd.focus();	return;
		}
		if (!form2.pwd1.value) {
			alert("암호가 잘못되었습니다.");	form2.pwd1.focus();	return;
		}
		if (form2.pwd.value != form2.pwd1.value) {
			alert("암호가 일치하지 않습니다.");	
			form2.pwd.focus();	return;
		}
		if (!form2.birthday1.value || !form2.birthday2.value || !form2.birthday3.value) {
			alert("생일이 잘못되었습니다.");	form2.birthday1.focus();	return;
		}
		if (!form2.tel1.value || !form2.tel2.value || !form2.tel3.value) {
			alert("핸드폰이 잘못되었습니다.");	form2.tel1.focus();	return;
		}
		if (!form2.zip.value) {
			alert("우편번호가 잘못되었습니다.");	form2.zip.focus();	return;
		}
		if (!form2.juso.value) {
			alert("주소가 잘못되었습니다.");	form2.juso.focus();	return;
		}
		if (!form2.email.value) {
			alert("이메일이 잘못되었습니다.");	form2.email.focus();	return;
		}

		form2.submit();
	}
</script>

<div class="row m-1 mb-0">
	<div class="col" align="center">

		<h4 class="m-0 mt-5">회원 가입</h4>

		<hr size="4px" class="my-3">

		<!-- form2 시작 -->
		<form name="form2" method="post" action="member_insert.php"> <!-- action수정 -->
		<input type="hidden" name="check_id" value=""> 

		<table style="font-size:12px;">
			<tr height="40">
				<td align="left" width="90">아이디 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="uid" size="20" value="" class="form-control form-control-sm">
					</div>
					<a href="javascript:check_id();"  class="btn btn-sm btn-secondary text-white mb-1" style="font-size:12px">중복 아이디</a>
				</td>
			</tr>
			<tr height="40">
				<td align="left">비밀번호 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="password" name="pwd" size="20" value="" pattern="^([a-z0-9_]){6,50}$" placeholder="영문자,숫자,밑줄만 이용" class="form-control form-control-sm"></td>
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">비밀번호 확인 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex mb-2">
						<input type="password" name="pwd1" size="20" value="" pattern="^([a-z0-9_]){6,50}$" placeholder="영문자,숫자,밑줄만 이용" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">이름 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="name" size="20" value="" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">휴대폰 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="tel1" size="3" maxlength="3" value="010" class="form-control form-control-sm">-
						<input type="text" name="tel2" size="4" maxlength="4" value=""	 class="form-control form-control-sm">-
						<input type="text" name="tel3" size="4" maxlength="4" value=""	 class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="90">
				<td align="left">주소 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex mb-1">
						<input type="text" name="zip" id="zip11" size="5" maxlength="5" value="" class="form-control form-control-sm">&nbsp;
					</div>
					<a href="javascript:FindZip(0);"  class="btn btn-sm btn-secondary text-white mb-1"  style="font-size:12px">우편번호 찾기</a><br>
					<div class="d-inline-flex">
						<input type="text" name="juso" id="juso11" size="50" value="" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">E-Mail</td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="email" size="50" value="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" class="form-control form-control-sm">
					</div>
				</td>
			</tr>

			<tr height="40">
				<td align="left">생일</td>
				<td align="left">
					<div class="d-inline-flex mt-2">
						<input type="text" name="birthday1" size="4" maxlength="4" value="" class="form-control form-control-sm"> -
						<input type="text" name="birthday2" size="2" maxlength="2" value="" class="form-control form-control-sm"> -
						<input type="text" name="birthday3" size="2" maxlength="2" value="" class="form-control form-control-sm">
					</div>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<div class="d-inline-flex">
						<div class="form-check">
							<input class="form-check-input" type="radio" name="sm" value="0" checked>
							<label class="form-check-label me-2">양력</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="sm" value="1">
							<label class="form-check-label">음력</label>
						</div>
					</div>
				</td>
			</tr>

		</table>

		<a href="javascript:Check_Value();"  class="btn btn-sm btn-dark text-white my-4">&nbsp;회원가입&nbsp;</a>

		</form>

	</div>
</div>

<br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<? 
include "main_bottom.php" 
?>


<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
