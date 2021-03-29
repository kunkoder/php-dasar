
# :memo: CRUD

Folder ini berisi penerapan update dan delete data dengan bahasa pemrograman PHP. Materi yang dibahas meliputi:
* Mengubah data
* Menghapus data

## :package: Prasyarat

Sebelum memulai, pastikan telah terinstall:
* MySQL atau MariaDB
* PHP 5 atau PHP 7
* Text editor
* Web browser
* Web server
* Materi P3-CRUD

**Struktur Folder P3-CRUD**

```text
├── assets
│   └── ...
├── README.md
├── admin.php
├── edit.html
├── index.php
├── login.php
├── profile.html
├── register.php
```

## :computer: Langkah Kerja

* Ubah format file `profile.html` menjadi `.php`.
* Buka file `profile.php`, ubah `<a href="index.html">` menjadi `<a href="index.php">` dan `<a href="profile.html">` menjadi `<a href="profile.php">`.
* Buka file `index.php`, ubah `<a href="profile.html">` menjadi `<a href="profile.php">` .
* Tambahkan script di baris pertama file `profile.php`, jangan lupa ubah tombol `<a href="###">` menjadi `<a href="?logout">`.

	**profile.php**
	```bash
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
                document.location.href = 'profile.php';
            </script>";
        }
    ?>

    <!-- Skip -->

	<li class="nav-item">
		<a href="?logout" class="nav-link" role="button">
			<i class="ni ni-user-run d-lg-none"></i>
			<span class="nav-link-inner--text">Logout</span>
		</a>
	</li>
	```

	* `if(!isset($_SESSION["login"])  ||  isset($_GET["logout"]))` memeriksa apakah ada session yang tersimpan atau method get dengan nama `logout` yang terkirim ke halaman ini untuk mencegah user yang belum login atau yang sudah logout untuk mengakses halaman. User akan otomatis terlempar ke halaman login.
	* `session_destroy();` menghapus session.
    * `$user = findOne("SELECT * FROM user WHERE id = '$user_id'");` mengambil 1 baris data dari tabel user dengan kriteria `id = '$user_id'`.
    * `$posts = findAll("SELECT * FROM post WHERE user_id='$user_id' ORDER BY created_at DESC");` mengambil lebih dari 1 baris data dari relasi tabel user dan post dengan kriteria `user_id` yang di tabel post` sama dengan id session yang login.
    * `if(isset($_POST["update"]))` memeriksa method post yang dikirimkan ke halaman ini dari `<button type="submit" name="update">` yang ada di akhir form.
    * `$update_user = commit("UPDATE user SET username = '$username', email = '$email' WHERE id = '$user_id'");` mengubah 1 baris data ke tabel user dan mengembalikan nilai > 0 jika berhasil dan < 0 jika gagal.
    * `if(isset($_GET["delete"])) ` memeriksa method get yang dikirimkan ke halaman ini dengan nama `delete`.
    * `$post_id = $_GET["delete"];` mengambil nilai dari method get dengan nama `delete` yaitu berupa `id` post yang akan dihapus.
    * `$delete_post = commit("DELETE FROM post WHERE id='$post_id'");` menghapus 1 baris data ke tabel post dan mengembalikan nilai > 0 jika berhasil dan < 0 jika gagal.
    * `<a href="?logout">` mengirimkan method get dengan nama `logout` ke halaman ini.

* Tambahkan script di file `profile.php`. Perhatikan tag HTML-nya, jangan sampai salah meletakan. 

	**profile.php**
	```bash
	<!-- Skip -->

	<div class="card-profile-image mt-3">
        <a href="javascript:;">

            <?php if($user["avatar"] != null) : ?>
                <img src="avatar/<?= $user["avatar"]; ?>" class="rounded-circle" width="170" height="170">
            <?php else : ?>
                <img src="assets/img/faces/team-1.jpg" class="rounded-circle" width="170" height="170">
            <?php endif; ?>

        </a>
    </div>

    <!-- Skip -->

    <div class="text-center mt-9">
        <h3><?= $user["username"]; ?></h3>
        <div class="h6 font-weight-300"><?= $user["email"]; ?></div>
    </div>

    <!-- Skip -->

    <form role="form" method="post" enctype="multipart/form-data">
        <input value="<?= $user["id"]; ?>" type="hidden" name="id">
        <input value="" type="hidden" name="old_avatar">
        <div class="form-group mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i
                            class="ni ni-single-02"></i></span>
                </div>
                <input class="form-control" value="<?= $user["username"]; ?>" type="text" name="username">
            </div>
        </div>
        <div class="form-group mb-3">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                </div>
                <input class="form-control" value="<?= $user["email"]; ?>" type="email" name="email">
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
	```

    * `<?php if($post["avatar"] != null) : ?>` jika user belum mempunyai foto profile, maka akan menampilkan foto profile default.
	* `<img src="avatar/<?= $user["avatar"]; ?>" class="rounded-circle" width="170" height="170">` mengambil data dari table user kolom `avatar`.
    * `<h3><?= $user["username"]; ?></h3>` mengambil data dari table user kolom `username`.
    * `<div class="h6 font-weight-300"><?= $user["email"]; ?></div>` mengambil data dari table user kolom `email`.
    * `<input value="<?= $user["id"]; ?>" type="hidden" name="id">` mengambil data dari table user kolom `id`. Digunakan `type="hidden"` agar form input tidak ditampilkan pada halaman tetapi datanya tetap bisa didapatlan.
    * `<input value="" type="hidden" name="old_avatar">` mengambil data dari table user kolom `avatar`. form input ini berisi nama file foto profile yang lama.

* Tambahkan script di file `profile.php`. Perhatikan tag HTML-nya, jangan sampai salah meletakan. 

	**profile.php**
	```bash
	<!-- Skip -->

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
    ```

    * `<?php foreach($posts as $post) : ?>` perulangan yang menguraikan variabel `$posts` yang berupa array asosiatif 2 dimensi sehingga tiap baris dapat diakses melalui variabel `$post`.
    * `<?php if($post["avatar"] != null) : ?>` jika user belum mempunyai foto profile, maka akan menampilkan foto profile default.
	* `<img src="avatar/<?= $post["avatar"]; ?>" alt="Rounded image" class="img-fluid rounded shadow" width="120">` mengambil data dari table user kolom `avatar`.
    * `<?php endif; ?>` mengakhiri `if`.
    * `<?= $post["username"]; ?>` mengambil data dari table post kolom `username`.
	* `<small class="text-muted"><?= $post["created_at"]; ?></small>` mengambil data dari table post kolom `created_at`.
    * `<span><a class="btn btn-danger btn-sm" href="?delete=<?= $post['id']; ?>">Hapus</a></span>` mengirimkan method get dengan nama `delete` dengan nilai `id` postingan yang akan dihapus ke halaman ini.
	* `<p><?= $post["content"]; ?></p>` mengambil data dari table post kolom `content`.
	* `<?php endforeach; ?>` mengakhiri perulangan.

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.