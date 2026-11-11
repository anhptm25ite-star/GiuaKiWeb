<?php
include("connect.php");

$message = "";

if (isset($_POST['btn_add'])) {
    $idgv = trim($_POST['idgv']);
    $fullname = trim($_POST['fullname']);
    $sumclass = (int)$_POST['sumclass'];
    
    $check_sql = "SELECT IDGV FROM GiangVien WHERE IDGV = '$idgv'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        $message = "<div class='alert alert-danger'>Mã Giảng viên (IDGV) này đã tồn tại! Vui lòng nhập mã khác.</div>";
    } else {
       
        $image_path = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/";
            $file_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $file_name;
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            }
        }

        if (!empty($idgv) && !empty($fullname) && !empty($image_path)) {
            $sql = "INSERT INTO GiangVien (IDGV, Fullname, Image, SumClass) VALUES ('$idgv', '$fullname', '$image_path', $sumclass)";
            if (mysqli_query($conn, $sql)) {
                header("Location: index.php");
                exit();
            } else {
                $message = "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $message = "<div class='alert alert-warning'>Vui lòng điền đầy đủ thông tin và chọn hình ảnh!</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Giảng Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Thêm Giảng Viên Mới</h4>
                </div>
                <div class="card-body p-4">
                    <?php echo $message; ?>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Mã Giảng Viên (IDGV):</label>
                            <input type="number" name="idgv" class="form-control" placeholder="Nhập mã giảng viên (VD: 101)..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Họ và Tên Giảng Viên:</label>
                            <input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình Ảnh:</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tổng Số Lớp:</label>
                            <input type="number" name="sumclass" class="form-control" value="0" min="0" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" name="btn_add" class="btn btn-success">Thêm Giảng Viên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>