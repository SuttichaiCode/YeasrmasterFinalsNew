<!-- หน้าเข้าสู่ระบบ -->

<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
            background: rgba(248, 245, 245, 0.4);
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



        .alert {
            border-radius: 8px;
        }

        a {
            font-size: 20px;
            color: rgb(255, 255, 255);
            /* ขนาดฟอนต์ */

        }

        hr {
            margin: 20px 0;
        }

        h3 {
            text-align: center;

        }

        .btn-primary {
            width: 100%;
            border-radius: 8px;
            background-color: rgb(14, 116, 10);
            border-color: darkgreen;
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

        .form-check-input {
            background-color: rgb(252, 252, 252);

        }

        .form-check-input:checked {
            background-color: darkgreen !important;
            border-color: darkgreen !important;
        }
    </style>

</head>

<body>
    <div id="particles-js"></div>
    <div class="container">
        <h3 class="mt-4">เข้าสู่ระบบ</h3>
        <hr>
        <form action="signin_db.php" method="post" onsubmit="saveLoginData()">
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>

            <button type="submit" name="signin" class="btn btn-primary">Sign In</button>
        </form>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
        <script>
            const secretKey = "my_secret_key"; // โค้ตส่วนนี้ เมื่อกดติ้ก remember me จะเก็บรหัสผ่านไว้ใน localStorage  

            function saveLoginData() {
                if (document.getElementById("remember").checked) {
                    localStorage.setItem("email", document.getElementById("email").value);
                    let encryptedPassword = CryptoJS.AES.encrypt(document.getElementById("password").value, secretKey).toString();
                    localStorage.setItem("password", encryptedPassword);
                    localStorage.setItem("remember", "true");
                } else {
                    localStorage.removeItem("email");
                    localStorage.removeItem("password");
                    localStorage.setItem("remember", "false");
                }
            }

            window.onload = function() {
                if (localStorage.getItem("remember") === "true") {
                    document.getElementById("remember").checked = true;

                    let storedEmail = localStorage.getItem("email");
                    let storedPassword = localStorage.getItem("password");

                    if (storedEmail) {
                        document.getElementById("email").value = storedEmail;
                    }
                    if (storedPassword && storedPassword !== "") {
                        try {
                            let decryptedPassword = CryptoJS.AES.decrypt(storedPassword, secretKey).toString(CryptoJS.enc.Utf8);
                            if (decryptedPassword) {
                                document.getElementById("password").value = decryptedPassword;
                            }
                        } catch (e) {
                            console.error("Error decrypting password:", e);
                        }
                    }
                }
            };
        </script>





        <hr>
        <p>ยังไม่เป็นสมาชิกใช่ไหม คลิ๊กที่นี่เพื่อ <a href="register.php">สมัครสมาชิก</a></p>
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
                    value: 5,
                    random: true
                },
                move: {
                    enable: true,
                    speed: 25,
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