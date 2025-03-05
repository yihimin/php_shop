

<?
   include "common.php";
    $text1 = $_REQUEST["text1"] ? $_REQUEST["text1"] : "";

    $sql = "select * from sj where name like '%$text1%' order by name ";     // sql 정의
    $args = "text1=$text1";         // args 정의
    $result = mypagination($sql, $args, $count, $pagebar);    // 함수 호출
?>





<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SJ</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	
<br>

<form name="form1" method="post" action="sj_list.php">
<div class="row">
	<div class="col-3" align="left">
		<div class="d-inline-flex">
			<div class="input-group input-group-sm">
				<span class="input-group-text">이름</span>
				<input type="text" name="text1" value="<?=$text1; ?>" class="form-control" 
					onKeydown="if (event.keyCode == 13) { form1.submit(); }"> 
				<button class="btn mycolor1" type="button" 
					onClick="form1.submit();">검색</button>
			</div>
		</div>
	</div>
	<div class="col-9" align="right">
		<a href="sj_new.html" class="btn btn-sm mycolor1">추가</a>
	</div>
<div>
</form>

<table class="table table-sm table-bordered table-hover mymargin5">
	
<tr>
		<td class="mycolor2">ID</td>
		<td class="mycolor2" width="20%">이름</td>
		<td class="mycolor2">국어</td>
		<td class="mycolor2">영어</td>
		<td class="mycolor2">수학</td>
		<td class="mycolor2">총점</td>
		<td class="mycolor2">평균</td>
		<td class="mycolor2" width="15%">수정/삭제</td>
</tr>
    <?
        foreach ($result as $row)
        {
            $id=$row["id"];
            $avg=sprintf("%6.1f",$row["avg"]);
    ?>
<tr>
       <td><?=$id; ?></td>
       <td><?=$row["name"]; ?></td>
       <td><?=$row["kor"]; ?></td>
       <td><?=$row["eng"]; ?></td>
       <td><?=$row["mat"]; ?></td>
       <td><?=$row["hap"]; ?></td>
       <td><?=$avg; ?></td>
    	<td>
			<a href="sj_edit.php?id=<?=$id;?>"
				class="btn btn-sm btn-outline-primary py-0 my-0">수정</a>
			<a href="sj_delete.php?id=<?=$id;?>" 
				class="btn btn-sm btn-outline-danger py-0 my-0"
				onClick="return confirm('삭제할까요 ?');">삭제</a>
		</td>
</tr >
    <?
        }
    ?>

</table>

<?
    echo  $pagebar;   // pagination bar 표시
?>

</div>

</body>
</html>
