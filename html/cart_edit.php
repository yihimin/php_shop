<?php
include "common.php";

// 폼 제출에서 액션을 가져옵니다
$kind = isset($_REQUEST['kind']) ? $_REQUEST['kind'] : '';
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$num = isset($_REQUEST['num']) ? intval($_REQUEST['num']) : 0;
$opts_id1 = isset($_REQUEST['opts1']) ? intval($_REQUEST['opts1']) : 0;
$opts_id2 = isset($_REQUEST['opts2']) ? intval($_REQUEST['opts2']) : '';
$pos = isset($_REQUEST['pos']) ? intval($_REQUEST['pos']) : 0;
 

// 기존 쿠키에서 장바구니를 가져옵니다
$n_cart = isset($_COOKIE['n_cart']) ? intval($_COOKIE['n_cart']) : 0;
$cart = $_COOKIE["cart"];

switch ($kind) {
    case "insert":
    case "order":
        $n_cart++;
        $cart[$n_cart] = implode("^", array($id, $num, $opts_id1, $opts_id2));;
        // 쿠키에 저장
        setcookie("cart[$n_cart]", $cart[$n_cart]);
        setcookie('n_cart', $n_cart);
        break;
        case "delete":
            if (isset($cart[$pos])) {
                // 해당 항목 제거
                setcookie("cart[$pos]", "");
                unset($cart[$pos]);
                
                // 배열 재정렬
                $cart = array_values($cart);
                $n_cart--; // n_cart 값을 감소시킵니다
                
                // 기존 쿠키 초기화
                for ($i = 1; $i <= $n_cart + 1; $i++) {
                    setcookie("cart[$i]", "");
                }
        
                // 재정렬된 배열로 쿠키 재설정
                for ($i = 1; $i <= $n_cart; $i++) {
                    setcookie("cart[$i]", $cart[$i - 1]);
                }
                
                setcookie('n_cart', $n_cart);
            }
            break;
        
    case "update":
        if (isset($cart[$pos])) {
            $item_parts = explode("^", $cart[$pos]);
            $item_parts[1] = $num; // 수량 업데이트
            $cart[$pos] = implode("^", $item_parts);
            setcookie("cart[$pos]", $cart[$pos]);
        }
        break;
    case "deleteall":
        for ($i = 1; $i <= $n_cart; $i++) {
            if ($cart[$i]) {
                setcookie("cart[$i]", "");
            }
        }
            // 모든 쿠키가 삭제되었음을 확인하는 추가 코드
            if (isset($_COOKIE['n_cart'])) {
                setcookie('n_cart', "");
            }
        $n_cart = 0; // n_cart 값을 초기화
        $cart = []; // 장바구니 배열 초기화 !이게 안됨!
        break;        
}

if ($kind == "order") {
    header("Location: order.php");
} else {
    header("Location: cart.php");
}
exit();
?>
