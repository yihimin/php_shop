<?php
include "../common.php"; 

// 날짜 설정
$day1 = $_REQUEST["day1"] ? $_REQUEST["day1"] : date("Y-m-d", strtotime("-1 month"));
$day2 = $_REQUEST["day2"] ? $_REQUEST["day2"] : date("Y-m-d");

// 검색 옵션 설정
$sel1 = $_REQUEST["sel1"] ?? "0";
$sel2 = $_REQUEST["sel2"] ?? "1";
$text1 = $_REQUEST["text1"] ?? "";

// 필터링 조건을 생성합니다.
$conditions = array();
if ($sel1 != "0") {
    $conditions[] = "state = '$sel1'";
}
if ($sel2 == "1" && $text1 != "") {
    $conditions[] = "id LIKE '%$text1%'";
} elseif ($sel2 == "2" && $text1 != "") {
    $conditions[] = "o_name LIKE '%$text1%'";
} elseif ($sel2 == "3" && $text1 != "") {
    $conditions[] = "product_names LIKE '%$text1%'";
}

$where = "";
if (!empty($conditions)) {
    $where = "AND " . implode(" AND ", $conditions);
}

// SQL 쿼리 작성
$sql = "SELECT * FROM jumun WHERE jumunday BETWEEN '$day1' AND '$day2' $where ORDER BY id DESC";

$result = mypagination($sql, $args, $count, $pagebar); //이렇게 써야 페이지바 표시
if (!$result) {
    exit("에러: $sql");
}

$args = "day1=$day1&day2=$day2&sel1=$sel1&sel2=$sel2&text1=$text1";
?>
 
<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Life with Dog</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/my.css" rel="stylesheet">
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->    
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->    

<script>
    function go_update(id, pos) {
        var form = document.forms['form1'];
        var state = form.elements['state[]'][pos].value;
        location.href = "jumun_update.php?id=" + id + "&state=" + state + "&page=" + form.page.value +
            "&sel1=" + form.sel1.value + "&sel2=" + form.sel2.value + "&text1=" + form.text1.value +
            "&day1=" + form.day1.value + "&day2=" + form.day2.value;
    }
</script>

<div class="row mx-1 justify-content-center">
    <div class="col" align="center">

        <h4 class="m-0 mb-3">주문</h4>

        <form name="form1" method="post" action="jumun.php">
        <input type="hidden" name="page" value=<?=$page?>>
        
        <table class="table table-sm table-borderless m-0 p-0">
            <tr>
                <td width="20%" align="left" style="padding-top:8px">
                    주문수 : <font color="red"><?php echo $count; ?></font>
                </td>
                <td align="right">
                
                    기간:
                    <div class="d-inline-flex">
                        <input type="date" name="day1" value="<?=$day1?>" 
                            class="form-control form-control-sm"  style="width:120px" >~
                        <input type="date" name="day2" value="<?=$day2?>" 
                            class="form-control form-control-sm" style="width:120px" >
                    </div>
                    <div class="d-inline-flex">
                        <select name="sel1" class="form-select form-select-sm bg-light myfs12" style="width:100px">
                            <option value="0" <?= $sel1 == "0" ? "selected" : "" ?>>전체</option>
                            <option value="1" <?= $sel1 == "1" ? "selected" : "" ?>>주문신청</option>
                            <option value="2" <?= $sel1 == "2" ? "selected" : "" ?>>주문확인</option>
                            <option value="3" <?= $sel1 == "3" ? "selected" : "" ?>>입금확인</option>
                            <option value="4" <?= $sel1 == "4" ? "selected" : "" ?>>배달중</option>
                            <option value="5" <?= $sel1 == "5" ? "selected" : "" ?>>주문완료</option>
                            <option value="6" <?= $sel1 == "6" ? "selected" : "" ?>>주문취소</option>
                        </select>&nbsp;
                        <select name="sel2" class="form-select bg-light myfs12" style="width:105px">
                            <option value="1" <?= $sel2 == "1" ? "selected" : "" ?>>주문번호</option>
                            <option value="2" <?= $sel2 == "2" ? "selected" : "" ?>>고객명</option>
                            <option value="3" <?= $sel2 == "3" ? "selected" : "" ?>>상품명</option>
                        </select>
                    </div>
                    <div class="d-inline-flex">
                        <div class="input-group input-group-sm">
                            <input type="text" name="text1" value="<?= $text1 ?>" 
                                class="form-control myfs12" style="width:100px" 
                                onKeydown="if (event.keyCode == 13) { form1.submit(); }"> 
                            <button class="btn mycolor1 myfs12" type="button" 
                                onClick="form1.submit();">검색</button>
                        </div>
                    </div>
                    
                </td>
            </tr>
        </table>
        
        <table class="table table-sm table-bordered table-hover my-1">
            <tr class="bg-light">
                <td >주문번호</td>
                <td >주문일</td>
                <td width="20%" >제품명</td>
                <td width="5%">제품수</td>
                <td>금액</td>
                <td>주문자</td>
                <td width="5%">결제</td>
                <td width="20%">주문상태</td>
                <td width="5%">삭제</td>
            </tr>
            <?php
            $pos = 0; // state 인덱스를 위한 변수
            foreach ($result as $row) {
                $id = $row["id"];
            ?>
                <tr>
                    <td class="mywordwrap">
                        <a href="jumun_info.php?id=<?= $id; ?>" style="color:#0085dd"><?= $id ?></a>
                    </td>
                    <td><?= $row["jumunday"] ?></td>
                    <td align="left" class="mywordwrap"><?= $row["product_names"] ?></td>
                    <td><?= $row["product_nums"] ?></td>
                    <td align="right" class="mywordwrap">
                        <?= number_format($row["total_cash"]) ?>
                    </td>
                    <td><?= $row["o_name"] ?></td>
                    <td>
                        <?php
                        if ($row["pay_kind"] == 1) {
                            echo "무통장";
                        } else {
                            echo "카드";
                        }
                        ?>
                    </td>
                    <td>
                        <div class="d-sm-inline-flex">
                            <?php
                            $state = $row["state"];
                            $color = "black";
                            if ($state == 5) $color = "blue";  // 주문완료=5
                            if ($state == 6) $color = "red";   // 주문취소=6
                            echo "<select name='state[]' style='font-size:9pt; color:$color' class='form-select form-select-sm myfs12 me-1'>";
                            for ($i = 1; $i < count($a_state); $i++) {
                                $selected = ($state == $i) ? "selected" : "";
                                $optionColor = "black";
                                if ($i == 5) $optionColor = "blue"; // 주문완료
                                if ($i == 6) $optionColor = "red";  // 주문취소
                                echo "<option value='$i' $selected style='color:$optionColor;'>{$a_state[$i]}</option>";
                            }
                            echo "</select>";
                            ?>
                            <a href="javascript:go_update('<?= $id ?>', <?= $pos ?>);" class="btn btn-sm mybutton-blue" style="width:50px;">수정</a>
                        </div>
                    </td>
                    <td>
                        <a href="jumun_delete.php?id=<?= $id; ?>" class="btn btn-sm mybutton-red" onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>
                    </td>
                </tr>
            <?php
                $pos++;
            }
            ?>
        </table>

        <input type="hidden" name="state">    
        
        </form>

        <?php echo $pagebar; ?>

    </div>
</div>
<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
