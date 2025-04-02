<?php
include 'connectdb.php'; // เชื่อมต่อฐานข้อมูล

if (isset($_GET['id'])) {
    $p_id = intval($_GET['id']); // กำหนดค่าให้ตัวแปรให้ถูกต้อง

    // ตรวจสอบว่าสินค้ามีอยู่จริงหรือไม่
    $check_stmt = $conn->prepare("SELECT * FROM product WHERE p_id = ?");
    $check_stmt->bind_param("i", $p_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // ลบสินค้า
        $stmt = $conn->prepare("DELETE FROM product WHERE p_id = ?");
        $stmt->bind_param("i", $p_id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('ลบข้อมูลเรียบร้อยแล้ว');
                    window.location.href = 'editor.php';
                  </script>";
        } else {
            echo "<script>
                    alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                    window.history.back();
                  </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('ไม่พบสินค้าที่ต้องการลบ');
                window.history.back();
              </script>";
    }

    $check_stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('ไม่มีข้อมูลที่ต้องการลบ');
            window.location.href = 'editor.php';
          </script>";
}
?>
