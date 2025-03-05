<?
    include "common.php";               // DB 연결

   $uid=$_REQUEST["uid"];
   $pwd=$_REQUEST["pwd"];
   $name=$_REQUEST["name"];    // 혹은  $name=$_POST["name"];
   $tel1 = $_REQUEST["tel1"];         // 전화번호의 첫 번째 부분
   $tel2 = $_REQUEST["tel2"];         // 전화번호의 두 번째 부분
   $tel3 = $_REQUEST["tel3"];         // 전화번호의 세 번째 부분
   $tel= sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3); 
   $zip=$_REQUEST["zip"];
   $juso=$_REQUEST["juso"];
   $email=$_REQUEST["email"];
   $birthday1 = $_REQUEST["birthday1"]; // 생일의 연도 부분
   $birthday2 = $_REQUEST["birthday2"]; // 생일의 월 부분
   $birthday3 = $_REQUEST["birthday3"]; // 생일의 일 부분
   $birthday = sprintf("%04d-%02d-%02d", $birthday1, $birthday2, $birthday3);
   $gubun=$_REQUEST["gubun"];

    $sql="INSERT INTO member (uid, pwd, name, tel, zip, juso, email, birthday, gubun) 
          VALUES ('$uid', '$pwd', '$name', '$tel', '$zip', '$juso', '$email', '$birthday', 0)"; 
          
    $result=mysqli_query($db, $sql); 
    if (!$result) exit("에러: $sql");

    echo("<script>location.href='member_joinend.php'</script>"); //가입 후 가입 감사화면으로 이동
?>
