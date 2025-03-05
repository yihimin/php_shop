<?php
    include "../common.php";
	// URL에서 id 값을 읽어옵니다.
	$id = isset($_GET['id']) ? $_GET['id'] : '없음';

	// id 값을 기반으로 옵션 정보를 가져옵니다.
	$sql = "SELECT * FROM opt WHERE id=$id"; 
	$result = mysqli_query($db, $sql);
	if (!$result) {
		exit("에러: $sql");
	}

	$row = mysqli_fetch_array($result); // 1레코드 읽기
?>
<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Life with Dog</title>
	<link  href="../css/bootstrap.min.css" rel="stylesheet">
	<link  href="../css/my.css" rel="stylesheet">
	<script src="..js/jquery-3.7.1.min.js"></script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->	

<form name="form1" method="post" action="opt_update.php">

<input type="hidden" name="id" value="<?=$id;?>">

<div class="row mx-1  justify-content-center">
	<div class="col-sm-10" align="center">

		<h4 class="m-0 mb-3">옵션</h4>
		
		<table class="table table-sm table-bordered myfs12">
			<tr height="40">
				<td width="15%" class="bg-light">옵션 번호</td>
				<td align="left" class="ps-2"><?=$row["id"]; ?></td>
			</tr>
			<tr>
				<td width="15%" class="bg-light">옵션명</td>
				<td align="left" class="ps-2">
					<div class="d-inline-flex">
						<input type="text" name="name" size="30" value="<?=$row["name"]; ?>" class="form-control form-control-sm">
					</div>
				</td>
			</tr>
		</table>

		<a href="javascript:form1.submit();"  class="btn btn-sm btn-dark text-white my-2">&nbsp;저 장&nbsp;</a>&nbsp;
		<a href="javascript:history.back();"  class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

	</div>
</div>
<br>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>
