<?php
include "../common.php"; // 데이터베이스 연결 포함

$id = $_REQUEST['id'];
$state = $_REQUEST['state'];

// 데이터베이스에서 주문 상태 업데이트
$sql = "UPDATE jumun SET state='$state' WHERE id='$id'";

if (!mysqli_query($db, $sql)) {
    die("에러: " . mysqli_error($db));
}

// 리디렉션
header("Location: jumun.php");
exit;
?>
