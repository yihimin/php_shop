<?
    include "common.php";               // DB 연결

   $name=$_REQUEST["name"];    // 혹은  $name=$_POST["name"];
   $kor=$_REQUEST["kor"];
   $eng=$_REQUEST["eng"];
   $mat=$_REQUEST["mat"];
   $hap=$_REQUEST["hap"];
   $avg=$_REQUEST["avg"];

    $sql="insert  into  sj  (name, kor, eng, mat, hap, avg) 
                     values ( '$name', $kor, $eng, $mat, $hap, $avg) "; 
    $result=mysqli_query($db, $sql); 
    if (!$result) exit("에러: $sql");

    echo("<script>location.href='sj_list.php'</script>");
?>
