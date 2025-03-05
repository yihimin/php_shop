<?php
    include "common.php";

    $cookie_id = $_COOKIE["cookie_id"];
    //전화번호 분해
    $tel1 = $_REQUEST["tel1"];         
    $tel2 = $_REQUEST["tel2"];         
    $tel3 = $_REQUEST["tel3"];        
    //생일 분해
    $birthday1 = $_REQUEST["birthday1"]; 
    $birthday2 = $_REQUEST["birthday2"]; 
    $birthday3 = $_REQUEST["birthday3"]; 

    $sql = "SELECT * FROM member WHERE id=$cookie_id";
    $result = mysqli_query($db, $sql);
    if (!$result) {
        exit("에러: $sql");
    }

    $row = mysqli_fetch_array($result); // 1레코드 읽기

    if ($row["tel"] !== null) {
        $tel1 = trim(substr($row["tel"], 0, 3)); // 0번 위치에서 3자리 문자열 추출
        $tel2 = trim(substr($row["tel"], 3, 4)); // 3번 위치에서 4자리
        $tel3 = trim(substr($row["tel"], 7, 4)); // 7번 위치에서 4자리
    }

    // 생일이 null이 아닌 경우에만 토막내기 작업 수행
    if ($row["birthday"] !== null) {
        $birthday1 = substr($row["birthday"], 0, 4);
        $birthday2 = substr($row["birthday"], 5, 2);
        $birthday3 = substr($row["birthday"], 8, 2);
    }

    $pwd1 = $_REQUEST["pwd1"];
    if (!$pwd1) {
        $sql = "Update member set tel='$tel1$tel2$tel3', birthday='$birthday1-$birthday2-$birthday3' where id=$cookie_id";
    } else {
        $sql = "Update member set pwd='$pwd1', tel='$tel1$tel2$tel3', birthday='$birthday1-$birthday2-$birthday3' where id=$cookie_id";
    }

    $result = mysqli_query($db, $sql);
    if (!$result) {
        exit("에러: $sql");
    }
?>


<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
	<link  href="css/bootstrap.min.css" rel="stylesheet">
	<link  href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<?php
 include "main_top.php"
?>
<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
	function FindZip(zip_kind) 
	{
		window.open("zipcode.php?zip_kind="+zip_kind, "", "scrollbars=no,width=490,height=320");
	}

	function Check_Value() {
		if (form2.pwd.value != form2.pwd1.value) {
			alert("암호가 일치하지 않습니다.");	
			form2.pwd.focus();	return;
		}
		if (!form2.name.value) {
			alert("이름이 잘못되었습니다.");	form2.name.focus();	return;
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

<div class="row m-5 mb-0">
	<div class="col" align="center">

		<h4 class="m-3 mb-2">회원 정보 수정</h4>

		<hr size="4px" class="m-0">
		<br>

		<!-- form2 시작 -->
		<form name="form2" method="post" action="member_update.php">
		<table style="font-size:13px;">
			<tr height="40">
				<td align="left" width="120">아이디 <font color="red">*</font></td>
				<td align="left"><?= $cookie_id; ?></td>
			</tr>
			<tr height="40">
				<td align="left">새 비밀번호</td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="password" name="pwd" size="20" value="" 
							class="form-control form-control-sm">
					</div>
					<br>&nbsp; ※ 비밀번호 변경할 때만 입력.
				</td>
			</tr>
			<tr height="40">
				<td align="left">새 비밀번호 확인</td>
				<td align="left">
					<div class="d-inline-flex my-1">
						<input type="password" name="pwd1" size="20" value="" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">이름 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="name" size="20" value="<?=$row["name"]; ?>" 
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">휴대폰 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex">
                    <input type="text" name="tel1" size="3" value="<?=$tel1; ?>"
					class="form-control form-control-sm"> - 
				    <input type="text" name="tel2" size="4" value="<?=$tel2; ?>"
					class="form-control form-control-sm"> - 
				    <input type="text" name="tel3" size="4" value="<?=$tel3; ?>"
					class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="90">
				<td align="left">주소 <font color="red">*</font></td>
				<td align="left">
					<div class="d-inline-flex mb-1">
						<input type="text" name="zip" size="5" maxlength="5" 
							value="<?=$row["zip"]; ?>" class="form-control form-control-sm">&nbsp;
					</div>
					<a href="javascript:FindZip(0);"  style="font-size:13px"
						class="btn btn-sm btn-secondary text-white mb-1"  >우편번호 찾기</a><br>
					<div class="d-inline-flex">
						<input type="text" name="juso" size="50" 
							value="<?=$row["juso"]; ?>"
							class="form-control form-control-sm">
					</div>
				</td>
			</tr>
			<tr height="40">
				<td align="left">E-Mail</td>
				<td align="left">
					<div class="d-inline-flex">
						<input type="text" name="email" size="50" 
							value="<?=$row["email"]; ?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>

			<tr height="40">
				<td align="left">생일</td>
				<td align="left">
					<div class="d-inline-flex mt-2">
                    <input type="text" name="birthday1" size="4" value="<?=$birthday1;?>"
					class="form-control form-control-sm"> -
				    <input type="text" name="birthday2" size="2" value="<?=$birthday2;?>" 
					class="form-control form-control-sm"> -
				    <input type="text" name="birthday3" size="2" value= "<?=$birthday3;?>" 
					class="form-control form-control-sm">
					</div>
				</td>
			</tr>
		</table>

		<a href="javascript:Check_Value();"  class="btn btn-sm btn-dark text-white my-4">&nbsp;회원정보 수정&nbsp;</a>

		</form>
		
	</div>
</div>

<br><br>

<!-------------------------------------------------------------------------------------------->	
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	
<?php
 include "main_bottom.php"
?>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
