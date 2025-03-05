<?php
$name = $_POST['name'];
$email = $_POST['email'];

// 쿠키 설정 (유효 기간은 30일로 설정)
setcookie('guest_name', $name);
setcookie('guest_email', $email);

// 주문 조회 페이지로 리디렉션
header('Location: jumun.php');
exit();
?>