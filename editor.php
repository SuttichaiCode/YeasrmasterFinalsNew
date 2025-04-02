<?php
include 'connectdb.php'; // เชื่อมต่อฐานข้อมูล

// รับค่าประเภทสินค้าจาก GET (ถ้ามี)
$pt_id = isset($_GET['pt_id']) ? intval($_GET['pt_id']) : 0;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 25; // แสดง 5x5 ต่อหน้า
$offset = ($page - 1) * $limit;

// ดึงประเภทสินค้า
$categories = $conn->query("SELECT * FROM product_type")->fetch_all(MYSQLI_ASSOC);

// ดึงสินค้าตามประเภท (ถ้ามี)
$sql = "SELECT * FROM product";
if ($pt_id > 0) {
    $sql .= " WHERE pt_id = $pt_id";
}
$sql .= " LIMIT $limit OFFSET $offset";
$products = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

// ดึงจำนวนสินค้าทั้งหมด (ใช้สำหรับทำ pagination)
$count_sql = "SELECT COUNT(*) AS total FROM product";
if ($pt_id > 0) {
    $count_sql .= " WHERE pt_id = $pt_id";
}
$total = $conn->query($count_sql)->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขสินค้า</title>
    <style>
        .product-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; font-weight: bold;}
        .product-item { border: 1px solid #ffffff; padding: 10px; text-align: center; }
        .pagination { margin-top: 10px; }

        .btn-container {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color:rgb(255, 255, 255);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
    
        }

        .btn {
            color: white;
            border: 2px solid white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        
        
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
        }
        
        header img {
            height: 40px;
        }
        
        header h1 {
            margin: 10px 0 5px;
            font-size: 24px;
            color: rgb(255, 255, 255);
        }
    </style>
</head>
<body>
    <video class="video-background" autoplay loop muted>
    <source src="videos/a.mp4" type="video/mp4">
    </video>

    <header>
        <img src="images/aaaa.png" alt="admin">
        <h1>แก้ไขสินค้า</h1>
        <div class="btn-container">
            <a href="index.php" class="btn">ลงชื่อออก</a>

            <a href="product_add.php" class="btn">เพิ่มสินค้า</a>
        </div>
    </header>
    
    <form method="GET">
        <label>เลือกประเภทสินค้า:</label>
        <select name="pt_id" onchange="this.form.submit()">
            <option value="0">ทั้งหมด</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['pt_id'] ?>" <?= ($pt_id == $category['pt_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['pt_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <img src="images/<?= htmlspecialchars($product['p_picture']) ?>" alt="<?= htmlspecialchars($product['p_name']) ?>" width="100">
                <p><?= htmlspecialchars($product['p_name']) ?></p>
                <p><?= number_format($product['p_price'], 2) ?> บาท</p>
                <a href="product_edit.php?p_id=<?= $product['p_id'] ?>">แก้ไข</a>
                <a href="delete_product.php?id=<?= $product['p_id'] ?>" onclick="return confirm('คุณแน่ใจหรือไม่ว่าต้องการลบสินค้า?');">ลบ</a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?pt_id=<?= $pt_id ?>&page=<?= $i ?>" <?= ($i == $page) ? 'style="font-weight: bold;"' : '' ?>>
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
</body>
</html>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
