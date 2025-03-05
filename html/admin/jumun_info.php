<?php
include "../common.php";

// 주문 ID를 받아옵니다
$id = $_REQUEST['id'];

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
<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Life with Dog</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/my.css" rel="stylesheet">
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->    
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->    

<div class="row mx-1 justify-content-center">
    <div class="col-sm-10" align="center">

    <h4 class="m-0 mb-3">주문 (<?=$jumun["id"]?>)</h4>

    <table class="table table-sm table-bordered mb-3">
        <tr>
            <td width="15%" class="bg-light">상태</td>
            <td width="35%"><?=$a_state[$jumun["state"]]?></td>
            <td width="15%" class="bg-light">주문일</td>
            <td width="35%"><?=$jumun["jumunday"]?></td>
        </tr>
    </table>

    <table class="table table-sm table-bordered mb-2">
        <tr>
            <td width="15%" class="bg-light"><b>주문자</b></td>
            <td width="35%"><?=$jumun["o_name"]?></td>
            <td width="15%" class="bg-light">구분</td>
            <td width="35%">
				<?php if ($jumun["member_id"] != 0) { ?>
                    회원
                <?php } else { ?>
                    비회원
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td class="bg-light">전화</td><td><?=$jumun["o_tel"]?></td>
            <td class="bg-light">E-Mail</td><td><?=$jumun["o_email"]?></td>
        </tr>
        <tr>
            <td class="bg-light">주소</td>
            <td align="left" colspan="3">&nbsp;(<?=$jumun["o_zip"]?>) <?=$jumun["o_juso"]?></td>
        </tr>
    </table>

    <table class="table table-sm table-bordered mb-3">
        <tr>
            <td width="15%" class="bg-light"><b>수신자</b></td>
            <td width="35%"><?=$jumun["r_name"]?></td>
            <td width="15%" class="bg-light"></td>
            <td></td>
        </tr>
        <tr>
            <td class="bg-light">전화</td>
            <td><?=$jumun["r_tel"]?></td>
            <td class="bg-light">E-Mail</td>
            <td><?=$jumun["r_email"]?></td>
        </tr>
        <tr>
            <td class="bg-light">주소</td>
            <td align="left" colspan="3">&nbsp;(<?=$jumun["r_zip"]?>) <?=$jumun["r_juso"]?></td>
        </tr>
        <tr height="50">
            <td class="bg-light">메모</td>
            <td align="left" valign="top" colspan="3">&nbsp;<?=$jumun["memo"]?></td>
        </tr>
    </table>

	<table class="table table-sm table-bordered mb-3">
		<tr>
			<td width="15%" class="bg-light">카드</td>
			<td width="35%">
				<?php
                if ($jumun["card_kind"] != 0) {
                    echo $a_card_kind[$jumun["card_kind"]];
                }
                ?>
			</td>
			<td width="15%" class="bg-light">승인</td>
			<td width="35%"><?=$jumun["card_okno"]?></td>
		</tr>
		<tr>
			<td class="bg-light">할부</td>
			<td>
			<?php
                if ($jumun["card_kind"] != 0) {
                    if ($jumun["card_halbu"] == 0) {
                        echo "일시불";
                    } else {
                        echo $jumun["card_halbu"] . "개월";
                    }
                }
                ?>
			</td>
			<td class="bg-light"></td><td></td>
		</tr>
		<tr>
			<td class="bg-light">무통장</td>
			<td>
				<?php
                if ($jumun["bank_kind"] != 0) {
                    echo $a_bank_kind[$jumun["bank_kind"]];
                }
                ?>
			</td>
			<td class="bg-light">입금자</td><td><? echo $jumun["bank_sender"]?></td>
		</tr>
	</table>

    <table class="table table-sm table-bordered mb-3">
        <tr class="bg-light">
            <td>제품명</td>
            <td width="10%">수량</td>
            <td width="10%">단가</td>
            <td width="10%">금액</td>
            <td width="10%">할인</td>
            <td width="20%">옵션</td>
        </tr>
        <?php while ($item = mysqli_fetch_assoc($result_items)) { ?>
            <tr>
                <td align="left"><?= $item["product_name"] ?></td>
                <td><?= $item["num"] ?></td>
                <td align="right"><?= number_format($item["price"]) ?></td>
                <td align="right"><?= number_format($item["price"] * $item["num"]) ?></td>
                <td><?= $item["discount"] ?>%</td>
				<td>
					<?php if ($item["option2_name"] !== null) { ?>
						<?= $item["option1_name"] ?> / <?= $item["option2_name"] ?>
					<?php } else { ?>
						<?= $item["option1_name"] ?>
					<?php } ?>
				</td>
            </tr>
        <?php } ?>
        <tr>
            <td align="left">택배비</td>
			<?php if ($jumun["total_cash"] < 100000) { ?>
            <td>1</td>
            <td align="right">3,000</td>
            <td align="right">3,000</td>
			<td></td>
			<td></td>
			<?php } else {?>
            <td>0</td>
			<td align="right">0</td>
            <td align="right">0</td>
            <td></td>
            <td></td>
			<?}?>
        </tr>
    </table>

    <table class="table table-sm table-bordered mb-3 p-2">
        <tr>
            <td width="15%" class="bg-light">총금액</td>
            <td width="85%" align="right" style="font-size:18px"><b><?= number_format($jumun["total_cash"]) ?> 원</b>&nbsp;</td>
        </tr>
    </table>

    <a href="javascript:print();" class="btn btn-sm btn-dark text-white my-2">&nbsp;프린트&nbsp;</a>&nbsp;
    <a href="javascript:history.back();" class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

    </div>
</div>
<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
