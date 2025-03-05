<?php
include "common.php";

// 폼 데이터 가져오기
$title = $_POST['title'];
$name = $_POST['name'];
$passwd = $_POST['passwd'];
$contents = $_POST['contents'];

// pos1은 새로운 글이므로 최대값 + 1로 설정
$result = mysqli_query($db, "SELECT MAX(pos1) AS max_pos1 FROM qa");
$row = mysqli_fetch_assoc($result);
$pos1 = $row['max_pos1'] + 1;
$pos2 = 'A'; // 새로운 글의 pos2는 'A'로 시작

// 데이터베이스에 삽입
$sql = "INSERT INTO qa (title, name, passwd, contents, pos1, pos2, writeday, count) 
        VALUES ('$title', '$name', '$passwd', '$contents', '$pos1', '$pos2', NOW(), 0)";

if (mysqli_query($db, $sql)) {
    header("Location: qa.php");
} else {
    echo "에러: " . mysqli_error($db);
}
?>
