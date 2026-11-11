<?php
include("connect.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$old_id = (int)$_GET['id'];
$sql = "SELECT * FROM GiangVien WHERE IDGV = $old_id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header("Location: index.php");
    exit();
}

$message = "";

if (isset($_POST['btn_update'])) {
    $new_idgv = trim($_POST['idgv']);
    $fullname = trim($_POST['fullname']);
    $sumclass = (int)$_POST['sumclass'];
    $image_path = $row['Image'];

    if ($new_idgv != $old_id) {
        $check_sql = "SELECT IDGV FROM GiangVien WHERE IDGV = '$new_idgv'";
        $check_res = mysqli_query($conn, $check_sql);
        if (mysqli_num_rows($check_res) > 0) {
            $message = "<div class='alert alert-danger'>Mã Giảng viên (IDGV) mới này đã bị trùng! Vui lòng chọn mã khác.</div>";
        }
    }

    if (empty($message)) {
        // Nếu chọn ảnh mới
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            $file_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $file_name;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                if (file_exists($row['Image'])) {
                    unlink($row['Image']);
                }
                $image_path = $target_file;
            }
        }

        // Cập nhật dữ liệu bao gồm cả IDGV mới
        $sql_update = "UPDATE GiangVien SET IDGV = '$new_idgv', Fullname = '$fullname', Image = '$image_path', SumClass = $sumclass WHERE IDGV = $old_id";
        if (mysqli_query($conn, $sql_update)) {
            header("Location: index.php");
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Cập nhật thất bại: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Giảng Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Sửa Thông Tin Giảng Viên</h4>
                </div>
                <div class="card-body p-4">
                    <?php echo $message; ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Giảng Viên (IDGV):</label>
                            <input type="number" name="idgv" class="form-control" value="<?php echo $row['IDGV']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và Tên Giảng Viên:</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($row['Fullname']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình Ảnh Hiện Tại:</label><br>
                            <img src="<?php echo $row['Image']; ?>" width="80" height="80" class="rounded mb-2" style="object-fit: cover;">
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Bỏ trống nếu không muốn đổi ảnh mới</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tổng Số Lớp:</label>
                            <input type="number" name="sumclass" class="form-control" value="<?php echo $row['SumClass']; ?>" min="0" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Hủy</a>
                            <button type="submit" name="btn_update" class="btn btn-warning text-white">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>