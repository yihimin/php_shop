<?php
include "common.php"; // 데이터베이스 연결 포함
include "main_top.php";

// FAQ 데이터베이스에서 FAQ 항목을 가져오기
$sql = "SELECT * FROM faq ORDER BY id ASC";
$result = mysqli_query($db, $sql);
if (!$result) {
    echo "에러: " . mysqli_error($db);
    exit;
}
?>

<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<div class="row m-1  mb-0 justify-content-center">
    <div class="col" align="center">

        <h4 class="mt-5">FAQ</h4>

        <hr style="height:2px" class="mb-0">
        <table class="table table-sm m-0">
            <tr height="30" class="bg-light">
                <td width="10%">번호</td>
                <td width="90%">제목</td>
            </tr>
            <?php
            $num = 1; // 번호를 위한 변수
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr height='35'>";
                echo "<td>{$num}</td>"; // 순서 번호를 출력
                echo "<td align='left'>
                        <a href='faq_read.php?id={$row['id']}' style='color:#0066CC'>{$row['title']}</a><br>
                      </td>";
                echo "</tr>";
                $num++; // 번호 증가
            }
            ?>
        </table>
    </div>
</div>

<br><br><br><br><br><br>

<!-------------------------------------------------------------------------------------------->    
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<?php include "main_bottom.php"; ?>

<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
