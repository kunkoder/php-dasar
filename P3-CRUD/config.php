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