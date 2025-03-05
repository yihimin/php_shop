<?php
include "common.php";
include "main_top.php";

// 요청된 Q&A 항목 ID 가져오기
$id = $_GET['id'];

// 조회수 증가 쿼리
$sql_update = "UPDATE qa SET count = count + 1 WHERE id = $id";
mysqli_query($db, $sql_update);

// Q&A 데이터베이스에서 해당 항목 가져오기
$sql = "SELECT * FROM qa WHERE id = $id";
$result = mysqli_query($db, $sql);
if (!$result) {
    echo "에러: " . mysqli_error($db);
    exit;
}
$row = mysqli_fetch_assoc($result);
?>

<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<!--  현재 페이지 자바스크립  -------------------------------------------->
<script>
    function Go_Reply() {
        form2.action = "qa_reply.php";
        form2.submit();
    }

    function Check_Modify() {
        if (form2.passwd.value) {
            form2.action = "qa_edit.php";
            form2.submit();
        } else {
            alert('암호를 입력하세요.');
            form2.passwd.focus();
        }
    }

    function Check_Delete() {
        if (form2.passwd.value) {
            form2.action = "qa_delete.php";
            form2.submit();
        } else {
            alert('암호를 입력하세요.');
            form2.passwd.focus();
        }
    }
</script>

<div class="row m-1  mb-0 justify-content-center">
    <div class="col" align="center">

        <h4 class="mt-5">Q & A</h4>

        <hr style="height:2px" class="mb-0">
        <table class="table table-sm m-0">
            <tr height="35">
                <td width="15%" class="bg-light">제목</td>
                <td align="left" class="px-2"><?= $row['title'] ?></td>
            </tr>
            <tr height="35">
                <td class="bg-light">작성자</td>
                <td align="left" class="px-2"><?= $row['name'] ?></td>
            </tr>
            <tr height="35">
                <td class="bg-light">작성일</td>
                <td align="left" class="px-2"><?= $row['writeday'] ?></td>
            </tr>
            <tr height="35">
                <td class="bg-light">조회</td>
                <td align="left" class="px-2"><?= $row['count'] ?></td>
            </tr>
            <tr>
                <td valign="top" class="bg-light pt-2">내용</td>
                <td height="250" align="left" valign="top" class="p-2"><?= nl2br($row['contents']) ?></td>
            </tr>
        </table>

        <!--  form2 시작 -->
        <form name="form2" method="post" action="">
            <input type="hidden" name="page" value="1">
            <input type="hidden" name="text1" value="">
            <input type="hidden" name="id" value="<?= $id ?>">

            <table width="100%" class="m-1">
                <tr>
                    <td align="left" valign="top">
                        <div class="d-inline-flex">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" style="font-size:12px;">암호</span>
                                <input type="password" name="passwd" size="7" class="form-control bg-light" style="font-size:12px;">
                            </div>
                        </div>
                    </td>
                    <td align="right" valign="top">
                        <a href="javascript:Go_Reply();" class="btn btn-sm btn-dark text-white">답글</a>&nbsp;
                        <a href="javascript:Check_Modify();" class="btn btn-sm btn-dark text-white">수정</a>&nbsp;
                        <a href="javascript:Check_Delete();" class="btn btn-sm btn-dark text-white">삭제</a>&nbsp;
                        <a href="javascript:history.back()" class="btn btn-sm btn-dark text-white">목록</a>&nbsp;
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<br><br><br>

<!-------------------------------------------------------------------------------------------->    
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<?php
include "main_bottom.php";
?>
