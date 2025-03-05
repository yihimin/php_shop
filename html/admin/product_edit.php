<?php
    include "../common.php";

	$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '없음';
    $sql = "SELECT * FROM product WHERE id=$id;";
    $result = mysqli_query($db, $sql);
    if (!$result) {
        exit("에러: " . mysqli_error($db));
    } 
	$row = mysqli_fetch_array($result); // 1레코드 읽기
   
    // 상태 값을 올바르게 설정합니다.
    $status = isset($row['status']) ? $row['status'] : 0; // 기본값은 0으로 설정합니다.

	// opt 테이블 쿼리
	$sql1 = "SELECT * FROM opt ORDER BY name";
	$result1 = mysqli_query($db, $sql1);
	if (!$result1) {
		exit("에러: " . mysqli_error($db));
	} 	

    // 결과 집합의 행 수를 변수에 저장
    $num_rows = mysqli_num_rows($result1);

    $checkno1 = $_REQUEST["checkno1"];
    $checkno2 = $_REQUEST["checkno2"];
    $checkno3 = $_REQUEST["checkno3"];
?>

<!doctype html>
<html lang="kr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Life with Dog</title>
    <link  href="../css/bootstrap.min.css" rel="stylesheet">
    <link  href="../css/my.css" rel="stylesheet">
    <script src="..js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/my.js"></script>
</head>
<body>

<div class="container">
<!-------------------------------------------------------------------------------------------->   
<script> document.write(admin_menu());</script>
<!-------------------------------------------------------------------------------------------->   
<script>
	function imageView(strImage)
	{
		this.document.images["big"].src = strImage;
	}
</script>
    <form name="form1" method="post" action="product_update.php" enctype="multipart/form-data">
    <input type="hidden" name="sel1" value="">
    <input type="hidden" name="sel2" value="">
    <input type="hidden" name="sel3" value="">
    <input type="hidden" name="sel4" value="">
    <input type="hidden" name="text1" value="">
    <input type="hidden" name="page" value="1">
    <input type="hidden" name="id" value="<?=$id?>">
    <div class="row mx-1  justify-content-center">
    <div class="col" align="center">

        <h4 class="m-0 mb-3">제품</h4>

        <table class="table table-sm table-bordered myfs12 m-0 p-0">
            <tr>
                <td width="15%" class="bg-light">상품분류</td>
                <td align="left" class="ps-2">
                    <div class="d-inline-flex">
                        <select name="menu" class="form-select form-select-sm bg-light myfs12">
                            <?php foreach ($a_menu as $key => $value) { ?>
                            <option value="<?=$key ?>"<?php if((int)$row["menu"] === $key) echo 'selected'; ?>> 
						    <?= $value; ?></option>
                            <?php } ?> <!--메뉴명 받아오기-->
                        </select>&nbsp;
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">상품코드</td>
                <td align="left" class="ps-2">
                    <div class="d-inline-flex">
                        <input type="text" name="code" size="20" value="<?=$row["code"]; ?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">상품명</td>
                <td align="left" class="ps-2">
                    <div class="d-inline-flex">
                        <input type="text" name="name" size="80" value="<?=$row["name"];?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">제조사</td>
                <td align="left" class="ps-2">
                    <div class="d-inline-flex">
                        <input type="text" name="coname" size="30" value="<?=$row["coname"]; ?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">판매가</td>
                <td align="left" class="ps-2">
                    <div class="d-inline-flex">
                        <input type="text" name="price" size="12" value="<?=$row["price"]; ?>" class="form-control form-control-sm">
                    </div> 원
                </td>
            </tr>
            <tr>
                <td class="bg-light">옵션</td>
                <td align="left" class="ps-2">
                <div class="d-inline-flex">
                        <select name="opt1" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
                            <option value="0" selected>옵션 선택</option>
                            <?php 
                            // 옵션 데이터 루프
                            while ($row1 = mysqli_fetch_assoc($result1)) { 
                                // 현재 옵션 값과 옵션 데이터 비교
                                $selected = ($row1['id'] == $row['opt1']) ? 'selected' : '';
                            ?>
                                <option value="<?= $row1['id'] ?>" <?= $selected ?>>
                                    <?= $row1["name"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <!-- 옵션 2가 있는 경우만 -->
                        <?php if (mysqli_num_rows($result1) > 1) { ?>
                            <select name="opt2" class="form-select form-select-sm bg-light myfs12 me-2" style="width:100px">
                                <option value="0" selected>옵션 선택</option>
                                <?php 
                                // 다시 옵션 데이터 루프 시작
                                mysqli_data_seek($result1, 0); 
                                while ($row1 = mysqli_fetch_assoc($result1)) { 
                                    // 현재 옵션 값과 옵션 데이터 비교
                                    $selected = ($row1['id'] == $row['opt2']) ? 'selected' : '';
                                ?>
                                    <option value="<?= $row1['id'] ?>" <?= $selected ?>>
                                        <?= $row1["name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        <?php } ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">제품설명</td>
                <td align="left" class="ps-2">
                    <div class="d-inline-flex">
                        <textarea name="contents" rows="5" cols="80" class="form-control form-control-sm myfs12"><?=$row["contents"]; ?></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">상품상태</td>
                <td align="left" class="ps-2">
                    <div class="form-check form-check-inline pt-2">
                        <input class="form-check-input" type="radio" name="status" value="1" <?php if($status == 1) echo 'checked'; ?>>
                        <label class="form-check-label me-2">판매중</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" value="2" <?php if($status == 2) echo 'checked'; ?>>
                        <label class="form-check-labe me-2">판매중지</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="status" value="3" <?php if($status == 3) echo 'checked'; ?>>
                        <label class="form-check-label me-2">품절</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">아이콘</td>
                <td align="left" class="ps-2">
                    <div class="form-check form-check-inline">
                        <!-- New 아이콘 체크박스 -->
                        <input class="form-check-input" type="checkbox" value="1" name="icon_new" <?php echo ($row['icon_new'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label me-2">New</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <!-- Hit 아이콘 체크박스 -->
                        <input class="form-check-input" type="checkbox" value="1" name="icon_hit" <?php echo ($row['icon_hit'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label me-2">Hit</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <!-- Sale 아이콘 체크박스 -->
                        <input class="form-check-input" type="checkbox" value="1" name="icon_sale" <?php echo ($row['icon_sale'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label me-2">Sale</label>
                    </div>
                    <!-- 할인율 입력 -->
                    할인율: &nbsp;
                    <div class="d-inline-flex">
                        <input type="text" name="discount" value="<?= $row["discount"]; ?>" size="2" maxlength="3" class="form-control form-control-sm">
                    </div> %
                </td>
            </tr>
            <tr>
                <td class="bg-light">등록일</td>
                <td align="left" class="ps-2">
                    <div class="d-inline-flex">
                        <?php
                        // 등록일을 Y-m-d 형식에서 Y-d-m 형식으로 변환
                        $regday = date("Y-m-d", strtotime($row["regday"]));
                        ?>
                        <!-- 변환된 등록일을 표시하는 입력 필드 -->
                        <input type="date" name="regday" value="<?= $regday; ?>" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-light">이미지<br>(삭제할 그림 체크)</td>
                <td align="left" class="ps-2">
                    <table class="my-1">
                    <tr>
                        <td>
                            <img src="../product/<?php echo $row['image1']; ?>" width="50" height="50" class="img-thumbnail" style='cursor:pointer' data-bs-toggle="modal" data-bs-target="#zoomModal" onclick="document.getElementById('zoomModalLabel').innerText='<?php echo $row['image1']; ?>'; picname.src='../product/<?php echo $row['image1']; ?>'">
                        </td>
                        <td align="left" class="ps-3">
                             <input type="hidden" name="imagename1" value="<?php echo $row['image1']; ?>">
                            <input type="checkbox" name="checkno1" value="1">
                            <b>이미지1 : </b>&nbsp;<?php echo $row['image1']; ?><br>
                            <div class="d-inline-flex">
                                <input type="file" name="image1" class="form-control form-control-sm myfs12">
                            </div>
                        </td>
                    </tr> 
                    </table>
                    <table class="mb-1">
                    <tr>
                        <td>
                            <img src="../product/<?php echo $row['image2']; ?>" width="50" height="50" class="img-thumbnail" style='cursor:pointer' data-bs-toggle="modal" data-bs-target="#zoomModal" onclick="document.getElementById('zoomModalLabel').innerText='<?php echo $row['image2']; ?>'; picname.src='../product/<?php echo $row['image2']; ?>'">
                        </td>
                        <td align="left" class="ps-3">
                            <input type="hidden" name="imagename2" value="<?php echo $row['image2']; ?>">
                            <input type="checkbox" name="checkno2" value="1">
                            <b>이미지2 : </b>&nbsp;<?php echo $row['image2']; ?><br>
                            <div class="d-inline-flex">
                                <input type="file" name="image2" class="form-control form-control-sm myfs12">
                            </div>
                        </td>
                    </tr>
                    </table>
                    <table class="mb-1">
                    <tr>
                        <td>
                            <img src="../product/<?php echo $row['image3']; ?>" width="50" height="50" class="img-thumbnail" style='cursor:pointer' data-bs-toggle="modal" data-bs-target="#zoomModal" onclick="document.getElementById('zoomModalLabel').innerText='<?php echo $row['image3']; ?>'; picname.src='../product/<?php echo $row['image3']; ?>'">
                        </td>
                        <td align="left" class="ps-3">
                            <input type="hidden" name="imagename3" value="<?php echo $row['image3']; ?>">
                            <input type="checkbox" name="checkno3" value="1">
                            <b>이미지3 : </b>&nbsp;<?php echo $row['image3']; ?><br>
                            <div class="d-inline-flex">
                                <input type="file" name="image3" class="form-control form-control-sm myfs12">
                                </div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
        
		<a href="javascript:form1.submit();"  class="btn btn-sm btn-dark text-white my-2">&nbsp;저 장&nbsp;</a>&nbsp;
		<a href="javascript:history.back();"  class="btn btn-sm btn-outline-dark my-2">&nbsp;돌아가기&nbsp;</a>

	</div>
</div>
<br>
<!-------------------------------------------------------------------------------------------->	
</div>

</body>
</html>

<!-- Zoom Modal 이미지 -->
<div class="modal fade" id="zoomModal" tabindex="-1" aria-labelledby="zoomModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-light">
				<h5 class="modal-title" id="zoomModalLabel">상품명1</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" align="center">
				<img src="#" name="picname" class="img-fluid img-thumbnail" style='cursor:pointer' data-bs-dismiss="modal">
			</div>
		</div>
	</div>
</div>