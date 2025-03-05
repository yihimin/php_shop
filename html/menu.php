<?php
include "common.php";

// $menu 값이 하나씩 밀리는 문제 수정
$menu = isset($_REQUEST["menu"]) ? intval($_REQUEST["menu"]) - 1 : 0; 
$sort = isset($_REQUEST["sort"]) ? intval($_REQUEST["sort"]) : 0;
$id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;

switch ($sort) {
    case 1:
        $order = "AND icon_new=1 ORDER BY id DESC"; // 신상품
        break;
    case 2:
        $order = "AND icon_hit=1 ORDER BY id DESC"; // 인기상품
        break;
    case 3:
        $order = "ORDER BY name"; // 이름순
        break;
    case 4:
        $order = "ORDER BY price"; // 낮은 가격순
        break;
    default:
        $order = "ORDER BY price DESC"; // 높은 가격순
        break;
}

$sql = "SELECT * FROM product WHERE menu=$menu AND status=1 $order";
$result = mysqli_query($db, $sql); 
if (!$result) {
    exit("에러: $sql");
}
$count = mysqli_num_rows($result);

$page_line = 16;
$args = "menu=$menu&sort=$sort";
$result = mypagination($sql, $args, $count, $pagebar);
?>

<!-------------------------------------------------------------------------------------------->    

<?php
include "main_top.php";
?>

<!-------------------------------------------------------------------------------------------->    
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->    

<!--  Category 제목 -->
<div class="row mt-5">
    <div class="col" align="center">
        <h2><?=$a_menu[$menu]?></h2> 
    </div>    
</div>    

<!--  상품개수 & 정렬 -->
<div class="row m-0">
    <div class="col-2" align="left" style="font-size:15px">
        <b><?=$count?></b> items
    </div>    
    <div class="col" align="right" style="font-size:12px">
        <?php
        $a_sort = array("정렬상태","신상품","인기상품","상품명","낮은가격","높은가격");
        $n_sort = count($a_sort);
        
        for ($i = 1; $i < $n_sort; $i++) {
            if ($i == $sort)
                echo("<a href='menu.php?menu=".($menu + 1)."&sort=$i'><b><font color='steelblue'>$a_sort[$i]</font></b></a> &nbsp;|&nbsp;");
            else
                echo("<a href='menu.php?menu=".($menu + 1)."&sort=$i'>$a_sort[$i]</a> &nbsp;|&nbsp;");
        }
        ?>
    </div>    
</div>
<hr class="mt-0 mb-4">

<!--  상품 진열  -->
<div class="row">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <!--  상품1  -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
        <div class="card h-100">
            <div class="zoom_image" align="center">
                <a href="product.php?id=<?=$row['id']?>"><img src="product/<?=$row['image1']?>" height="360" class="card-img-top img-fluid"></a>
            </div>
            <div class="card-body bg-light" align="center" style="font-size:15px;">
                <div class="card-title"><a href="product.php?id=<?=$row['id']?>"><?=$row["name"]?></a><br>
                <?php
                    if ($row['icon_hit'] == 1) {
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

<!--  Pagination -->
<?php
   echo $pagebar;
?>

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
