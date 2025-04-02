<?php
require 'connectdb.php';

// ตรวจสอบว่ามี p_id ถูกส่งมาหรือไม่
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];
    
    // ดึงข้อมูลสินค้า
    $sql = "SELECT * FROM product WHERE p_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $p_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<p>ไม่พบสินค้าที่ต้องการแก้ไข</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['pname'];
    $p_detail = $_POST['pdetail'];
    $p_price = $_POST['pprice'];
    $pt_id = $_POST['pt_id'];
    $target_file = $product['p_picture'];
    
    // ตรวจสอบว่ามีการอัปโหลดไฟล์ใหม่หรือไม่
    if (isset($_FILES["pimg"]) && $_FILES["pimg"]["error"] == 0) {
        $target_dir = "images/";
        $target_file = basename($_FILES["pimg"]["name"]);
        move_uploaded_file($_FILES["pimg"]["tmp_name"], $target_dir . $target_file);
    }
    
    // อัปเดตข้อมูลสินค้า
    $sql = "UPDATE product SET p_name=?, p_detail=?, p_price=?, p_picture=?, pt_id=? WHERE p_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsii", $p_name, $p_detail, $p_price, $target_file, $pt_id, $p_id);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('แก้ไขข้อมูลสินค้าสำเร็จ');
                window.location.href = 'editor.php';  // รีไดเรกต์ไปยัง editor.php
              </script>";
        exit();  // จำเป็นต้องใช้ exit() เพื่อหยุดการทำงานของสคริปต์หลังจากแสดงผล
    } else {
        echo "<p>เกิดข้อผิดพลาด: " . $stmt->error . "</p>";
    }
    
    
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <link rel="stylesheet" href="style.css">
    <video class="video-background" autoplay loop muted>
    <source src="videos/a.mp4" type="video/mp4">
    </video>

    <meta charset="UTF-8">
    <title>แก้ไขสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* ปุ่มย้อนกลับให้อยู่ที่มุมซ้ายบน */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #004D40;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-btn:hover {
            background-color: #003d34;
        }
        /* เปลี่ยนสีพื้นหลังของปุ่ม */
        .btn-primary {
            background-color: #004D40;  /* สีพื้นหลัง (ตัวอย่างสีส้ม) */
            border-color:rgb(255, 255, 255);  /* สีขอบของปุ่ม */
        }

        /* เปลี่ยนสีข้อความในปุ่ม */
        .btn-primary:hover {
            color: white;  /* สีข้อความเมื่อ hover */
        }

        /* เปลี่ยนสีพื้นหลังของปุ่มเมื่อ hover */
        .btn-primary:focus, .btn-primary:active {
            background-color: #004D40;  /* สีพื้นหลังเมื่อคลิกหรือ focus (ตัวอย่างสีเข้มกว่า) */
            border-color: #004D40;
        }
    </style>
</head>
<body>
<header>
    <h1>แก้ไขสินค้า</h1>
    <a href="editor.php" class="back-btn">ย้อนกลับ</a>
    <link rel="stylesheet" href="styles.css">
    
</header>
<div class="container">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="pname">ชื่อสินค้า</label>
            <input type="text" class="form-control" name="pname" value="<?php echo $product['p_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="pdetail">รายละเอียดสินค้า</label>
            <textarea class="form-control" name="pdetail" rows="5"><?php echo $product['p_detail']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="pt_id">ประเภทสินค้า</label>
            <select class="form-control" name="pt_id" required>
                <?php
                $sql = "SELECT pt_id, pt_name FROM product_type";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $selected = ($row['pt_id'] == $product['pt_id']) ? "selected" : "";
                    echo "<option value='{$row['pt_id']}' {$selected}>{$row['pt_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="pprice">ราคา (บาท)</label>
            <input type="number" class="form-control" name="pprice" value="<?php echo $product['p_price']; ?>" required>
        </div>
        <div class="form-group">
            <label for="pimg">รูปภาพสินค้า</label>
            <input type="file" class="form-control-file" name="pimg">
            <p>รูปภาพปัจจุบัน: <img src="images/<?php echo $product['p_picture']; ?>" width="100"></p>
        </div>
        <button type="submit" class="btn btn-primary btn-block">บันทึกการแก้ไข</button>
        
    </form>
    

</div>
</body>
</html>
