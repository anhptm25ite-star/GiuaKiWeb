<?php
include("connect.php");

$sql = "SELECT * FROM GiangVien ORDER BY IDGV DESC";
$result = mysqli_query($conn, $sql);
$total_gv = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Giảng Viên - QLHocPhan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #495057;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }
        .main-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            background: #ffffff;
        }
        .custom-table {
            margin-bottom: 0;
        }
        .custom-table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 16px 20px;
            border: none;
        }
        .custom-table tbody tr {
            transition: background-color 0.2s ease;
        }
        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }
        .custom-table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        .avatar-img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.06);
        }
        .badge-id {
            background-color: #e2e8f0;
            color: #334155;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
        }
        .badge-class {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
        }
        .btn-action-edit {
            background-color: #fef3c7;
            color: #d97706;
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-action-edit:hover {
            background-color: #fde68a;
            color: #b45309;
        }
        .btn-action-delete {
            background-color: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 8px;
            padding: 6px 14px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .btn-action-delete:hover {
            background-color: #fca5a5;
            color: #991b1b;
        }
        .btn-add-new {
            background-color: #0ea5e9;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            border: none;
            transition: all 0.2s;
        }
        .btn-add-new:hover {
            background-color: #0284c7;
            color: white;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
        }
    </style>
</head>
<body>

<div class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-graduation-cap text-info me-2"></i>Quản Lý Giảng Viên
            </h3>
            <p class="text-muted small mb-0">Danh sách tổng hợp thông tin giảng viên trong hệ thống QLHocPhan</p>
        </div>
        <a href="add.php" class="btn btn-add-new text-decoration-none">
            <i class="fa-solid fa-plus me-1"></i> Thêm Giảng Viên
        </a>
    </div>

    <div class="card main-card overflow-hidden">
        
        <div class="card-header bg-white py-3 px-4 border-bottom border-light d-flex justify-content-between align-items-center">
            <span class="fw-semibold text-secondary small">
                <i class="fa-solid fa-list me-1"></i> TỔNG SỐ GIẢNG VIÊN: <span class="text-dark fw-bold"><?php echo $total_gv; ?></span>
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="10%">Mã GV</th>
                            <th class="text-center" width="12%">Hình Ảnh</th>
                            <th width="38%">Họ và Tên</th>
                            <th class="text-center" width="18%">Tổng Số Lớp</th>
                            <th class="text-center" width="22%">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_gv > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    
                                    <td class="text-center">
                                        <span class="badge-id">#<?php echo $row['IDGV']; ?></span>
                                    </td>

                                    <td class="text-center">
                                        <img src="<?php echo (!empty($row['Image']) && file_exists($row['Image'])) ? $row['Image'] : 'https://via.placeholder.com/48'; ?>" 
                                             alt="Avatar" class="avatar-img">
                                    </td>

                                    <td>
                                        <span class="fw-semibold text-dark fs-6">
                                            <?php echo htmlspecialchars($row['Fullname']); ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge-class">
                                            <i class="fa-solid fa-chalkboard-user me-1"></i><?php echo $row['SumClass']; ?> Lớp
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-inline-flex gap-2">
                                            <a href="edit.php?id=<?php echo $row['IDGV']; ?>" class="btn-action-edit text-decoration-none">
                                                <i class="fa-solid fa-pen-to-square me-1"></i> Sửa
                                            </a>
                                            <a href="delete.php?id=<?php echo $row['IDGV']; ?>" class="btn-action-delete text-decoration-none"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa giảng viên #<?php echo $row['IDGV']; ?>?');">
                                                <i class="fa-solid fa-trash me-1"></i> Xóa
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-3">
                                        <i class="fa-regular fa-folder-open display-6 text-muted mb-3 d-block"></i>
                                        <p class="text-muted fw-medium mb-0">Chưa có dữ liệu giảng viên nào trong hệ thống.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</body>
</html>