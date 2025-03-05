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

    <h4 class="m-0 mb-3">FAQ 수정</h4>

    <?php
    include "../common.php"; 

    $id = $_GET['id'];
    $sql = "SELECT * FROM faq WHERE id = $id";
    $result = mysqli_query($db, $sql);
    if (!$result) {
        echo "에러: " . mysqli_error($db);
        exit;
    }
    $row = mysqli_fetch_assoc($result);
    ?>

    <form name="form1" method="post" action="faq_update.php">
        <input type="hidden" name="id" value="<?= $id ?>">
        <table class="table table-bordered table-sm my-3">
            <tr>
                <td width="20%">질문</td>
                <td><input type="text" name="title" class="form-control form-control-sm" value="<?= $row['title'] ?>" required></td>
            </tr>
            <tr>
                <td width="20%">답변</td>
                <td><textarea name="contents" class="form-control form-control-sm" rows="5" required><?= $row['contents'] ?></textarea></td>
            </tr>
        </table>
        <button class="btn btn-sm mycolor1" type="submit">저장</button>
    </form>

    </div>
</div>
<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
