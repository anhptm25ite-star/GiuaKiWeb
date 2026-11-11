<?php
include("connect.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    $sql_select = "SELECT Image FROM GiangVien WHERE IDGV = $id";
    $res = mysqli_query($conn, $sql_select);
    if ($row = mysqli_fetch_assoc($res)) {
        if (file_exists($row['Image'])) {
            unlink($row['Image']);
        }
    }

    $sql_delete = "DELETE FROM GiangVien WHERE IDGV = $id";
    mysqli_query($conn, $sql_delete);
}

header("Location: index.php");
exit();
?>