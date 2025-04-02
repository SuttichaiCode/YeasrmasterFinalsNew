<?php
require 'connectdb.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = isset($_POST['pname']) ? $_POST['pname'] : '';
    $p_detail = isset($_POST['pdetail']) ? $_POST['pdetail'] : '';
    $p_price = isset($_POST['pprice']) ? $_POST['pprice'] : '';
    $pt_id = isset($_POST['pt_id']) ? $_POST['pt_id'] : '';

    $target_dir = "images/";  
    $target_file = basename($_FILES["pimg"]["name"]);  

    if (isset($_FILES["pimg"]) && $_FILES["pimg"]["error"] == 0) {
        if (move_uploaded_file($_FILES["pimg"]["tmp_name"], $target_dir . $target_file)) {
        } else {
            echo "<p>เกิดข้อผิดพลาดในการอัพโหลดไฟล์</p>";
        }
    }

    if (!empty($p_name) && !empty($p_detail) && !empty($p_price) && !empty($pt_id)) {
        $sql = "INSERT INTO product (p_name, p_detail, p_price, p_picture, pt_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsi", $p_name, $p_detail, $p_price, $target_file, $pt_id);

        if ($stmt->execute()) {
            echo "<p>เพิ่มสินค้าสำเร็จ!</p>";
        } else {
            echo "<p>เกิดข้อผิดพลาด: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>กรุณากรอกข้อมูลให้ครบ</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้า</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        header {
            background-color: #ffffff;
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #ddd;
            position: relative;
        }
        .cart-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #004D40;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        header img {
            height: 50px;
        }

        header h1 {
            margin: 10px 0 5px;
            font-size: 24px;
            color: #004D40;
        }

        header h2 {
            font-size: 18px;
            color: #666;
        }

        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<header>
    <img src="images/1.png" alt="YMC Logo">
    <h1>YEAST MASTER CO., LTD</h1>
    <h2>ระบบจัดการสินค้า (เพิ่มสินค้า)</h2>
    <a href="editor.php"class="cart-btn">ย้อนกลับ</a>
</header>

<div class="container">
    <h1 class="text-center mb-4">เพิ่มสินค้าใหม่</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="pname">ชื่อสินค้า</label>
            <input type="text" class="form-control" name="pname" id="pname" placeholder="กรอกชื่อสินค้า" required autofocus>
        </div>

        <div class="form-group">
            <label for="pdetail">รายละเอียดสินค้า</label>
            <textarea class="form-control" name="pdetail" id="pdetail" rows="5" placeholder="กรอกรายละเอียดสินค้า"></textarea>
        </div>

        <div class="form-group">
            <label for="pt_id">ประเภทสินค้า</label>
            <select class="form-control" name="pt_id" id="pt_id" required>
                <option value="">-- เลือกประเภทสินค้า --</option>
                <?php
                require 'connectdb.php';
                $sql = "SELECT pt_id, pt_name FROM product_type"; 
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['pt_id']}'>{$row['pt_name']}</option>";
                }
                $conn->close();
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="pprice">ราคา (บาท)</label>
            <input type="number" class="form-control" name="pprice" id="pprice" placeholder="กรอกราคา" required>
        </div>

        <div class="form-group">
            <label for="pimg">รูปภาพสินค้า</label>
            <input type="file" class="form-control-file" name="pimg" id="pimg" required>
        </div>

        <button type="submit" name="Submit" class="btn btn-primary btn-block">เพิ่มสินค้า</button>
    </form>
</div>

</body>
</html>
