<?php
include "../common.php"; // 데이터베이스 연결 포함

$id = $_REQUEST['id'];

// jumuns 테이블에서 해당 주문과 관련된 레코드 삭제
$sql_jumuns = "DELETE FROM jumuns WHERE jumun_id='$id'";

if (!mysqli_query($db, $sql_jumuns)) {
    die("Query Error: " . mysqli_error($db));
}

// 이후 jumun 테이블에서 주문 삭제
$sql_jumun = "DELETE FROM jumun WHERE id='$id'";

if (!mysqli_query($db, $sql_jumun)) {
    die("Query Error: " . mysqli_error($db));
}

header("Location: jumun.php");
exit;
?>
