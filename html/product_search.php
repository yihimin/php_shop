<?php
    include "common.php";

    // 변수 초기화
    $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : '';
    $findtext = isset($_REQUEST["find_text"]) ? $_REQUEST["find_text"] : ''; 

    $sql = "SELECT * FROM product WHERE name LIKE '%$findtext%' ORDER BY name";
    $result = mysqli_query($db, $sql);  
    if (!$result) {
        exit("에러: " . mysqli_error($db));
    } 
	$result = mypagination($sql, $args, $count, $pagebar);
?>

<?php
    include "main_top.php";
?>
<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    
<div class="row m-1 mt-4 mb-0">
    <div class="col" align="center">

        <h4 class="m-3">상품검색</h4>

        <hr class="m-0">
        <table class="table table-sm mb-4">
            <tr height="40" class="bg-light">
                <td width="15%">이미지</td>
                <td width="45%">상품정보</td>
                <td width="20%">판매가</td>
                <td width="20%">금액</td>
            </tr>
            <?php while ($row = mysqli_fetch_array($result)): ?>
            <tr height="85" style="font-size:14px;">
                <td>
                    <a href="product.php?id=<?=$row["id"]?>"><img src="product/<?=$row['image1']?>" width="60" height="70"></a>
                </td>
                <td align="left" valign="middle">
                    <a href="product.php?id=<?=$row["id"]?>" style="color:#0066CC"><?=$row['name']?></a><br>
                    <?php if ($row['icon_hit'] == 1) {
                            echo '<img src="images/i_hit.gif">&nbsp;';
                         }
                         if ($row['icon_new'] == 1) {
                             echo '<img src="images/i_new.gif">&nbsp;';
                         }
                         if ($row['icon_sale'] == 1) {
                             echo '<img src="images/i_sale.gif">&nbsp;';
                             echo '<font size="2" color="red">' . $row['discount'] . '% </font>';
                         }
                    ?> 
                </td>
                <?php if ($row['icon_sale'] == 1): 
                    $sale_price = $row['price'] * (1 - $row['discount'] / 100); ?>
                    <td><strike><?= number_format($row['price']) ?> 원</strike></td>
                    <td><b><?= number_format($sale_price) ?> 원</b></td>
                <?php else: ?>
                    <td><?= number_format($row['price']) ?>원</td>
                    <td><?= number_format($row['price']) ?>원</td>
                <?php endif; ?>
            </tr>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($result) == 0): ?>
            <tr>
                <td colspan="4">상품을 찾을 수 없습니다.</td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<!--  Pagination -->
<?php
   echo $pagebar;
?>


<!-- 화면 하단 (main_bottom) : 회사소개/이용안내/개인보호정책 -->
<?
 include "main_bottom.php" 
 ?>

<!-------------------------------------------------------------------------------------------->    
</div>

</body>
</html>
