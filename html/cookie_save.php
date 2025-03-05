<?php
	$name = $_REQUEST["name"];
	setcookie("cookie_value", $name);
	echo("<script>location.href='cookie_view.php'</script>");
?>

