<?
    include "common.php";               // DB 연결

    $id = $_REQUEST["id"];
    $name = $_REQUEST["name"];
    $tel1 = $_REQUEST["tel1"];
    $tel2 = $_REQUEST["tel2"];
    $tel3 = $_REQUEST["tel3"];
    $tel = sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3);
    $sm = $_REQUEST["sm"];
    $birthday1 = $_REQUEST["birthday1"];
    $birthday2 = $_REQUEST["birthday2"];
    $birthday3 = $_REQUEST["birthday3"];
    $birthday = sprintf("%04d-%02d-%02d", $birthday1, $birthday2, $birthday3);
    $juso = $_REQUEST["juso"];

    $sql = "UPDATE juso 
            SET name='$name', tel='$tel', sm=$sm, birthday='$birthday', juso='$juso'
            WHERE id=$id";

    $result = mysqli_query($db, $sql); 
    if (!$result) exit("에러: $sql");

    echo("<script>location.href='juso_list.php'</script>");
?>
