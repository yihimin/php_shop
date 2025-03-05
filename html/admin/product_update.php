<?php
include "../common.php";

$id = $_REQUEST["id"]; // 수정할 제품의 ID를 가져옵니다.

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
$fname1 = $_REQUEST["imagename1"];
$fname2 = $_REQUEST["imagename2"];
$fname3 = $_REQUEST["imagename3"];
$checkno1 = $_REQUEST["checkno1"];
$checkno2 = $_REQUEST["checkno2"]; 
$checkno3 = $_REQUEST["checkno3"];

// 이미지 1 삭제 체크
if ($checkno1 == "1") {
    // 삭제 체크인 경우 기존 파일 삭제
    if (!empty($fname1)) {
        unlink("../product/" . $fname1);
    }
    $fname1 = ""; // 파일명 초기화
} elseif ($_FILES["image1"]["error"] == 0) {
    // 파일 업로드 처리 로직
    $fname1 = $_FILES["image1"]["name"];    
    // 이미지 파일이 올바르게 업로드되었는지 확인
    if (move_uploaded_file($_FILES["image1"]["tmp_name"], "../product/" . $fname1)) {
        // 같은 파일명이 존재할 경우, 새로운 유니크한 파일 이름 생성
        $newfname1 = $fname1;
        while (file_exists("../product/" . $newfname1)) {
            $newfname1 = uniqid() . '_' . $fname1;
        }
        // 파일명 업데이트
        if (!rename("../product/" . $fname1, "../product/" . $newfname1)) {
            exit("파일명 업데이트 실패");
        }
        $fname1 = $newfname1; // 새로 생성된 파일명으로 업데이트
    } else {
        exit("이미지 파일 업로드 실패");
    }
}

// 이미지 2 삭제 체크
if ($checkno2 == "1") {
    // 삭제 체크인 경우 기존 파일 삭제
    if (!empty($fname2)) {
        unlink("../product/" . $fname2);
    }
    $fname2 = ""; // 파일명 초기화
} elseif ($_FILES["image2"]["error"] == 0) {
    // 파일 업로드 처리 로직
    $fname2 = $_FILES["image2"]["name"];    
    // 이미지 파일이 올바르게 업로드되었는지 확인
    if (move_uploaded_file($_FILES["image2"]["tmp_name"], "../product/" . $fname2)) {
        // 같은 파일명이 존재할 경우, 새로운 유니크한 파일 이름 생성
        $newfname2 = $fname2;
        while (file_exists("../product/" . $newfname2)) {
            $newfname2 = uniqid() . '_' . $fname2;
        }
        // 파일명 업데이트
        if (!rename("../product/" . $fname2, "../product/" . $newfname2)) {
            exit("파일명 업데이트 실패");
        }
        $fname2 = $newfname2; // 새로 생성된 파일명으로 업데이트
    } else {
        exit("이미지 파일 업로드 실패");
    }
}

// 이미지 3 삭제 체크
if ($checkno3 == "1") {
    // 삭제 체크인 경우 기존 파일 삭제
    if (!empty($row['image3'])) {
        unlink("../product/" . $row['image3']);
    }
    $fname3 = ""; // 파일명 초기화가 아닌 빈 문자열을 할당
} elseif ($_FILES["image3"]["error"] == 0) {
    // 파일 업로드 처리 로직
    $fname3 = $_FILES["image3"]["name"];    
    // 이미지 파일이 올바르게 업로드되었는지 확인
    if (move_uploaded_file($_FILES["image3"]["tmp_name"], "../product/" . $fname3)) {
        // 같은 파일명이 존재할 경우, 새로운 유니크한 파일 이름 생성
        $newfname3 = $fname3;
        while (file_exists("../product/" . $newfname3)) {
            $newfname3 = uniqid() . '_' . $fname3;
        }
        // 파일명 업데이트
        if (!rename("../product/" . $fname3, "../product/" . $newfname3)) {
            exit("파일명 업데이트 실패");
        }
        $fname3 = $newfname3; // 새로 생성된 파일명으로 업데이트
    } else {
        exit("이미지 파일 업로드 실패");
    }
}



$sql = "UPDATE product SET menu= $menu, code = '$code', name = '$name', coname = '$coname',
        price = $price, opt1 = $opt1, opt2 = $opt2, contents = '$contents',
        status = $status, regday = '$regday', icon_new = $icon_new,
        icon_hit = $icon_hit, icon_sale = $icon_sale, discount = $discount,
        image1 = '$fname1', image2 = '$fname2', image3 = '$fname3'
        WHERE id= $id";
$result = mysqli_query($db, $sql);
if (!$result) {
    exit("에러: " . mysqli_error($db) . $sql ); // 에러 메시지 표시
}

echo("<script>location.href='product.php'</script>");
?>
