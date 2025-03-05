
<?
   include "common.php";
    $text1 = $_REQUEST["text1"] ? $_REQUEST["text1"] : "";

    $sql = "select * from juso where name like '%$text1%' order by name ";     // sql 정의 --> juso
    $args = "text1=$text1";         // args 정의
    $result = mypagination($sql, $args, $count, $pagebar);    // 함수 호출
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
	
<form name="form1" method="post" action="juso_list.php">
<div class="row">
	<div class="col-3" align="left">
		<div class="input-group input-group-sm">
			<span class="input-group-text">이름</span>
			<input type="text" name="text1" value="<?=$text1; ?>" class="form-control"> 
			<button class="btn mycolor1" onclick="form1.submit();">검색</button>
		</div>
	</div>
	<div class="col-9" align="right">
		<a href="juso_new.html" class="btn btn-sm mycolor1">추가</a>
	</div>
</div>
</form>

<table class="table table-sm table-bordered table-hover mymargin5">
	<tr class="mycolor2">
		<td>ID</td>
		<td>이름</td>
		<td>전화</td>
		<td>음/양</td>
		<td>생일</td>
		<td>주소</td>
		<td width="15%">수정 / 삭제</td>
	</tr>
	<?
        foreach ($result as $row)
        {
             $id=$row["id"];
			 
			 //양력, 음력 출력
			 if ($row["sm"]==0) {$sm="양력";} 
			 else {  $sm="음력";} 

			 // 전화번호 토막내기
			 $tel1 = trim(substr($row["tel"], 0, 3)); // 0번 위치에서 3자리 문자열 추출
			 $tel2 = trim(substr($row["tel"], 3, 4)); // 3번 위치에서 4자리
			 $tel3 = trim(substr($row["tel"], 7, 4)); // 7번 위치에서 4자리
			 
			 // 전화번호 조합
			 $tel = $tel1 . "-" . $tel2 . "-" . $tel3;
    ?>
	<tr>
       <td><?=$id; ?></td>
       <td><?=$row["name"]; ?></td>
       <td><?= $tel;?></td>
       <td><?=$sm;?></td>
	   <td><?=$row["birthday"];?></td>
       <td align="left";><?=$row["juso"]; ?></td>
       <td>
			<a href="juso_edit.php?id=<?=$id;?>"
				class="btn btn-sm btn-outline-primary py-0 my-0">수정</a>
			<a href="juso_delete.php?id=<?=$id;?>" 
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

