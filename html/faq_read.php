<?php
include "common.php";
include "main_top.php";

// URL 파라미터로부터 ID를 가져옴
$id = $_GET['id'] ?? null;

if ($id === null) {
    exit("잘못된 접근입니다.");
}

// FAQ 항목을 가져오는 SQL 쿼리
$sql = "SELECT * FROM faq WHERE id='$id'";
$result = mysqli_query($db, $sql);

if (!$result) {
    exit("에러: " . mysqli_error($db));
}

$row = mysqli_fetch_assoc($result);
if (!$row) {
    exit("해당 FAQ 항목을 찾을 수 없습니다.");
}
?>

<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<div class="row m-1  mb-0 justify-content-center">
    <div class="col" align="center">

        <h4 class="mt-5">Q & A</h4>

        <hr style="height:2px" class="mb-0">
        <table class="table table-sm m-0" style="text-align:left">
            <tr height="35" class="bg-light">
                <td class="ps-3"><?= htmlspecialchars($row['title']) ?></td>
            </tr>
            <tr height="35">
                <td class="p-3"><?= nl2br(htmlspecialchars($row['contents'])) ?></td>
            </tr>
        </table>

        <br>
        <a href="javascript:history.back();" class="btn btn-sm btn-dark text-white">&nbsp;돌아가기&nbsp;</a>

    </div>
</div>

<br><br><br><br><br><br>

<!-------------------------------------------------------------------------------------------->    
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<?php
include "main_bottom.php";
?>
<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
