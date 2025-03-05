<?php
include "common.php";
include "main_top.php";

// 부모 글의 ID와 pos1, pos2 값을 받아오는 부분
$id = $_REQUEST['id'];
$result = mysqli_query($db, "SELECT pos1, pos2, name, contents FROM qa WHERE id = '$id'");
if (!$result || mysqli_num_rows($result) == 0) {
    echo "에러: 부모 글을 찾을 수 없습니다.";
    exit;
}
$row = mysqli_fetch_assoc($result);
$pos1 = $row['pos1'];
$pos2 = $row['pos2'];
$name = $row['name'];
$contents = $row['contents'];
?>

<!-- 시작 : 다른 웹페이지 삽입할 부분 -->

<!--  현재 페이지 자바스크립 -->
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

<!-- form2 시작 -->
<form name="form2" method="post" action="qa_insertrply.php">
    <input type="hidden" name="page" value="1">
    <input type="hidden" name="text1" value="">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="hidden" name="pos1" value="<?= $pos1 ?>">
    <input type="hidden" name="pos2" value="<?= $pos2 ?>">

    <div class="row m-1 mb-0 justify-content-center">
        <div class="col" align="center">
            <h4 class="mt-5">Q & A</h4>
            <hr style="height:2px" class="mb-0">
            <table class="table table-sm m-0">
                <tr>
                    <td width="15%" class="bg-light">제목</td>
                    <td align="left" class="px-2">
                        <div class="d-inline-flex">
                            <input type="text" name="title" size="85" value="<?= $name ?> 고객님 안녕하세요" 
                                class="form-control form-control-sm">                
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-light">작성자</td>
                    <td align="left" class="px-2">
                        <div class="d-inline-flex">
                            <input type="text" name="name" size="20" value="" 
                                class="form-control form-control-sm">                
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-light">비밀번호</td>
                    <td align="left" class="px-2">
                        <div class="d-inline-flex">
                            <input type="password" name="passwd" size="20" value="" 
                                class="form-control form-control-sm">                
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-light">내용</td>
                    <td align="left" class="p-2">
                        <textarea name="contents" rows="10" cols="85" 
                            class="form-control form-control-sm p-2"><?= $name ?> 고객님의 문의내용 : <?= nl2br(htmlspecialchars($contents)) ?>
                        </textarea>
                    </td>
                </tr>
            </table>
            <table width="100%" class="m-2">
                <tr>
                    <td align="center" class="pe-2">
                        <a href="javascript:Check_Value();" 
                            class="btn btn-sm btn-dark text-white">저장</a>&nbsp;&nbsp;
                        <a href="javascript:history.back()" 
                            class="btn btn-sm btn-dark text-white">목록</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>

<br><br><br>

<!-- 끝 : 다른 웹페이지 삽입할 부분 -->

<?php
include "main_bottom.php";
?>

</div>

</body>
</html>
