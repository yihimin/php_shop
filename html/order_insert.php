<?php
include 'common.php';  // 데이터베이스 연결 파일 포함

// 회원 및 비회원 구분하기
$member_id = isset($_COOKIE['cookie_id']) ? $_COOKIE['cookie_id'] : 0;

// 오늘 날짜 가져오기
$today = date("ymd");

// 오늘의 가장 큰 주문 번호 가져오기
$sql = "SELECT id FROM jumun WHERE jumunday = CURDATE() ORDER BY id DESC LIMIT 1";
$result = mysqli_query($db, $sql);
if (!$result) {
    die('Query Error: ' . mysqli_error($db));
}
$row = mysqli_fetch_assoc($result);

if ($row) {
    // 오늘의 가장 큰 주문 번호가 있는 경우
    $last_order_id = $row['id'];
    $last_order_number = substr($last_order_id, -4);  // 주문 번호의 마지막 4자리
    $new_order_number = str_pad($last_order_number + 1, 4, '0', STR_PAD_LEFT);  // 4자리로 패딩
} else {
    // 오늘의 주문 번호가 없는 경우
    $new_order_number = "0001";
}

// 새로운 주문 번호 생성
$new_order_id = $today . $new_order_number;

// 총 금액과 제품 수 초기화
$total_amount = 0;
$product_nums = 0;
$product_names = "";

$n_cart = isset($_COOKIE['n_cart']) ? intval($_COOKIE['n_cart']) : 0;
$cart = isset($_COOKIE['cart']) ? $_COOKIE['cart'] : [];

// 제품 정보와 총 금액 계산
for ($i = 1; $i <= $n_cart; $i++) {
    if (isset($cart[$i])) {
        list($product_id, $quantity, $opts_id1, $opts_id2) = explode("^", $cart[$i]);
        
        // 제품 정보 가져오기
        $sql_product = "SELECT id, name, price, discount, icon_sale FROM product WHERE id = $product_id";
        $result_product = mysqli_query($db, $sql_product);
        if (!$result_product) {
            die('Query Error1: ' . mysqli_error($db));
        }
        $row_product = mysqli_fetch_assoc($result_product);

        $product_name = $row_product['name'];
        $product_price = $row_product['price'];
        $product_discount = $row_product['discount'];
        $product_sale = $row_product['icon_sale'];

        // 할인 가격 계산
        if ($product_sale == 1) {
            $product_price = round($product_price * (100 - $product_discount) / 100, -3);
        }
        $product_total = $product_price * $quantity;
        $total_amount += $product_total;

        // 옵션 이름 가져오기
        $opt1_name = "";
        if ($opts_id1 != 0) {
            $sql_opt1 = "SELECT name FROM opts WHERE id = $opts_id1";
            $result_opt1 = mysqli_query($db, $sql_opt1);
            if (!$result_opt1) {
                die('Query Error2: ' . mysqli_error($db));
            }
            $row_opt1 = mysqli_fetch_assoc($result_opt1);
            $opt1_name = $row_opt1['name'];
        }

        $opt2_name = "";
        if ($opts_id2 != '') {
            $sql_opt2 = "SELECT name FROM opts WHERE id = $opts_id2";
            $result_opt2 = mysqli_query($db, $sql_opt2);
            if (!$result_opt2) {
                die('Query Error3: ' . mysqli_error($db));
            }
            $row_opt2 = mysqli_fetch_assoc($result_opt2);
            $opt2_name = $row_opt2['name'];
        }

        $product_nums++;
        if ($product_nums == 1) {
            $product_names = $product_name;
        }
    }
}

// 배송비 계산
$shipping_cost = 0;

if ($total_amount < $max_baesongbi) {
    $total_amount += $baesongbi;
    $shipping_cost = $baesongbi;
}

// 제품 수가 2개 이상인 경우 "외 ?개" 추가
if ($product_nums > 1) {
    $tmp = $product_nums -1;
    $product_names = $product_names . " 외 " . $tmp . "개";
}

// 주문 테이블에 저장
$o_name = $_REQUEST['o_name'];
$o_tel = $_REQUEST['o_tel'];
$o_email = $_REQUEST['o_email'];
$o_zip = $_REQUEST['o_zip'];
$o_juso = $_REQUEST['o_juso'];
$r_name = $_REQUEST['r_name'];
$r_tel = $_REQUEST['r_tel'];
$r_email = $_REQUEST['r_email'];
$r_zip = $_REQUEST['r_zip'];
$r_juso = $_REQUEST['r_juso'];
$memo = $_REQUEST['memo'];
$pay_kind = $_REQUEST['pay_kind'];
$card_okno = isset($_REQUEST['card_okno']) ? $_REQUEST['card_okno'] : '';
$card_halbu = isset($_REQUEST['card_halbu']) ? $_REQUEST['card_halbu'] : 0;
$card_kind = isset($_REQUEST['card_kind']) ? $_REQUEST['card_kind'] : 0;
$bank_kind = isset($_REQUEST['bank_kind']) ? $_REQUEST['bank_kind'] : 0;
$bank_sender = isset($_REQUEST['bank_sender']) ? $_REQUEST['bank_sender'] : '';
$state = 1;  // 주문 신청 상태

$sql_order = "INSERT INTO jumun (id, member_id, jumunday, product_names, product_nums, o_name, o_tel, o_email, o_zip, o_juso, r_name, r_tel, r_email, r_zip, r_juso, memo, pay_kind, card_okno, card_halbu, card_kind, bank_kind, bank_sender, total_cash, state) 
              VALUES ('$new_order_id', '$member_id', NOW(), '$product_names', '$product_nums', '$o_name', '$o_tel', '$o_email', '$o_zip', '$o_juso', '$r_name', '$r_tel', '$r_email', '$r_zip', '$r_juso', '$memo', '$pay_kind', '$card_okno', '$card_halbu', '$card_kind', '$bank_kind', '$bank_sender', '$total_amount', '$state')";
if (!mysqli_query($db, $sql_order)) {
    die('Query Error4: ' . mysqli_error($db));
}

// 주문 상세 정보 저장
for ($i = 1; $i <= $n_cart; $i++) {
    if (isset($cart[$i])) {
        list($product_id, $quantity, $opts_id1, $opts_id2) = explode("^", $cart[$i]);

        // 제품 정보 가져오기
        $sql_product = "SELECT id, name, price, discount, icon_sale FROM product WHERE id = $product_id";
        $result_product = mysqli_query($db, $sql_product);
        if (!$result_product) {
            die('Query Error5: ' . mysqli_error($db));
        }
        $row_product = mysqli_fetch_assoc($result_product);

        $product_price = $row_product['price'];
        $product_discount = $row_product['discount'];
        $product_sale = $row_product['icon_sale'];

        // 할인 가격 계산
        if ($product_sale == 1) {
            $product_price = round($product_price * (100 - $product_discount) / 100, -3);
        }
        $product_total = $product_price * $quantity;

        // 주문 상세 정보 저장
        if ($opts_id2 != '') {
        $sql_insert = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2) 
                       VALUES ('$new_order_id', '$product_id', '$quantity', '$product_price', '$product_total', '$product_discount', '$opts_id1', '$opts_id2')";
        } else {
        $sql_insert = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1) 
                       VALUES ('$new_order_id', '$product_id', '$quantity', '$product_price', '$product_total', '$product_discount', '$opts_id1')";
        }
        if (!mysqli_query($db, $sql_insert)) {
            die('Query Error6: ' . mysqli_error($db));
        }
        // 장바구니에서 제품 정보 삭제
        setcookie("cart[$i]", "");
        setcookie("n_cart", "");
    }
}


// 배송비가 있을 경우 배송비 정보 저장
if ($shipping_cost > 0) {
    $sql_insert_shipping = "INSERT INTO jumuns (jumun_id, product_id, num, price, prices, discount, opts_id1, opts_id2) 
                            VALUES ('$new_order_id', 99999, 1, '$shipping_cost', '$shipping_cost', 0, 0, 0)";
}

// 주문 완료 페이지로 리다이렉트
header("Location: order_ok.php");
exit();
?>
