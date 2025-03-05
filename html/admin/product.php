<?
    include "../common.php"; // 공통 파일을 포함하여 데이터베이스에 연결합니다.

    // GET 매개변수를 확인하여 값이 없는 경우에는 각 변수를 0 또는 빈 문자열로 초기화합니다.
    $sel1 = isset($_REQUEST['sel1']) ? $_REQUEST['sel1'] : 0;
    $sel2 = isset($_REQUEST['sel2']) ? $_REQUEST['sel2'] : 0;
    $sel3 = isset($_REQUEST['sel3']) ? $_REQUEST['sel3'] : 0;
    $sel4 = isset($_REQUEST['sel4']) ? $_REQUEST['sel4'] : 1;
    $text1 = isset($_REQUEST['text1']) ? $_REQUEST['text1'] : '';
 
    $k=0; // 조건 배열에 대한 인덱스 변수를 초기화합니다.

  // 필터링 조건을 생성합니다.
    $s = array();
    if ($sel1 != 0) { $s[$k++] = "status=" . $sel1; }
    if ($sel2 == 1) { $s[$k++] = "icon_new=1"; }
    elseif ($sel2 == 2) { $s[$k++] = "icon_hit=1"; }
    elseif ($sel2 == 3) { $s[$k++] = "icon_sale=1"; }
    if ($sel3 != 0) { $s[$k++] = "menu=" . $sel3; }

    // 제품명 또는 코드에 대한 검색어가 있는 경우 해당 검색어를 기준으로 조건을 추가합니다.
    if ($text1) {
        if ($sel4 == 1) { $s[$k++] = "name like '%" . $text1 . "%'"; } //이름으로 검색
        elseif ($sel4 == 2) { $s[$k++] = "code like '%" . $text1 . "%'"; } //코드로 검색
    }

    // 조건 배열을 AND 연산자로 결합하여 최종 WHERE 절을 생성합니다.
    $where = '';
    if ($k > 0) {
        $where = " WHERE " . implode(" AND ", $s);
    }

    // 최종 SQL 쿼리를 생성합니다. 필터링 조건이 있는 경우 해당 조건을 포함하여 제품을 가져옵니다.
    $sql = "SELECT * FROM product" . $where . " ORDER BY name";

    // SQL 쿼리를 실행하고 결과를 변수에 저장합니다.
    $result = mysqli_query($db, $sql);
    $result = mypagination($sql, $args, $count, $pagebar); //이렇게 써야 페이지바 표시
	if (!$result) {
		exit("에러: $sql");
	}
    // SQL 쿼리 실행이 실패한 경우 에러 메시지를 표시하고 종료합니다.
    if (!$result) {
        exit("에러: " . mysqli_error($db));
    }

    // 필터링에 사용된 인자들을 문자열로 생성하여 변수에 저장합니다.
    $args = "sel1=$sel1&sel2=$sel2&sel3=$sel3&sel4=$sel4&text1=$text1";
?>


<!doctype html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>INDUK Mall</title>
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

<div class="row mx-1  justify-content-center">
	<div class="col" align="center">

	<h4 class="m-0 mb-3">제품</h4>
	
	<form name="form1" method="post" action="product.php">
	
	<table class="table table-sm table-borderless m-0 p-0">
		<tr>
			<td width="20%" align="left" style="padding-top:8px">
                제품수 : <font color="red"><?php echo $count; ?></font>
			</td>
			<td align="right">
				<div class="d-inline-flex">
					<!-- 각 sel에 해당하는 셀렉트 박스를 생성합니다. -->
                    <?php
                    echo("<select name='sel1' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=0;$i<$n_status;$i++)
                    {
                        $tmp = ($i==$sel1) ? "selected" : "";
                        echo("<option value='$i' $tmp>$a_status[$i]</option>");
                    }
                    echo("</select>");
                    ?>
				</div>
				<div class="d-inline-flex">
                    <?php
                    echo("<select name='sel2' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=0;$i<$n_icon;$i++)
                    {
                        $tmp = ($i==$sel2) ? "selected" : "";
                        echo("<option value='$i' $tmp>$a_icon[$i]</option>");
                    }
                    echo("</select>");
                    ?>&nbsp;
                </div>
                <div class="d-inline-flex">
                    <?php
                    echo("<select name='sel3' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=0;$i<$n_menu;$i++)
                    {
                        $tmp = ($i==$sel3) ? "selected" : "";
                        echo("<option value='$i' $tmp>$a_menu[$i]</option>");
                    }
                    echo("</select>");
                    ?>&nbsp;
					<?php
                    echo("<select name='sel4' class='form-select form-select-sm bg-light myfs12' style='width:100px'>");
                    for($i=1;$i<$n_text1;$i++)
                    {
                        $tmp = ($i==$sel4) ? "selected" : "";
                        echo("<option value='$i' $tmp>$a_text1[$i]</option>");
                    }
                    echo("</select>");
                    ?>
				</div>
				<div class="d-inline-flex">
					<div class="input-group input-group-sm">
                        <!-- 검색어 남아있게 코딩 -->
						<input type="text" name="text1" value="<? echo $text1; ?>" size="10" 
							class="form-control myfs12" 
							onKeydown="if (event.keyCode == 13) { form1.submit(); }"> 
						<button class="btn mycolor1 myfs12" type="button" 
							onClick="form1.submit();">검색</button>&nbsp;&nbsp;
					</div>
				</div>
				<div class="d-inline-flex">
					<a href="product_new.php" class="btn btn-sm mycolor1 myfs12">추가</a>&nbsp;
				</div>
				
			</td>
		</tr>
	</table>
	
	</form>

	<table class="table table-sm table-bordered table-hover mb-1">
		<tr class="bg-light">
			<td width="10%">제품분류</td>
			<td width="10%">제품코드</td>
			<td width="35%">제품명</td>
			<td width="10%">판매가</td>
			<td width="10%">상태</td>
			<td width="15%">이벤트</td>
			<td width="10%">수정/삭제</td>
		</tr>
		<?php
        while ($row = mysqli_fetch_assoc($result)) {
            $id=$row["id"];
            $price=number_format($row['price']);
            // 데이터베이스 결과에 기반하여 테이블 행을 동적으로 출력
            echo "<tr>";
            echo "<td>" . $a_menu[$row['menu']] . "</td>"; //배열 이름으로 출력
            echo "<td>" . $row['code'] . "</td>";
            echo "<td align='left'>" . $row['name'] . "</td>";
            echo "<td align='right' class='px-2'>" . $price . "</td>";
            echo "<td>" . $a_status[$row['status']] . "</td>"; //배열 이름으로 출력
            echo "<td>";
                if ($row['icon_new'] == 1) {
                    echo "New ";
                }
                if ($row['icon_hit'] == 1) {
                    echo "Hit ";
                }
                if ($row['icon_sale'] == 1) {
                    echo "Sale(". $row['discount'] . '%' . ")";
                }
            echo "</td>";

        ?>
            <td>
				<a href="product_edit.php?id=<?=$id;?>" class="btn btn-sm btn-outline-info mybutton-blue">수정</a>
				<a href="product_delete.php?id=<?=$id;?>" class="btn btn-sm btn-outline-danger mybutton-red" onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>				
			</td>
        <?
            echo "</tr>";
        }
        ?>
	</table>

    <?php echo $pagebar; ?>

	</div>
</div>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>