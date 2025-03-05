<?php
 if (!function_exists('mypagination')) {
    include "common.php"; // 이 조건문을 사용하여 mypagination 함수가 선언되지 않았을 때만 common.php를 include합니다.

	$findtext = isset($_REQUEST["find_text"]) ? $_REQUEST["find_text"] : '';
}
?>

<!doctype html>
<html lang="kr">
<head> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Life with Dog</title>
	<link  href="css/bootstrap.min.css" rel="stylesheet">
	<link  href="css/my.css" rel="stylesheet">
	<script src="js/jquery-3.7.1.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->	

<!--  Title과  메뉴(로그인/회원가입/장바구니/주문조회/게시판/Q&A) -->
<div class="row">
	<div class="col fs-3" align="left">
		&nbsp;<a href="index.html"><font color="#777777">Life with Dog</font></a>
	</div>
	<div class="col mt-3" align="right" style="font-size:12px;">
		<a href="index.html">Home</a>&nbsp;|&nbsp;
		<?php
            $cookie_id = $_COOKIE["cookie_id"] ?? 0;
            // 쿠키에 저장된 cookie_id 값이 없는 경우
            if (!$cookie_id) {
                echo "<a href='member_login.php'>로그인</a>";
                echo " | <a href='member_join.php'>회원가입</a>";
                $jumun_link = "jumun_login.php";
            } else {
                echo "<a href='member_logout.php'>로그아웃</a>";
                echo " | <a href='member_edit.php'>회원정보수정</a>";
                $jumun_link = "jumun.php";
            }
        ?>
        | <a href="cart.php">장바구니</a>&nbsp;|&nbsp; 
        <a href="<?php echo $jumun_link; ?>">주문조회</a>&nbsp;|&nbsp;
        <a href="qa.php">Q & A</a>&nbsp;|&nbsp;
        <a href="faq.php">FAQ</a>&nbsp;&nbsp;
	</div>
</div>

<!-- Slide Images -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"  data-bs-interval="4000">
    <div class="carousel-indicators">
        <?php for ($i = 0; $i < 4; $i++) : ?>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo $i + 1; ?>" <?php if ($i === 0) echo 'class="active" aria-current="true"'; ?>></button>
        <?php endfor; ?>
    </div>
    <div class="carousel-inner">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <div class="carousel-item <?php if ($i === 1) echo 'active'; ?>">
                <img src="images/00<?php echo $i; ?>.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<!--  상품 Category 메뉴/ 상품검색 -->
<div class="row bg-light m-0 p-1 fs-6 border"><!-- 상단 메뉴의 디자인을 설정합니다. -->
	<div class="col"><!-- 상단 메뉴를 가로로 정렬합니다. -->
		<div class="d-flex"><!-- Flexbox를 사용하여 메뉴를 정렬합니다. -->
			<ul class="nav me-auto"><!-- 메뉴 목록을 나타내는 리스트를 생성합니다. -->
			<?php
                // 반복문을 사용하여 각 메뉴 항목을 출력합니다.
                for ($i = 1; $i < $n_menu; $i++) {
                    echo '<li class="nav-item zoom_a"><a class="nav-link" href="menu.php?menu=' . ($i + 1) . '">' . $a_menu[$i] . '</a></li>'; // 메뉴 항목을 출력합니다.
                }
                ?>
			</ul>

			<script>
				function check_findproduct() {
					if (!form1.find_text.value)  {
						alert('검색어를 입력하세요');
						return;
					}
					form1.submit();
				}
			</script>

			<form name="form1" method="post" action="product_search.php">
				<div class="input-group input-group-sm pt-1" >
					<span  class="input-group-text" style="font-size:13px;">상품검색</span>
					<input type="text" name="find_text" value="<?=$findtext ?>" size="10" class="form-control form-control-sm">
					<button type="button" class="btn btn-sm btn-outline-secondary" style="font-size:13px;" 
						onClick="check_findproduct();">Search</button>
				</div>
			</form>

		</div>
	</div>
</div>

<!-------------------------------------------------------------------------------------------->	
<!-- 시작 : 다른 웹페이지 삽입할 부분 -->
<!-------------------------------------------------------------------------------------------->	

</body>
</html>
