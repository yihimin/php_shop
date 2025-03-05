<? 
include "main_top.php" 
?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
	function Check_Value() {
		if (!form2.uid.value) {
			alert("아이디를 입력하세요.");	form2.uid.focus();	return;
		}
		if (!form2.pwd.value) {
			alert("암호를 입력하세요.");	form2.pwd.focus();	return;
		}

		form2.submit();
	}
</script>

<!-- form2 시작 -->
<form name="form2" method="post" action="member_check.php">

<div class="row mb-0">
	<div class="col"></div>
	<div class="col" align="center">

		<h3 class="mt-5">Login</h3>
		<hr size="4px" class="m-0 mb-5">

		<table width="340" height="200" style="border:4px solid #e2e2e2" 
			bgcolor="#fcfcfc" class="table-borderless">
			<tr>
				<td align="center">
				
						<table  class="table table-borderless mt-3">
						<tr height="45">
							<td width="20%">아이디</td>
							<td width="50%">
								<div class="d-inline-flex">
									<input type="text" name="uid" size="20" value="" tabindex="1" 
										class="form-control form-control-sm">
								</div>
							</td>
							<td  width="30%" rowspan="2">
								<a href="javascript:Check_Value();" tabindex="3" 
									class="btn btn-sm btn-dark text-white mx-0 pt-4" 
									style="height:75px;width:75px;">&nbsp;로그인&nbsp;</a>
							</td>
						</tr>
						<tr height="45">
							<td>암 호</td>
							<td>
								<div class="d-inline-flex">
									<input type="password" name="pwd" size="20" value="" tabindex="2" 
										class="form-control form-control-sm">
								</div>
							</td>
						</tr>
					</table>					
				
				</td>
			</tr>
			<tr><td><hr class="m-0"></td></tr>
			<tr height="50">
				<td align="center">
					<a href="member_idpw.html" class="btn btn-sm mybutton me-5"> 아이디 / 암호 찾기 </a> 
				</td>
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
<? 
include "main_bottom.php" 
?>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
