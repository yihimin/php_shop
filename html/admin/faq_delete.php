<?php
include "../common.php"; 

$id = $_GET['id'];

$sql = "DELETE FROM faq WHERE id=$id";
if (mysqli_query($db, $sql)) {
    header("Location: faq.php");
} else {
    echo "에러: " . mysqli_error($db);
}
?>
