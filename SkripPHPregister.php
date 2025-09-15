<?php
// Koneksi ke database
$host = "localhost";
$db   = "mywebsite";
$user = "root";      // sesuaikan dengan user MySQL-mu
$pass = "";          // sesuaikan dengan password MySQL-mu

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$username = $_POST['username'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

// Cek apakah username atau email sudah ada
$check = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if($check->num_rows > 0){
    echo "Username atau email sudah digunakan!";
} else {
    // Simpan data ke database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if($stmt->execute()){
        echo "Daftar berhasil! <a href='login.html'>Login di sini</a>";
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }

    $stmt->close();
}

$check->close();
$conn->close();
?>
