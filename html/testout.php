<!---------------------------------------------------------------------------------------------
	제목 : 내 손으로 만드는 PHP 쇼핑몰무 (실습용 디자인 HTML)

	소속 : 인덕대학교 컴퓨터소프트웨어학과
	이름 : 교수 윤형태 (2024.02)
---------------------------------------------------------------------------------------------->
<?
    $name1=$_REQUEST["name1"];  // $irum1=$_POST["name1"]; 
    $name2=$_REQUEST["name2"];  // $irum2=$_GET["name2"];
?>

<html>
<head>
	<meta charset="utf-8">
	<title>testout</title>
</head>
<body>

name1은 <font color="blue"><?= $name1; ?></font>입니다.
<br>
name2는 <font color="blue"><?= $name2; ?></font>입니다.
<br><br>
<a href="javascript:history.back();">돌아가기</a>
	
</body>
</html>


