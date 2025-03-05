<?
    include "common.php";

    $id=$_REQUEST["id"];   
    $name=$_REQUEST["name"];
    $kor=$_REQUEST["kor"];
    $eng=$_REQUEST["eng"];
    $mat=$_REQUEST["mat"];
    $hap=$_REQUEST["hap"];
    $avg=$_REQUEST["avg"];

    $sql="update  sj  set name='$name',  kor=$kor, eng=$eng, 
                  mat=$mat, hap=$hap,  avg=$avg 
              where id=$id;";
    $result=mysqli_query($db,$sql); 
    if (!$result) exit("에러:$sql");

    echo("<script>location.href='sj_list.php'</script>");
?> 
