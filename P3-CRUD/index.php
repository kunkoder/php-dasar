<?php
	require "config.php";
	session_start();
	date_default_timezone_set("Asia/Jakarta");

	// Memeriksa user logout atau belum login
	if(!isset($_SESSION["login"]) || isset($_GET["logout"])) {
		session_destroy();
		echo"
		<script>
			document.location.href = 'login.php';
		</script>";
	}

	$user_id = $_SESSION["login"];
	$user = findOne("SELECT * FROM user WHERE id = '$user_id'");

	// Relasi antara tabel user dan post
	$posts = findAll("SELECT u.*, p.* FROM post p INNER JOIN user u WHERE p.user_id=u.id ORDER BY created_at DESC");
		
	// Memeriksa method post yang dikirim ke halaman ini
	if(isset($_POST["post"])) {
		$content = $_POST["content"];
		$created_at = date("Y-m-d H:i:s");

		$create_post = commit("INSERT INTO post SET user_id='$user_id', content='$content', created_at='$created_at'");
		if($create_post < 0) {
			echo"
			<script>
				alert('Post gagal dikirim');
				document.location.href = 'index.php';
			</script>";
		}
		echo"
		<script>
			document.location.href = 'index.php';
		</script>";
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
		Home . Argon
	</title>

	<!-- Nucleo Icons -->
	<link href="assets/css/nucleo-icons.css" rel="stylesheet" />
	<link href="assets/css/nucleo-svg.css" rel="stylesheet" />

	<!-- CSS Files -->
	<link href="assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
</head>

<body class="index-page">

	<!-- Navbar -->
	<nav id="navbar-main"
		class="navbar navbar-main navbar-expand-lg bg-white navbar-light position-sticky top-0 shadow py-2">
		<div class="container">
			<a class="navbar-brand mr-lg-5" href="index.html">
				<img src="assets/img/brand/blue.png">
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global"
				aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="navbar-collapse collapse" id="navbar_global">
				<div class="navbar-collapse-header">
					<div class="row">
						<div class="col-6 collapse-brand">
							<a href="index.php">
								<img src="assets/img/brand/blue.png">
							</a>
						</div>
						<div class="col-6 collapse-close">
							<button type="button" class="navbar-toggler" data-toggle="collapse"
								data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false"
								aria-label="Toggle navigation">
								<span></span>
								<span></span>
							</button>
						</div>
					</div>
				</div>
				<ul class="navbar-nav navbar-nav-hover align-items-lg-center">
					<li class="nav-item">
						<a href="index.html" class="nav-link" role="button">
							<i class="ni ni-collection d-lg-none"></i>
							<span class="nav-link-inner--text">Home</span>
						</a>
					</li>
				</ul>
				<ul class="navbar-nav align-items-lg-center ml-lg-auto">
					<li class="nav-item">
						<a href="profile.html" class="nav-link" role="button">
							<i class="ni ni-circle-08 d-lg-none"></i>
							<span class="nav-link-inner--text">Profile</span>
						</a>
					</li>
					<li class="nav-item">
						<a href="?logout" class="nav-link" role="button">
							<i class="ni ni-user-run d-lg-none"></i>
							<span class="nav-link-inner--text">Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- End Navbar -->

	<div class="wrapper">
		<div class="section section-hero section-shaped">
			<div class="shape shape-style-1 shape-primary">
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
			<div class="page-header">
				<div class="container shape-container d-flex align-items-center py-lg">
					<div class="col px-0">
						<div class="row align-items-center justify-content-center">
							<div class="col-lg-7 text-center">
								<h2 class="font-weight-bold text-white">Hai, Harlequin</h2>
								<p class="lead text-white">Ceritakan harimu!</p>
								<div class="btn-wrapper mt-3">
									<form method="post">
										<textarea class="form-control" rows="5" placeholder="Hmmm..." name="content" required></textarea>
										<button type="submit" class="btn btn-primary mt-3" name="post">Bagikan</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section section-typography">
			<div class="container">
				<div class="mx-auto text-center">
					<h2 class="font-weight-bold mb-5">Cerita Temanmu</h2>
				</div>
				
				<?php foreach($posts as $post) : ?>
					<div class="row py-3 align-items-center">
						<div class="col-sm-3 text-center">

							<?php if($post["avatar"] != null) : ?>
								<img src="avatar/<?= $post["avatar"]; ?>" alt="Rounded image" class="img-fluid rounded shadow"
									width="120">
							<?php else : ?>
								<img src="assets/img/faces/team-1.jpg" alt="Rounded image" class="img-fluid rounded shadow"
									width="120">
							<?php endif; ?>
									
						</div>
						<div class="col-sm-9">
							<p class="font-weight-bold">
								<?= $post["username"]; ?>
								<small class="text-muted"><?= $post["created_at"]; ?></small>
							</p>
							<p><?= $post["content"]; ?></p>
						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container text-center">
			<div class="copyright">
				&copy; 2021 Creative Tim</a>.
			</div>
		</div>
	</footer>
	</div>

	<!--   Core JS Files   -->
	<script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
	<script src="assets/js/core/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/argon-design-system.min.js?v=1.2.2" type="text/javascript"></script>
</body>

</html>