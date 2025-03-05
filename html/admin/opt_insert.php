<?
    include "../common.php";               // DB 연결

   $name=$_REQUEST["name"];

    $sql="INSERT INTO opt (name) 
          VALUES ('$name')"; 
          
    $result=mysqli_query($db, $sql); 
    if (!$result) exit("에러: $sql");

    echo("<script>location.href='opt.php'</script>"); 
?>
