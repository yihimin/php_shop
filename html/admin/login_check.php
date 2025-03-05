<?php
include '../common.php';

// 사용자가 입력한 아이디와 비밀번호
$adminid = $_POST['adminid'];
$adminpw = $_POST['adminpw'];

// 관리자 아이디와 비밀번호 확인
if ($adminid == $admin_id && $adminpw == $admin_pw) {
    // 입력된 아이디와 비밀번호가 일치하는 경우

    // 쿠키 설정
    setcookie("cookie_admin", "yes"); 

    // 관리자 페이지로 이동
    header("Location: member.php");
    exit;
} else {
    // 입력된 아이디와 비밀번호가 일치하지 않는 경우

    // 쿠키 삭제
    setcookie("cookie_admin", ""); // 즉시 만료

    // 인덱스 페이지로 이동
    header("Location: index.html");
    exit;
}
?>
