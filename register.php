<?php
session_start();
require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration System PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: url('https://cdn.pixabay.com/photo/2017/01/18/10/35/field-1989488_960_720.jpg');
            /* พื้นหลังเวป */
            background-size: cover;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            background: rgba(255, 253, 253, 0.4);
            /* ทำให้พื้นหลังโปร่งแสง ค่าด้านหลังสุดคือปรับระดับความโปร่งใส */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(220, 182, 31, 0.91);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.6);
            /* พื้นหลังสีขาวโปร่งแสง */
            color: black;
            /* สีตัวอักษรในช่องกรอกข้อมูล */
            border: 2px solid rgba(132, 129, 120, 0.91);
            /* เส้นขอบสีเทา */
            border-radius: 8px;
            /* มุมโค้งมน */
            padding: 10px;
            /* ระยะห่างขอบด้านใน */
            font-size: 16px;
            /* ขนาดตัวอักษร */
        }

        a {
            font-size: 20px;
            color: rgb(255, 255, 255);
        }
        .btn-primary {
            width: 100%;
            border-radius: 8px;
            background-color:rgb(14, 116, 10);
            border-color: darkgreen;
        }

        .alert {
            border-radius: 8px;
        }

        hr {
            margin: 20px 0;
        }

        .btn-primary:hover {
            background-color: #ddd122;
            /* สีเหลือง */
            transform: scale(1.1) translateY(-3px);
            /* ขยายขึ้นและเด้งขึ้นนิดหน่อย */
            border: 2px solid #d1dbe4;
            /* เส้นขอบสีเข้ม */
            box-shadow: 0 8px 15px rgba(29, 48, 65, 0.4);
            /* เพิ่มเงาชัดขึ้น */
            transition: all 0.3s ease-in-out;
            color: rgb(255, 255, 255);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.6);
            /* พื้นหลังสีขาวโปร่งแสง */
            color: black;
            /* สีตัวอักษรในช่องกรอกข้อมูล */
            border: 2px solid rgba(238, 207, 113, 0.91);
            /* เส้นขอบสีเทา */
            border-radius: 8px;
            /* มุมโค้งมน */
            padding: 10px;
            /* ระยะห่างขอบด้านใน */
            font-size: 16px;
            /* ขนาดตัวอักษร */
        }
        .form-control:focus {
            border-color: darkgreen;
        }
        .form-control:hover {
            border-color: white;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            /* เอาไปอยู่หลังคอนเทนต์ */
            background: rgba(0, 0, 0, 0.3);
            /* ใส่พื้นหลังให้มองเห็น */
        }
    </style>
</head>

<body>
    <div id="particles-js"></div>
    <div class="container">
        <h3 class="text-center">สมัครสมาชิก</h3>
        <hr>





        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error'];
                unset($_SESSION['error']); ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['warning'])) { ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $_SESSION['warning'];
                unset($_SESSION['warning']); ?>
            </div>
        <?php } ?>

        <form action="signup_db.php" method="post">
        <div class="row">
            <!-- คอลัมน์ที่ 1 -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="uaddress" required>
                </div>

                
                
            </div>

            <!-- คอลัมน์ที่ 2 -->
            <div class="col-md-6">

            <div class="mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="c_password" required>
                </div>


                <div class="mb-3">
                    <label class="form-label">Confirm Email</label>
                    <input type="text" class="form-control" name="c_email" required>
                </div>


                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" name="uphone" required>
                </div>
            </div>
        </div>

        <button type="submit" name="signup" class="btn btn-primary mt-3">Sign Up</button>
    </form>
    <hr>
    <p class="text-center">เป็นสมาชิกแล้วใช่ไหม? <a href="signin.php">เข้าสู่ระบบ</a></p>
</div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 150,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: "#ffffff"
                },
                shape: {
                    type: "circle"
                },
                opacity: {
                    value: 0.7,
                    random: true
                },
                size: {
                    value: 6,
                    random: true
                },
                move: {
                    enable: true,
                    speed: 20,
                    direction: "bottom",
                    random: true,
                    straight: true,
                    out_mode: "out"
                },
                line_linked: {
                    enable: false
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: false
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    }
                },
                modes: {
                    push: {
                        particles_nb: 20
                    }
                }
            }
        });
    </script>



</body>

</html>