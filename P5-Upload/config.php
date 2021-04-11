<?php

// (host, username, password, database)
$conn = mysqli_connect("localhost", "root", "", "sosmed");

// Memeriksa apakah database terhubung
if(!$conn) {
    echo"
    <script>
        alert('Database tidak terhubung');
    </script>";
 }

// Memeriksa apakah query berhasil, bernilai > 0 jika berhasil dan < 0 jika gagal
function commit($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $affected = mysqli_affected_rows($conn);
    return $affected; // Mengembalikan nilai > 0 atau < 0
}

// Mengambil 1 baris data
function findOne($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row; // Mengembalikan array 1 dimensi
}

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

// Mengupload foto profile, (file baru, file lama)
function uploadAvatar($new, $old) { // $new adalah array asosiatif, $old nama file lama type string
    $name = $new["name"];
    $size = $new["size"];
    $tmp_name = $new["tmp_name"];
    $valid_type = ["jpg", "jpeg", "png"]; // tipe file gambar
    $type = explode(".", $name); // "gema.nur.sidik.jpeg" => ["gema", "nur", "sidik", "jpeg"]
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