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

    <h4 class="m-0 mb-3">FAQ</h4>

    <?php
    include "../common.php"; 

    $sql = "SELECT * FROM faq ORDER BY id ASC";
    $result = mysqli_query($db, $sql);
    if (!$result) {
        echo "에러: " . mysqli_error($db);
        exit;
    }
    $faq_count = mysqli_num_rows($result);
    ?>

    <div class="row myfs13">
        <div class="col" align="left" style="padding-top:8px">
            &nbsp;자료수 : <font color="red"><?= $faq_count ?></font>
        </div>
        <div class="col" align="right">
            <div class="d-inline-flex">
                <a href="faq_new.php" class="btn btn-sm mycolor1 myfs12">추가</a>&nbsp;
            </div>
        </div>
    </div>

    <table class="table table-sm table-bordered table-hover my-1">
        <tr class="bg-light">
            <td width="10%">번호</td>
            <td>질문</td>
            <td width="25%">수정 / 삭제</td>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td align='left'>{$row['title']}</td>";
            echo "<td>
                    <a href='faq_edit.php?id={$row['id']}' class='btn btn-sm mybutton-blue'>수정</a>
                    <a href='faq_delete.php?id={$row['id']}' class='btn btn-sm mybutton-red' onclick='return confirm(\"삭제할까요 ?\");'>삭제</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    </div>
</div>
<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
