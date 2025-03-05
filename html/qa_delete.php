<?php
include "common.php";

// 폼 데이터 가져오기
$id = $_POST['id'];
$passwd = $_POST['passwd'];

// 데이터베이스에서 해당 Q&A 항목의 비밀번호 가져오기
$sql = "SELECT passwd FROM qa WHERE id = $id";
$result = mysqli_query($db, $sql);
if (!$result) {
    echo "에러: " . mysqli_error($db);
    exit;
}
$row = mysqli_fetch_assoc($result);

if ($row['passwd'] === $passwd) {
    // 비밀번호가 일치하면 삭제
    $sql = "DELETE FROM qa WHERE id = $id";
    if (mysqli_query($db, $sql)) {
        header("Location: qa.php");
    } else {
        echo "에러: " . mysqli_error($db);
    }
} else {
    echo "<script>alert('비밀번호가 일치하지 않습니다.'); history.back();</script>";
}
?>
