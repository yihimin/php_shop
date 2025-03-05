<?php
include "../common.php"; 

$id = $_POST['id'];
$title = $_POST['title'];
$contents = $_POST['contents'];

$sql = "UPDATE faq SET title='$title', contents='$contents' WHERE id=$id";
if (mysqli_query($db, $sql)) {
    header("Location: faq.php");
} else {
    echo "에러: " . mysqli_error($db);
}
?>
