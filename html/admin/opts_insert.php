<?php
include "../common.php"; // DB 연결

// 사용자가 입력한 값을 안전하게 가져옵니다.
$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
$name = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

// SQL 쿼리 실행
$sql_sub = "INSERT INTO opts (id, opt_id, name) 
            VALUES (null, $id, '$name')";       

$result_sub = mysqli_query($db, $sql_sub);

if (!$result_sub) {
    exit("에러: " . mysqli_error($db)); // 쿼리 실행 오류 시 에러 메시지를 출력합니다.
}

echo("<script>location.href='opts.php?id=$id'</script>"); 
?>
