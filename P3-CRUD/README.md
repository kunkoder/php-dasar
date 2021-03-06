
# :memo: CRUD

Folder ini berisi penerapan create dan read data dengan bahasa pemrograman PHP. Materi yang dibahas meliputi:
* Menambah data
* Menampilkan data
* Relasi antar tabel

## :package: Prasyarat

Sebelum memulai, pastikan telah terinstall:
* MySQL atau MariaDB
* PHP 5 atau PHP 7
* Text editor
* Web browser
* Web server
* Materi P2-Authentication

**Struktur Folder P2-Authentication**

```text
├── assets
│   └── ...
├── images
│   └── ...
├── README.md
├── admin.html
├── edit.html
├── index.php
├── login.php
├── profile.html
├── register.php
└── sosmed.sql
```

## :computer: Langkah Kerja

* Ubah format file `admin.html` menjadi `.php`.
* Tambahkan script di baris pertama file `admin.php`.

	**admin.php**
	```bash
	<?php
		require "config.php";
		session_start();

		// Memeriksa user logout atau belum login
		if(!isset($_SESSION["login"]) || isset($_GET["logout"]) || !isset($_SESSION["admin"])) {
			session_destroy();
			echo"
			<script>
				document.location.href = 'login.php';
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

	* `if(!isset($_SESSION["login"]) || isset($_GET["logout"]) || !isset($_SESSION["admin"]))`

* Tambahkan script di file `index.php`.

	**index.php**
	```bash
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

	<!-- Skip -->

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
	```
	
	* `date_default_timezone_set("Asia/Jakarta");`
	* `$user_id = $_SESSION["login"];`
	* `$user = findOne("SELECT * FROM user WHERE id = '$user_id'");`
	* `$posts = findAll("SELECT u.*, p.* FROM post p INNER JOIN user u WHERE p.user_id=u.id ORDER BY created_at DESC");`
	* `if(isset($_POST["post"]))`
	* `$created_at = date("Y-m-d H:i:s");`
	* `$create_post = commit("INSERT INTO post SET user_id='$user_id', content='$content', created_at='$created_at'");`
	* `<?php foreach($posts as $post) : ?>`
	* `<?php if($post["avatar"] != null) : ?>`

* Tambahkan script di file `config.php`.

	**config.php**
	```bash
	// Skip

	// Mengambil lebih dari 1 baris data
	function findAll($query) {
		global $conn;
		$result = mysqli_query($conn, $query);
		$rows = [];
		while($row = mysqli_fetch_assoc($result)) {
			array_push($rows, $row);
		}
		return $rows; // Mengembalikan array 2 dimensi
	}
	```

	* `function findAll($query)`
	* `while($row = mysqli_fetch_assoc($result))`
	* `array_push($rows, $row);`

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.