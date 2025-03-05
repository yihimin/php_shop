<?php
    include "common.php";

    $uid = $_REQUEST["uid"];
    $pwd = $_REQUEST["pwd"];

    $sql = "SELECT id FROM member WHERE uid='$uid' AND pwd='$pwd'";
    $result = mysqli_query($db, $sql); // mysqli_query 함수를 호출할 때 데이터베이스 연결 객체를 제공
    if (!$result) exit("에러: $sql "); //에러 처리

    $row = mysqli_fetch_array($result); //레코드 읽기
    $count = mysqli_num_rows($result); // 결과 레코드 수를 얻음
        if ($count > 0) {
            // 사용자가 있는 경우
            // 고객번호인 id를 쿠키로 저장
            setcookie("cookie_id", $row["id"]);
            // 메인 페이지로 이동
            echo("<script>location.href='index.html'</script>");
        } else {
            // 사용자가 없는 경우
            // 로그인 화면으로 이동
            echo("<script>location.href='member_login.php'</script>");
        }
?>
