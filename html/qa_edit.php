<?php
include "common.php";
include "main_top.php";

// 요청된 Q&A 항목 ID 가져오기
$id = $_REQUEST['id'];

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
    function Check_Value() {
        if (!form2.title.value) {
            alert('글제목을 입력하여 주십시요');
            form2.title.focus();
            return;
        }
        if (!form2.name.value) {
            alert('이름을 입력하여 주십시요');
            form2.name.focus();
            return;
        }
        if (!form2.passwd.value) {
            alert('암호를 입력하여 주십시요');
            form2.passwd.focus();
            return;
        }
        form2.submit();
    }
</script>

<!--  form2 시작 -->
<form name="form2" method="post" action="qa_update.php">

<input type="hidden" name="page" value="1">
<input type="hidden" name="text1" value="">
<input type="hidden" name="id" value="<?= $id ?>">

<div class="row m-1  mb-0 justify-content-center">
    <div class="col" align="center">

        <h4 class="mt-5">Q & A</h4>

        <hr style="height:2px" class="mb-0">
        <table class="table table-sm m-0">
            <tr>
                <td width="15%" class="bg-light">제목</td>
                <td align="left" class="px-2">
                    <div class="d-inline-flex">
                        <input type="text" name="title" size="85" value="<?= $row['title'] ?>" class="form-control form-control-sm">                
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">작성자</td>
                <td align="left" class="px-2">
                    <div class="d-inline-flex">
                        <input type="text" name="name" size="20" value="<?= $row['name'] ?>" class="form-control form-control-sm">                
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">비밀번호</td>
                <td align="left" class="px-2">
                    <div class="d-inline-flex">
                        <input type="password" name="passwd" size="20" value="<?= $row['passwd'] ?>" class="form-control form-control-sm">                
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">내용</td>
                <td align="left" class="p-2">
                    <textarea name="contents" rows="10" cols="85" class="form-control form-control-sm p-2"><?= $row['contents'] ?></textarea>
                </td>
            </tr>
        </table>

        <table width="100%" class="m-2">
            <tr>
                <td align="center" class="pe-2">
                    <a href="javascript:Check_Value();" class="btn btn-sm btn-dark text-white myfont">저장</a>&nbsp;&nbsp;
                    <a href="javascript:history.back()" class="btn btn-sm btn-dark text-white myfont">목록</a>
                </td>
            </tr>
        </table>
    
    </div>
</div>

</form>

<br><br><br>

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
