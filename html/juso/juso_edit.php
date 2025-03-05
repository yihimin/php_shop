<?php
include "common.php";

$id = $_REQUEST["id"];
//전화번호 분해 
$tel1 = $_REQUEST["tel1"];         
$tel2 = $_REQUEST["tel2"];         
$tel3 = $_REQUEST["tel3"];        
//생일 분해
$birthday1 = $_REQUEST["birthday1"]; 
$birthday2 = $_REQUEST["birthday2"]; 
$birthday3 = $_REQUEST["birthday3"]; 

$sql = "SELECT * FROM juso WHERE id=$id"; // id번째 자료 읽기
$result = mysqli_query($db, $sql);
if (!$result) {
    exit("에러: $sql");
}

$row = mysqli_fetch_array($result); // 1레코드 읽기

// 전화번호가 null이 아닌 경우에만 토막내기 작업 수행
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
?>


<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>JUSO</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<br>
	
<form name="form1" method="post" action="juso_update.php">
<input type="hidden" name="id" value=<?= $id; ?>>

<table class="table table-sm table-bordered mymargin5">
	<tr height="40">
		<td width="20%" class="mycolor2">ID</td>
		<td width="80%"align="left">&nbsp;<?= $id; ?></td>
	</tr>
	<tr>
		<td class="mycolor2">이름</td>
		<td align="left">
			<div class="d-inline-flex">
				<input type="text" name="name" size="20" value="<?=$row["name"]; ?>" 
					class="form-control form-control-sm">
			</div>
		</td>
	</tr>
	<tr>
		<td class="mycolor2">전화</td>
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
	<tr  height="40">
		<td class="mycolor2">음력/양력</td>
		<td align="left">
			&nbsp;<input type="radio" name="sm" value="0" 
			<?php if ($row["sm"] == 0) echo "checked"; ?>> 양력
    		<input type="radio" name="sm" value="1" 
			<?php if ($row["sm"] == 1) echo "checked"; ?>> 음력
		</td>
	</tr>
	<tr>
		<td class="mycolor2">생일</td>
		<td align="left">
			<div class="d-inline-flex">
				<input type="text" name="birthday1" size="4" value="<?=$birthday1;?>"
					class="form-control form-control-sm"> -
				<input type="text" name="birthday2" size="2" value="<?=$birthday2;?>" 
					class="form-control form-control-sm"> -
				<input type="text" name="birthday3" size="2" value= "<?=$birthday3;?>" 
					class="form-control form-control-sm">
			</div>
		</td>
	</tr>
	<tr>
		<td class="mycolor2">주소</td>
		<td align="left">
			<input type="text" name="juso" value="<?=$row["juso"]; ?>"
				class="form-control form-control-sm">
		</td>
	</tr>
</table>

<div align="center">
	<input type="submit" value="저장" class="btn btn-sm mycolor1">&nbsp;
	<input type="button" value="이전화면" class="btn btn-sm mycolor1" 
		onClick="history.back();">
</div>

</form>
	
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>

