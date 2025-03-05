<?
    include "../common.php";

    // URL에서 id 값을 읽어옵니다.
    $id = $_REQUEST["id"];
    $id1=$_REQUEST["id1"];
    $name=$_REQUEST["name"]; //edit코드 소옵션명에 입력된 값

    //$sql="UPDATE opts SET name='$name' WHERE name='$id1'";
    $sql="UPDATE opts SET name='$name' WHERE id= $id1";
    $result=mysqli_query($db,$sql); 
        if (!$result) {
            exit("에러: $sql");
            }
    echo("<script>location.href='opts.php?id=$id'</script>"); 
?> 

