<!---------------------------------------------------------------------------------------------
	제목 : 내 손으로 만드는 PHP 쇼핑몰 (실습용 디자인 HTML)

	소속 : 인덕대학교 컴퓨터소프트웨어학과
	이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->
<?
    include "common.php";

    $id=$_REQUEST["id"];

    $sql="select * from  sj  where  id=$id ";     // id번째 자료 읽기
    $result=mysqli_query($db,$sql); 
    if (!$result) exit("에러:$sql");

    $row=mysqli_fetch_array($result);    // 1레코드 읽기
?>


<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>성적처리 프로그램</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<br>

<script>
	function cal_score()
	{
		form1.hap.value=Number(form1.kor.value) 
									+ Number(form1.eng.value) 
									+ Number(form1.mat.value);
		form1.avg.value=(form1.hap.value/3.).toFixed(1);
	}
</script>

<form name="form1" method="post" action="sj_update.php">
<input type="hidden" name="id" value="<?=$id; ?>">

<table class="table table-sm table-bordered mymargin5">
	<tr height="40">
		<td width="20%" class="mycolor2">ID</td>
		<td width="80%" align="left">&nbsp;<?= $id; ?></td>
	</tr>
	<tr>
		<td class="mycolor2">이름</td>
		<td align="left">
			<div class="d-inline-flex">
				<input type="text" name="name" value="<?=$row["name"]; ?>" size="20" 
					class="form-control form-control-sm">
			</div>
		</td>
	</tr>
	<tr>
		<td class="mycolor2">국어</td>
		<td align="left">
			<div class="d-inline-flex">
				<input type="text" name="kor" value=<?=$row["kor"]; ?> size="5" 
					class="form-control form-control-sm" 
					onChange="cal_score();">
			</div>
		</td>
	</tr>
	<tr>
		<td class="mycolor2">영어</td>
		<td align="left">
			<div class="d-inline-flex">
				<input type="text" name="eng" value=<?=$row["eng"]; ?> size="5" 
					class="form-control form-control-sm" 
						onChange="cal_score();">
			</div>
		</td>
	</tr>
	<tr>
		<td class="mycolor2">수학</td>
		<td align="left">
			<div class="d-inline-flex">
				<input type="text" name="mat" value=<?=$row["mat"]; ?> size="5" 
					class="form-control form-control-sm" 
					onChange="cal_score();">
			</div>
		</td>
	</tr>
	<tr>
		<td class="mycolor2"> 총점</td>
		<td align="left">&nbsp; 
			<div class="d-inline-flex">
				 <input type="text" name="hap" value=<?=$row["hap"]; ?>  size="5" 
					class="form-control-plaintext form-control-sm" readonly 
					onfocus="form1.name.focus()">
			</div>
		</td>
	</tr>
	<tr>
		<td class="mycolor2"> 평균</td>
		<td align="left">&nbsp; 
			<div class="d-inline-flex">
				 <input type="text" name="avg" value="<?=$row["avg"]; ?>" size="5" 
					class="form-control-plaintext form-control-sm" 
					onfocus="form1.name.focus()" readonly>
			</div>
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

