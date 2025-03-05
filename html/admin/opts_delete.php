<?php
    include "../common.php";
    $id = $_REQUEST["id"];
    $id1 = $_REQUEST["id1"];   

    //$sql = "DELETE FROM opts WHERE name = '$id1'";
    $sql = "DELETE FROM opts WHERE id = $id1";
    $result = mysqli_query($db, $sql); 
	if (!$result) {
		exit("에러: $sql" . mysqli_error($db));
	}

    echo("<script>location.href='opts.php?id=$id'</script>"); 
?>