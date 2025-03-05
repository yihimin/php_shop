<?php
include "common.php";
include "main_top.php";

// 카드 종류를 나타내는 값을 텍스트로 변환하기 위한 배열
$a_card_kind = [
    1 => '국민카드',
    2 => '신한카드',
    3 => '우리카드',
    4 => '하나카드'
];
// 무통장 은행 종류를 나타내는 값을 텍스트로 변환하기 위한 배열
$a_bank_kind = [
    1 => '국민은행',
    2 => '신한은행'
];

// 주문 ID를 받아옵니다
$id = $_REQUEST['id'];

// 주문 정보를 가져오는 SQL 쿼리
$sql = "SELECT * FROM jumun WHERE id='$id'";
$result = mysqli_query($db, $sql);
if (!$result) {
    exit("에러: " . mysqli_error($db));
}
$jumun = mysqli_fetch_assoc($result);

// 주문 상품 정보를 가져오는 SQL 쿼리
$sql_items = "
SELECT 
    j.*, 
    p.name AS product_name,
    p.image1 AS product_image,
    o1.name AS option1_name,
    o2.name AS option2_name
FROM jumuns j
JOIN product p ON j.product_id = p.id
LEFT JOIN opts o1 ON j.opts_id1 = o1.id
LEFT JOIN opts o2 ON j.opts_id2 = o2.id
WHERE j.jumun_id = '$id'
";
$result_items = mysqli_query($db, $sql_items);
if (!$result_items) {
    exit("에러: " . mysqli_error($db));
}
?>


<div class="container">
    <div class="row m-1 mt-4 mb-0">
        <div class="col" align="center">

            <h4 class="m-3">주문상품내역</h4>

            <hr class="m-0">
            <table class="table table-sm mb-4">
                <tr height="30" class="bg-light">
                    <td width="15%">이미지</td>
                    <td width="35%">상품정보</td>
                    <td width="15%">판매가</td>
                    <td width="20%">수량</td>
                    <td width="15%">금액</td>
                </tr>
                <?php while ($item = mysqli_fetch_assoc($result_items)) { ?>
                <tr height="85" style="font-size:14px;">
                    <td>
                        <a href="product.php?id=<?= $item['product_id'] ?>"><img src="product/<?= $item['product_image'] ?>" width="60" height="70"></a>
                    </td>
                    <td align="left" valign="middle">
                        <a href="product.php?id=<?= $item['product_id'] ?>" style="color:#0066CC"><?= $item["product_name"] ?></a><br>
                        <small><b>[옵션]</b> <?= $item["option1_name"] ?> &nbsp; <?= $item["option2_name"] ?></small>
                    </td>
                    <td><?= number_format($item["price"]) ?> 원</td>
                    <td><?= $item["num"] ?></td>
                    <td><?= number_format($item["price"] * $item["num"]) ?> 원</td>
                </tr>
                <?php } ?>
                <tr height="85" style="font-size:14px;">
                    <td><img width="60" height="70"></td>
                    <td align="left" valign="middle" style="color:#0066CC">택배비</td>
                    <?php if ($jumun["total_cash"] >= 100000) { ?>
                    <td>0 원</td>
                    <td>0</td>
                    <td>0 원</td>
                    <?php } else { ?>
                    <td>3,000 원</td>
                    <td>1</td>
                    <td>3,000 원</td>
                    <?php } ?>
                </tr>
                <tr height="30" align="right" class="bg-light" style="font-size:14px;">
                    <td colspan="5" class="pe-2">
                        <font color="#0066CC">결제금액</font> : <font style="font-size:16px"><b><?= number_format($jumun["total_cash"]) ?>원</b></font>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row m-1">
        <div class="col" align="center">
            <h4 class="m-0"><font size="4" color="#B90319">결제내역</font></h4>
            <hr class="m-2">
            <table class="table table-sm table-borderless">
                <tr height="30">
                    <td width="20%"><b>주문번호 :</b></td><td width="30%"><?= $jumun["id"] ?></td>
                    <td width="20%"><b>결제금액 :</b></td><td width="30%"><?= number_format($jumun["total_cash"]) ?> 원</td>
                </tr>
                <tr height="30">
                    <td><b>결제방식 :</b></td><td><?= $a_card_kind[$jumun["pay_kind"]] ?></td>
                    <td><b>승인번호 :</b></td><td><?= $jumun["card_okno"] ?></td>
                </tr>
                <tr height="30">
                    <td><b>카드종류 :</b></td><td><?= $a_card_kind[$jumun["card_kind"]] ?></td>
                    <td><b>할부 :</b></td><td><?= $jumun["card_halbu"] == 0 ? "일시불" : $jumun["card_halbu"] . "개월" ?></td>
                </tr>
                <tr height="30">
                    <td><b>무통장 :</b></td><td><?= $a_bank_kind[$jumun["bank_kind"]] ?></td>
                    <td><b>입금자 :</b></td><td><?= $jumun["bank_sender"] ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row m-1">
        <div class="col" align="center">
            <h4 class="m-0"><font size="4" color="#B90319">주문자</font></h4>
            <hr class="m-2">
            <table class="table table-sm table-borderless">
                <tr height="30">
                    <td width="20%"><b>주문자 :</b></td><td width="30%"><?= $jumun["o_name"] ?></td>
                    <td width="20%"><b>핸드폰 :</b></td><td width="30%"><?= $jumun["o_tel"] ?></td>
                </tr>
                <tr height="30">
                    <td><b>이메일 :</b></td><td colspan="3" align="left"><?= $jumun["o_email"] ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row m-1">
        <div class="col" align="center">
            <h4 class="m-0"><font size="4" color="#B90319">배송내역</font></h4>
            <hr class="m-2">
            <table class="table table-sm table-borderless">
                <tr height="30">
                    <td width="20%"><b>수취인 :</b></td><td width="30%"><?= $jumun["r_name"] ?></td>
                    <td width="20%"><b>핸드폰 :</b></td><td width="30%"><?= $jumun["r_tel"] ?></td>
                </tr>
                <tr height="30">
                    <td><b>주소 :</b></td><td colspan="3" align="left">[<?= $jumun["r_zip"] ?>] <?= $jumun["r_juso"] ?></td>
                </tr>
                <tr height="30">
                    <td><b>메모 :</b></td><td colspan="3" align="left"><?= $jumun["memo"] ?></td>
                </tr>
            </table>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col" align="center">
            <a href="javascript:history.back();" class="btn btn-sm btn-dark text-white">&nbsp;돌아가기&nbsp;</a>
        </div>
    </div>

    <br><br>
</div>

<?php
include "main_bottom.php";
?>

</body>
</html>
