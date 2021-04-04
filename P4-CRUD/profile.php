<?php
    require "config.php";
    session_start();

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
    $posts = findAll("SELECT * FROM post WHERE user_id='$user_id' ORDER BY created_at DESC");

    // Memeriksa method post yang dikirim ke halaman ini
    if(isset($_POST["update"])) {
        $user_id = $_POST["id"];
        $username = $_POST["username"];
        $email = $_POST["email"];

        $exist = findOne("SELECT * FROM user WHERE username = '$username'");
        if($username != $user["username"] && $exist != null) {
            echo"
            <script>
                alert('Username telah terdaftar, pilih username lain');
                document.location.href = 'profile.php';
            </script>";
        }
        else {
            $update_user = commit("UPDATE user SET username = '$username', email = '$email' WHERE id = '$user_id'");
            if($update_user > 0) {
                echo"
                <script>
                    alert('Profile berhasil diubah');
                    document.location.href = 'profile.php';
                </script>";
            }
            else {
                echo"
                <script>
                    alert('Profile gagal diubah');
                    document.location.href = 'profile.php';
                </script>";
            }
        }
    }

    // Memeriksa method get yang dikirim ke halaman ini
    if(isset($_GET["delete"])) {
        $post_id = $_GET["delete"];

        $delete_post = commit("DELETE FROM post WHERE id='$post_id'");
        if($delete_post < 0) {
            echo"
            <script>
                alert('Post gagal dihapus');
                document.location.href = 'profile.php';
            </script>";
        }
        echo"
        <script>
            alert('Post berhasil dihapus');
            document.location.href = 'profile.php';
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
        Profile . Argon
    </title>

    <!-- Nucleo Icons -->
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
</head>

<body class="profile-page">

    <!-- Navbar -->
    <nav id="navbar-main"
        class="navbar navbar-main navbar-expand-lg bg-white navbar-light position-sticky top-0 shadow py-2">
        <div class="container">
            <a class="navbar-brand mr-lg-5" href="index.php">
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
                        <a href="index.php" class="nav-link" role="button">
                            <i class="ni ni-collection d-lg-none"></i>
                            <span class="nav-link-inner--text">Home</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link" role="button">
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
        </div>
        <section class="section bg-secondary">
            <div class="container">
                <div class="card card-profile shadow mt--300">
                    <div class="px-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image mt-3">
                                    <a href="javascript:;">
                                    
                                    <?php if($user["avatar"] != null) : ?>
                                        <img src="avatar/<?= $user["avatar"]; ?>" class="rounded-circle" width="170" height="170">
                                    <?php else : ?>
                                        <img src="assets/img/faces/team-1.jpg" class="rounded-circle" width="170" height="170">
                                    <?php endif; ?>
                                        
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-9">
                            <h3><?= $user["username"]; ?></h3>
                            <div class="h6 font-weight-300"><?= $user["email"]; ?></div>
                        </div>
                        <div class="mt-5 py-5 border-top text-center">
                            <div class="row justify-content-center">
                                <div class="col-lg-9">
                                    <form role="form" method="post" enctype="multipart/form-data">
                                        <input value="<?= $user["id"]; ?>" type="hidden" name="id">
                                        <input value="" type="hidden" name="old_avatar">
                                        <div class="form-group mb-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-single-02"></i></span>
                                                </div>
                                                <input class="form-control" value="<?= $user["username"]; ?>" type="text" name="username" required>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                                </div>
                                                <input class="form-control" value="<?= $user["email"]; ?>" type="email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile"
                                                name="new_avatar">
                                            <label class="custom-file-label" for="customFile">Pilih gambar</label>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary my-4"
                                                name="update">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="section section-typography">
            <div class="container">
                <div class="mx-auto text-center">
                    <h2 class="font-weight-bold mb-5">Ceritaku</h2>
                </div>
                
                <?php foreach($posts as $post) : ?>
                    <div class="row py-3 align-items-center">
                        <div class="col-sm-3 text-center">

                            <?php if($user["avatar"] != null) : ?>
                                <img src="avatar/<?= $user["avatar"]; ?>" alt="Rounded image" class="rounded shadow"
                                    width="120" height="120">
                            <?php else : ?>
                                <img src="assets/img/faces/team-1.jpg" alt="Rounded image" class="rounded shadow"
                                    width="120" height="120">
                            <?php endif; ?>
                            
                        </div>
                        <div class="col-sm-9">
                            <p class="font-weight-bold">
                                <?= $user["username"]; ?>
                                    <small class="text-muted"><?= $post["created_at"]; ?></small>
                                    <span><a class="btn btn-danger btn-sm" href="?delete=<?= $post['id']; ?>">Hapus</a></span>
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