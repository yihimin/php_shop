<?php
include "main_top.php";
?>

<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
	function NoMember_Check() 
	{
		if (!form2.name.value) {
			alert("이름을 입력해 주십시오.");
			form2.name.focus();
			return;
		}
		if (!form2.email.value) {
			alert("E-Mail을 입력해 주십시오.");
			form2.email.focus();
			return;
		}
		form2.submit();
	}
</script>

<!-- form2 시작 -->
<form name="form2" method="post" action="set_guest_cookies.php">

<div class="row mb-0">
	<div class="col"></div>
	<div class="col" align="center">

		<h3 class="mt-5">비회원 주문조회</h3>
		<hr size="4px" class="m-0 mb-5">

		<table width="340" height="200" style="border:4px solid #e2e2e2" 
			bgcolor="#fcfcfc" class="table-borderless">
			<tr>
				<td align="center">
						<table  class="table table-borderless mt-3">
						<tr height="45">
							<td width="20%">이름</td>
							<td width="50%">
								<div class="d-inline-flex">
									<input type="text" name="name" size="20" value="" tabindex="1" 
										class="form-control form-control-sm">
								</div>
							</td>
							<td  width="30%" rowspan="2">
								<a href="javascript:NoMember_Check();" tabindex="3" 
									class="btn btn-sm btn-dark text-white mx-0 pt-4" 
									style="height:75px;width:75px;">&nbsp;로그인&nbsp;</a>
							</td>
						</tr>
						<tr height="45">
							<td>E-Mail</td>
							<td>
								<div class="d-inline-flex">
									<input type="text" name="email" size="20" value="" tabindex="2" 
										class="form-control form-control-sm">
								</div>
							</td>
						</tr>
					</table>					
				</td>
			</tr>
			<tr><td><hr class="m-0"></td></tr>
			<tr height="50">
				<td align="center">※ 회원님은 로그인 후, 이용하세요.</td>
			</tr>
		</table>

	</div>
	<div class="col"></div>
</div>

</form>

<br><br><br><br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<?php
include "main_bottom.php";
?>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
