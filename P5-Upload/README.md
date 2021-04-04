
# :outbox_tray: Upload

Folder ini berisi penerapan upload file dengan bahasa pemrograman PHP. Materi yang dibahas meliputi:
* Mengupload file
* Menghapus file

## :package: Prasyarat

Sebelum memulai, pastikan telah terinstall:
* MySQL atau MariaDB
* PHP 5 atau PHP 7
* Text editor
* Web browser
* Web server
* Materi P4-CRUD

**Struktur Folder P4-CRUD**

```text
├── assets
│   └── ...
├── README.md
├── admin.php
├── edit.html
├── index.php
├── login.php
├── profile.php
├── register.php
```

## :computer: Langkah Kerja

* Tambahkan script di file `config.php`.

	**config.php**
	```bash
	// Skip

	// Mengupload foto profile, (file baru, file lama)
    function uploadAvatar($new, $old) {
        $name = $new["name"];
        $size = $new["size"];
        $tmp_name = $new["tmp_name"];
        $valid_type = ["jpg", "jpeg", "png"]; // tipe file gambar
        $type = explode(".", $name);
        $type = strtolower(end($type));

        // Memeriksa tipe file gambar
        if(!in_array($type, $valid_type)) {
            echo"
            <script>
                alert('Type file tidak didukung');
                document.location.href = '';
            </script>";
            exit(); // Membatalkan script selanjutnya
        }

        // Memeriksa ukuran file kurang dari 1 MB
        if($size > 1000000) {
            echo"
            <script>
                alert('Ukuran file terlalu besar');
                document.location.href = '';
            </script>";
            exit(); // Membatalkan script selanjutnya
        }
        
        // Membuat nama file baru
        $avatar = uniqid() . "." . $type;

        // Menghapus file lama
        if($old != null && file_exists("avatar/" . $old)) {
            unlink("avatar/" . $old);
        }

        // Menyimpan file baru
        move_uploaded_file($tmp_name, "avatar/" . $avatar);
        return $avatar; // Mengembalikan nama file baru
    }
	```

	* `function uploadAvatar($new, $old)` adalah fungsi dengan nilai balik berupa nama file untuk foto profile, mengubah `$avatar` jika ada perubahan pada foto profile.
    * `$type = explode(".", $name);` memecah string pada variabel `$name` menjadi array yang dipisahkan sesuai posisi titik pada string.
    * `strtolower();` mengubah semua character pada string menjadi huruf kecil.
	* `end($type)` mengambil index terakhir dari array `$type`.
    * `if(!in_array($type, $valid_type))` memeriksa apakah data pada variabel `$type` ada dalam salah satu index di array `$valid_type`.
    * `exit();` membatalkan script selanjutnya.
    * `uniqid();` membuat string acak yang tidak sama setiap prosesnya.
    * `file_exists()` memeriksa apakah ada file dalam direktori tertentu.
    * `unlink();` menghapus file dalam direktori tertentu.
    * `move_uploaded_file();` memindahkan file yang diupload dan diubah namanya ke dalam direktori tertentu.
    * `document.location.href = '';` kembali ke halaman terakhir.

* Tambahkan script di file `profile.php`. Perhatikan tag HTML-nya, jangan sampai salah meletakan. 

	**profile.php**
	```bash
	// Skip

    // Memeriksa method post yang dikirim ke halaman ini
    if(isset($_POST["update"])) {
        $user_id = $_POST["id"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $avatar = $_POST["old_avatar"];
        $file = $_FILES["new_avatar"];

        // Memeriksa adanya file yang diupoload, (file baru, file lama)
        if($file["name"] != null) {
            $avatar = uploadAvatar($file, $avatar);
        }
        
        $update_user = commit("UPDATE user SET username = '$username', email = '$email', avatar = '$avatar' WHERE id = '$user_id'");
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
    ```

    * `$_POST["old_avatar"];` mengambil nama file foto profile yang sekarang dipakai.
    * `$_FILES;` mengambil data file yang dikirim melalui method post ke halaman ini. Harus disertai atribut `enctype="multipart/form-data"` pada tag `<form>`.
	* `if($file["name"] != null)` memeriksa apakah ada data file yang dikirim ke halaman ini.
    * `uploadAvatar($file, $avatar);` memproses upload file di fungsi `uploadAvatar()` dengan memasukan file yang baru diupload dan nama file foto profile yang sekarang dipakai.

* Buat folder `avatar` pada direktori projek ini dibuat. 
* Tambahkan script di file `profile.php`. Perhatikan tag HTML-nya, jangan sampai salah meletakan. 

	**profile.php**
	```bash
	<!-- Skip -->

    <form role="form" method="post" enctype="multipart/form-data">
        <input value="<?= $user["id"]; ?>" type="hidden" name="id">
        <input value="<?= $user["avatar"]; ?>" type="hidden" name="old_avatar">
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

    * `enctype="multipart/form-data"` mengizinkan form mengirim file.
    * `<input value="<?= $user["avatar"]; ?>" type="hidden" name="old_avatar">` menyimpan data nama file foto profile yang sekarang dipakai. Menggunakan atribut `type="hidden"` karena tidak butuh untuk ditampilkan dalam form.

> Note: simpan folder pada directory `C:\xampp\htdocs` jika menggunakan XAMPP atau jalankan perintah `php -S localhost:8000` untuk menggunakan php server.