<?php
    include "../common.php"; 

    setcookie("user_id", "");

    //변수가 앞서 정의 되어야 함    
    $text1 = isset($_REQUEST["text1"]) ? $_REQUEST["text1"] : "";
    $sel1 = isset($_REQUEST["sel1"]) ? $_REQUEST["sel1"] : 1;

    // 검색 조건에 따라 WHERE 절을 조합합니다. 검색에 따라 회원수:를 조절하기 위해
    if ($sel1 == 1) {
        $where_condition = "name LIKE '%$text1%'";
    } else {
        $where_condition = "uid LIKE '%$text1%'";
    }

    // 검색 조건에 따라 회원 수를 조회하는 쿼리를 실행합니다.
    $sql = "SELECT COUNT(*) AS total_members FROM member WHERE $where_condition";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_members = $row['total_members'];

    // 검색 결과에 따라 회원 목록을 조회하는 쿼리를 실행합니다.
    if ($sel1 == 1) {
        $sql = "SELECT * FROM member WHERE name LIKE '%$text1%' ORDER BY name";
    } else {
        $sql = "SELECT * FROM member WHERE uid LIKE '%$text1%' ORDER BY name";
    }

    $args = "text1=$text1&sel1=$sel1"; // args 정의
    $result = mypagination($sql, $args, $count, $pagebar); // 함수 호출

    $row = mysqli_fetch_array($result); // 1레코드 읽기
?>

<!doctype html>
<html lang="kr">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>INDUK Mall</title>
 <link  href="../css/bootstrap.min.css" rel="stylesheet">
 <link  href="../css/my.css" rel="stylesheet">
 <script src="../js/jquery-3.7.1.min.js"></script>
 <script src="../js/bootstrap.bundle.min.js"></script>
 <script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!--------------------------------------------------------------------------------------------> 
<script> document.write(admin_menu());</script>
<!--------------------------------------------------------------------------------------------> 

<div class="row mx-1 justify-content-center">
 <div class="col" align="center">

 <h4 class="m-0 mb-2">회원</h4>

 <form name="form1" method="post" action="member.php">
 
 <table class="table table-sm table-borderless m-0">
  <tr>
   <td align="left" style="padding-top:12px">
   &nbsp;회원수 : <font color="red"><?php echo $total_members; ?></font>
   </td>
   <td align="right">
				<div class="d-inline-flex">
					<div class="input-group input-group-sm">
						<select name="sel1" class="form-select form-select-sm bg-light myfs12" style="width:92px;"> 
                        <option value="1" <?php if($sel1 == 1) { echo "selected"; } ?>>이름</option>
                        <option value="2" <?php if($sel1 == 2) { echo "selected"; } ?>>아이디</option>
						</select>
						<input type="text" name="text1" value="<?php echo $text1; ?>"   style="width:100px;" 
							class="form-control myfs12" 
							onKeydown="if (event.keyCode == 13) { form1.submit(); }"> 
						<button class="btn mycolor1 myfs12" type="button"  
							onClick="form1.submit();">검색</button>
					</div>
				</div>
    
   </td>
  </tr>
 </table>
 
 </form>

 <table class="table table-sm table-bordered table-hover m-0 mb-1">
  <tr class="bg-light">
   <td>아이디</td>
   <td>이름</td>
   <td>핸드폰</td>
   <td>E-Mail</td>
   <td width="10%">구분</td>
   <td width="15%">수정 / 삭제</td>
  </tr>
  <?
        foreach ($result as $row)
        {
             $id=$row["id"];

			 // 전화번호 토막내기
			 $tel1 = trim(substr($row["tel"], 0, 3)); // 0번 위치에서 3자리 문자열 추출
			 $tel2 = trim(substr($row["tel"], 3, 4)); // 3번 위치에서 4자리
			 $tel3 = trim(substr($row["tel"], 7, 4)); // 7번 위치에서 4자리
			 
			 // 전화번호 조합
			 $tel = $tel1 . "-" . $tel2 . "-" . $tel3;
    ?>
    <tr>
       <td><?=$row["uid"]; ?></td>
       <td><?=$row["name"]; ?></td>
       <td><?= $tel;?></td>
       <td align="left"  class="px-2";><?=$row["email"]; ?></td>
       <td><?php echo ($row["gubun"] == 0) ? "회원" : "탈퇴"; ?></td>
       <td>
			<a href="member_edit.php?id=<?=$id;?>"
                class="btn btn-sm btn-outline-info mybutton-blue">수정</a>
			<a href="member_delete.php?id=<?=$id;?>" 
            class="btn btn-sm btn-outline-danger mybutton-red" 
				onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>
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
</div>
<!--------------------------------------------------------------------------------------------> 
</div>

</body>
</html>