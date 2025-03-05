<?php
    include "common.php";

    $id = $_REQUEST["id"];   

    $sql = "DELETE FROM juso WHERE id = $id";
    $result = mysqli_query($db, $sql); 
    if (!$result) {
        exit("에러: " . mysqli_error($db));
    }

    echo("<script>location.href='juso_list.php'</script>");
?>
