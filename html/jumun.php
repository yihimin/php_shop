<?php
include "common.php";
include "main_top.php"; 

// 쿠키에서 필요한 정보를 가져오기
$cookie_id = $_COOKIE['cookie_id'] ?? 0;
$o_name = $_COOKIE['guest_name'] ?? '';
$o_email = $_COOKIE['guest_email'] ?? '';

// 주문 데이터베이스에서 주문 항목을 가져오기 위한 조건 설정
if ($cookie_id == 0) { // 비회원인 경우
    $sql = "SELECT * FROM jumun WHERE o_name = '$o_name' AND o_email = '$o_email' ORDER BY jumunday DESC";
} else { // 회원인 경우
    $sql = "SELECT * FROM jumun WHERE member_id = $cookie_id ORDER BY jumunday DESC";
}

$result = mysqli_query($db, $sql);
if (!$result) {
    echo "에러: " . mysqli_error($db);
    exit;
}
$count = mysqli_num_rows($result); // 결과 행 수를 확인

$result = mypagination($sql, $args, $count, $pagebar);
?>

<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<div class="row m-1 mt-4 mb-0">
    <div class="col" align="center">

        <h4 class="m-3">주문조회</h4>
 
        <hr class="m-0">
        <table class="table table-sm mb-4">
            <tr height="40" class="bg-light">
                <td width="15%">주문일</td>
                <td width="15%">주문번호</td>
                <td width="35%">제품정보</td>
                <td width="15%" align="right">결제금액</td>
                <td width="20%">주문상태</td>
            </tr>
            <?php
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // 주문 상태에 따른 색상 설정
                    $state_color = "#000000"; // 기본 검정색
                    if ($row['state'] == 1) $state_color = "#0066CC"; // 주문신청
                    if ($row['state'] == 4) $state_color = "#0066CC"; // 배송중
                    if ($row['state'] == 6) $state_color = "#D06404"; // 주문취소

                    echo "<tr height='40'>";
                    echo "<td>{$row['jumunday']}</td>";
                    echo "<td class='mywordwrap'><a href='jumun_info.php?id={$row['id']}' style='font-size:14px;color:#0066CC'>{$row['id']}</a></td>";
                    echo "<td align='left'>{$row['product_names']}</td>";
                    echo "<td align='right' style='font-size:14px;'>" . number_format($row['total_cash']) . "</td>";
                    echo "<td><font color='{$state_color}'>{$a_state[$row['state']]}</font></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' align='center'>주문내역이 없습니다.</td></tr>";
            }
            ?>
        </table>

    </div>
</div>

<!--  Pagination -->
<?php echo $pagebar; ?>

<br><br><br>

<!-------------------------------------------------------------------------------------------->    
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<?php
include "main_bottom.php";
?>

<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
