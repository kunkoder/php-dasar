<?php
 	require "config.php";
 	session_start();

 	// Memeriksa method post yang dikirim ke halaman ini
 	if(isset($_POST["login"])) {
 		$username = $_POST["username"];
 		$password = $_POST["password"];

 		$user = findOne("SELECT * FROM user WHERE username = '$username'");
 		if($user != null) {

 			// Memeriksa apakah password benar
 			if(password_verify($password, $user["password"])) {

 				// Membuat session login berupa id user
 				$_SESSION["login"] = $user["id"];

 				// Login ke halaman admin
 				if($user["role"] == "admin") {
 					$_SESSION["admin"] = true;
 					echo"
 					<script>
 						document.location.href = 'admin.php';
 					</script>";
 				}
 				else {
 					echo"
 					<script>
 						document.location.href = 'index.php';
 					</script>";
 				}
 			}
 			else {
 				echo"
 				<script>
 					alert('Password salah');
 					document.location.href = 'login.php';
 				</script>";
 			}
 		}
 		else {
 			echo"
 			<script>
 				alert('Username belum terdaftar, silahkan register');
 				document.location.href = 'login.php';
 			</script>";
 		}
 	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>
        Login . Argon
    </title>

    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
</head>

<body class="index-page">
    <div class="wrapper">
        <div class="section section-hero section-shaped">
            <div class="shape shape-style-1 shape-primary" style="position: fixed;">
                <span class="span-150"></span>
                <span class="span-50"></span>
                <span class="span-50"></span>
                <span class="span-75"></span>
                <span class="span-100"></span>
                <span class="span-75"></span>
                <span class="span-50"></span>
                <span class="span-100"></span>
                <span class="span-50"></span>
                <span class="span-100"></span>
            </div>
            <div class="page-header pt-5">
                <div class="container shape-container d-flex align-items-center py-lg">
                    <div class="col px-0">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-5 text-center">
                                <div class="card bg-secondary shadow border-0">
                                    <div class="card-body px-lg-5 py-lg-5">
                                        <div class="text-center text-muted mb-4">
                                            <p class="h4 font-weight-bold">Login</p>
                                        </div>
                                        <form role="form" method="post">
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="ni ni-single-02"></i></span>
                                                    </div>
                                                    <input class="form-control" placeholder="Username" type="text"
                                                        name="username" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group input-group-alternative">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="ni ni-lock-circle-open"></i></span>
                                                    </div>
                                                    <input class="form-control" placeholder="Password" type="password"
                                                        name="password" required>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary mt-4"
                                                    name="login">Masuk</button>
                                            </div>
                                            <div class="text-center">
                                                <a class="nav-link mt-3" href="register.php">Belum punya akun?</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container text-center text-white fixed-bottom mb-3">
                <div class="copyright">
                    &copy; 2021 Creative Tim</a>.
                </div>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/argon-design-system.min.js?v=1.2.2" type="text/javascript"></script>
</body>

</html>