<?
include "common.php";

// 상품을 랜덤하게 가져오는 쿼리
$sql = "SELECT * FROM product WHERE icon_new=1 AND status=1 
        ORDER BY RAND() LIMIT 16";
$result = mysqli_query($db, $sql);
if (!$result) {
    exit("에러: " . mysqli_error($db));
}
$row = mysqli_fetch_array($result); // 1레코드 읽기
?>

<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    
<?
include "main_top.php"
?>

<!--  제목  -->
<div class="row mt-5 mb-1">
    <div class="col" align="center">
        <h2>New Arriable</h2>
    </div>    
</div>    
<hr class="mt-0 mb-4">
 
<!--  상품 진열  -->
<div class="row">
    <?php foreach ($result as $row) { ?>
    <!--  상품표시  -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card h-100">
            <div class="zoom_image" align="center">
                <a href="product.php?id=<?=$row["id"]?>"><img src="product/<?=$row['image1']?>" 
                    height="360" class="card-img-top img-fluid"></a>
            </div>
            <div class="card-body bg-light" align="center" style="font-size:15px;">
                <div class="card-title">
                    <a href="product.php?id=<?=$row["id"]?>"><?=$row['name']?></a><br>
                    <?php if ($row['icon_hit'] == 1) {
                        echo '<img src="images/i_hit.gif">&nbsp;';
                    }
                    if ($row['icon_new'] == 1) {
                        echo '<img src="images/i_new.gif">&nbsp;';
                    }
                    if ($row['icon_sale'] == 1) {
                        echo '<img src="images/i_sale.gif">&nbsp;';
                        echo '<span class="discount-rate" style="font-weight: bold; font-size: 13px; color: red;">' . $row['discount'] . '% </span>';
                    }
                    ?>
                </div>
                 <?php
                // 세일 가격 계산
                $sale_price = round($row['price'] * (100 - $row['discount']) / 100, -3);
                ?>
                <?php if ($row['icon_sale'] == 1) { ?>
                    <!-- 세일 가격 표시 -->
                    <p class="card-text">
                        <del style="font-size:13px;"><?= number_format($row['price']) ?>원</del>
                        <b><?= number_format($sale_price) ?>원</b>
                    </p>
                <?php } else { ?>
                    <!-- 세일 가격이 없는 경우 원래 가격만 표시 -->
                    <p class="card-text"><b><?= number_format($row['price']) ?>원</b><br></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?> 
</div>
<br>

<!-------------------------------------------------------------------------------------------->    
<!-- 끝 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<?
include "main_bottom.php"
?>

<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
