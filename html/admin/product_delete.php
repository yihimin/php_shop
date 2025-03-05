<?php
    include "../common.php";

    $id = $_REQUEST["id"];   

    $sql = "DELETE FROM product WHERE id = $id";
    $result = mysqli_query($db, $sql); 
	if (!$result) {
		exit("에러: $sql");
	}

    echo("<script>location.href='product.php'</script>");
?>