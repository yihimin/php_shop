<?php
include "../common.php"; // DB 연결

// 사용자가 입력한 값을 안전하게 가져옵니다.
$menu = $_REQUEST["menu"];
$code = addslashes($_REQUEST["code"]);
$name = addslashes($_REQUEST["name"]);
$coname = addslashes($_REQUEST["coname"]);
$price = $_REQUEST["price"];
$opt1 = isset($_REQUEST["opt1"]) && $_REQUEST["opt1"] !== "" ? $_REQUEST["opt1"] : 0;
$opt2 = isset($_REQUEST["opt2"]) && $_REQUEST["opt2"] !== "" ? $_REQUEST["opt2"] : 0;
$contents = addslashes($_REQUEST["contents"]);
$status = $_REQUEST["status"];
$regday = $_REQUEST["regday"];
$icon_new = isset($_REQUEST["icon_new"]) && $_REQUEST["icon_new"] !== "" ? $_REQUEST["icon_new"]: 0;
$icon_hit = isset($_REQUEST["icon_hit"]) && $_REQUEST["icon_hit"] !== "" ? $_REQUEST["icon_hit"] : 0;
$icon_sale = isset($_REQUEST["icon_sale"]) && $_REQUEST["icon_sale"] !== "" ? $_REQUEST["icon_sale"] : 0;
$discount = isset($_REQUEST["discount"]) && $_REQUEST["discount"] !== "" ? $_REQUEST["discount"] : 0;
    
if ($_FILES["image1"]["error"] == 0) {
    $fname1 = $_FILES["image1"]["name"];
    $fsize1 = $_FILES["image1"]["size"];
    // 새로운 파일 이름 생성
    $newfname1 = $fname1;
    // 같은 파일명이 존재할 경우, 새로운 유니크한 파일 이름 생성
    while (file_exists("../product/" . $newfname1)) {
        $newfname1 = uniqid() . '_' . $fname1;
    }
    if (!move_uploaded_file($_FILES["image1"]["tmp_name"], "../product/" . $newfname1))
        exit("이미지1 업로드 실패");

    echo("이미지1 파일이름 : $newfname1<br> 이미지1 파일크기 : $fsize1<br>");
}

if ($_FILES["image2"]["error"] == 0) {
    $fname2 = $_FILES["image2"]["name"];
    $fsize2 = $_FILES["image2"]["size"];
    // 새로운 파일 이름 생성
    $newfname2 = $fname2;
    // 같은 파일명이 존재할 경우, 새로운 유니크한 파일 이름 생성
    while (file_exists("../product/" . $newfname2)) {
        $newfname2 = uniqid() . '_' . $fname2;
    }
    if (!move_uploaded_file($_FILES["image2"]["tmp_name"], "../product/" . $newfname2))
        exit("이미지2 업로드 실패");

    echo("이미지2 파일이름 : $newfname2<br> 이미지2 파일크기 : $fsize2<br>");
}

if ($_FILES["image3"]["error"] == 0) {
    $fname3 = $_FILES["image3"]["name"];
    $fsize3 = $_FILES["image3"]["size"];
    // 새로운 파일 이름 생성
    $newfname2 = $fname2;
    // 같은 파일명이 존재할 경우, 새로운 유니크한 파일 이름 생성
    while (file_exists("../product/" . $newfname3)) {
        $newfname3 = uniqid() . '_' . $fname3;
    }
    if (!move_uploaded_file($_FILES["image3"]["tmp_name"], "../product/" . $newfname3))
        exit("이미지3 업로드 실패");

    echo("이미지3 파일이름 : $newfname3<br> 이미지3 파일크기 : $fsize3<br>");
}
// SQL 쿼리 실행
$sql = "INSERT INTO product (menu, code, name, coname, price, opt1, opt2, contents, status, regday, icon_new, icon_hit, icon_sale, discount, image1, image2, image3) 

VALUES ('$menu', '$code', '$name', '$coname', '$price', '$opt1', '$opt2', '$contents', '$status', '$regday', '$icon_new', '$icon_hit', '$icon_sale', '$discount', '$newfname1', '$newfname2', '$newfname3')";       

$result = mysqli_query($db, $sql);

if (!$result) {
    exit("에러: " . mysqli_error($db)); // 쿼리 실행 오류 시 에러 메시지를 출력합니다.
}

echo("<script>location.href='product.php'</script>"); 
?>
