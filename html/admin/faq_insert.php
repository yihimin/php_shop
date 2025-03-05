<?php
include "../common.php"; 

$title = $_POST['title'];
$contents = $_POST['contents'];

$sql = "INSERT INTO faq (title, contents) VALUES ('$title', '$contents')";
if (mysqli_query($db, $sql)) {
    header("Location: faq.php");
} else {
    echo "에러: " . mysqli_error($db);
}
?>
