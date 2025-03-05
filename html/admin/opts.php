<?php
    // common.php 파일을 포함하여 필요한 파일을 로드합니다.
    include "../common.php";

    // URL에서 옵션 번호(id)와 소옵션 번호(id1) 값을 읽어옵니다. 만약 값이 없으면 빈 문자열로 설정합니다.
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $id1 = isset($_GET['id1']) ? $_GET['id1'] : '';

    // 옵션명을 가져오기 위한 쿼리를 작성합니다. opts 테이블과 opt 테이블을 조인하여 옵션명을 가져옵니다.
    $sql_option = "SELECT opts.*, opt.name AS optionName 
            FROM opts 
            JOIN opt ON opts.opt_id = opt.id
            WHERE opts.opt_id = $id";
            //이 때 $id는 외래키로 연결된 opt.id와 opts.opt_id가 됩니다.

    // 옵션 정보를 가져오는 쿼리를 실행합니다.
    $result_option = mysqli_query($db, $sql_option);
    if (!$result_option) {
        // 쿼리 실행 중 오류가 발생하면 오류 메시지를 출력하고 스크립트를 종료합니다.
        exit("옵션 정보를 가져오는 데 실패했습니다.");
    }

    // 가져온 옵션 정보를 연관 배열로 변환합니다.
    $row = mysqli_fetch_assoc($result_option);

    // 소옵션 정보를 가져오기 위한 쿼리를 작성합니다.
    $sql_sub = "SELECT * FROM opts WHERE opt_id = $id";

    // 소옵션 정보를 가져오는 쿼리를 실행합니다.
    $result_sub = mysqli_query($db, $sql_sub);
    if (!$result_sub) {
        // 쿼리 실행 중 오류가 발생하면 오류 메시지를 출력하고 스크립트를 종료합니다.
        exit("소옵션 정보를 가져오는 데 실패했습니다.");
    }
?>

<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Life with Dog</title>
    <link  href="../css/bootstrap.min.css" rel="stylesheet">
    <link  href="../css/my.css" rel="stylesheet">
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/my.js"></script>
</head>
<body>

<div class="container">
    <!-- admin_menu() 함수는 어디서 정의되었는지 알려주시면 더 좋겠습니다. -->
    <script> document.write(admin_menu());</script>

    <div class="row mx-1  justify-content-center">
        <div class="col-sm-10" align="center">

            <h4 class="m-0">소옵션</h4>

            <div class="row myfs13">
                <div class="col" align="left" style="padding-top:8px">
                    <!-- 가져온 옵션명을 화면에 출력합니다. -->
                    &nbsp;옵션명 : <font color="red"><?php echo $row['optionName'];?></font>
                </div>
                <div class="col" align="right">
                    <div class="d-inline-flex">
                        <!-- opts_new.php로 이동할 때 id 값을 함께 전달해야 합니다. -->
                        <a href="opts_new.php?id=<?=$id?>" class="btn btn-sm mycolor1 myfs12">소옵션 추가</a>&nbsp;
                    </div>
                </div>
            </div>

            <table class="table table-sm table-bordered table-hover my-1">
                <tr class="bg-light">
                    <td width="25%">소옵션 번호</td>
                    <td>소옵션명</td>
                    <td width="25%">수정 / 삭제</td>
                </tr>
                <?php
                    // 가져온 소옵션 정보를 반복하여 화면에 출력합니다.
                    while ($sub_row = mysqli_fetch_assoc($result_sub)) {
                        $id1 = $sub_row["id"];
                ?>
                <tr>
                    <td><?=$sub_row["id"];?></td>
                    <td><?=$sub_row["name"];?></td>
                    <td>
                        <!-- 수정 및 삭제 링크를 opt_id값과 opts.name을 이용해 생성합니다. -->
                        <!-- <a href="opts_edit.php?id=<?=$id?>&id1=<?=$sub_row["name"];?> -->
                        <a href="opts_edit.php?id=<?=$id?>&id1=<?=$sub_row["id"];?>
                        " class="btn btn-sm mybutton-blue">수정</a>
                        <a href="opts_delete.php?id=<?=$id?>&id1=<?=$sub_row["id"];?>" class="btn btn-sm mybutton-red" onclick="javascript:return confirm('삭제할까요 ?');">삭제</a>   
                        <!-- 여기서 링크를 고쳐야 url 매개변수값 수정!!!             -->
                    </td>
                </tr>
                <?php } ?>
            </table>

            <!-- 페이지 링크를 출력합니다. -->
            <?php echo $pagebar; ?>

            <!-- 돌아가기 링크를 출력합니다. -->
            <a href="opt.php"  class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

        </div>
    </div>
</div>

</body>
</html>
