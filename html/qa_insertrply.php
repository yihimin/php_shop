<?php
include "common.php";

// 폼 데이터 가져오기
$title = $_POST['title'];
$name = $_POST['name'];
$passwd = $_POST['passwd'];
$contents = $_POST['contents'];
$parent_id = $_POST['id']; // 부모 글의 ID

// 부모 글의 pos1과 pos2 가져오기
$result = mysqli_query($db, "SELECT pos1, pos2 FROM qa WHERE id = '$parent_id'");
if (!$result || mysqli_num_rows($result) == 0) {
    echo "에러: 부모 글을 찾을 수 없습니다.";
    exit;
}
$parent = mysqli_fetch_assoc($result);
$parent_pos1 = $parent['pos1'];
$parent_pos2 = $parent['pos2'];

// 같은 부모 글의 답글 중 pos2의 최대값을 가져와서 다음 값을 설정
$result = mysqli_query($db, "SELECT MAX(pos2) AS max_pos2 FROM qa WHERE pos1 = '$parent_pos1' AND pos2 LIKE '$parent_pos2%'");
$row = mysqli_fetch_assoc($result);
if ($row['max_pos2']) {
    $new_pos2 = substr($row['max_pos2'], 0, strlen($parent_pos2)) . chr(ord(substr($row['max_pos2'], -1)) + 1);
} else {
    $new_pos2 = $parent_pos2 . 'A'; // 첫 답글일 경우
}

// 데이터베이스에 답글 삽입
$sql = "INSERT INTO qa (title, name, passwd, contents, pos1, pos2, writeday, count) 
        VALUES ('$title', '$name', '$passwd', '$contents', '$parent_pos1', '$new_pos2', NOW(), 0)";

if (mysqli_query($db, $sql)) {
    header("Location: qa.php");
} else {
    echo "에러: " . mysqli_error($db);
}
?>
