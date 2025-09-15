<?php
// ============================
// Koneksi Database
// ============================
$host = "localhost";
$db   = "mywebsite";
$user = "root";      // sesuaikan user MySQL-mu
$pass = "";          // sesuaikan password MySQL-mu

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ============================
// Proses Register
// ============================
$message = ""; // pesan sukses / error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password

    // cek apakah username/email sudah ada
    $check = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Username atau email sudah digunakan!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $message = "Daftar berhasil! Silakan login.";
        } else {
            $message = "Terjadi kesalahan: " . $stmt->error;
        }
        $stmt->close();
    }
    $check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home - VIV Page</title>
  <style>
    /* Reset & base */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; display: flex; min-height: 100vh; background: #f0f2f5; }

    /* Sidebar */
    .sidebar { width: 220px; background: #2c3e50; color: white; padding: 20px; flex-shrink: 0; }
    .sidebar h2 { margin-bottom: 20px; font-size: 24px; }
    .sidebar a { display: block; color: white; text-decoration: none; margin: 12px 0; padding: 8px 10px; border-radius: 5px; transition: background 0.3s; }
    .sidebar a:hover { background: #34495e; }

    /* Content area */
    .content { flex: 1; padding: 40px; }
    .content h1 { font-size: 32px; margin-bottom: 20px; color: #2c3e50; }
    .content p { font-size: 18px; margin-bottom: 30px; color: #555; }
    .message { margin-bottom: 20px; color: red; font-weight: bold; }

    /* Form styling */
    form { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
    input { width: 100%; padding: 8px; margin: 8px 0; border-radius: 5px; border: 1px solid #ccc; }
    button { padding: 10px 20px; background: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #34495e; }

    /* Grid sections */
    .content-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
    .column { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); transition: transform 0.3s; }
    .column:hover { transform: translateY(-5px); }
    .column h2 { margin-bottom: 10px; color: #2c3e50; }
    .column p { color: #555; }

    /* Responsive */
    @media (max-width: 768px) { body { flex-direction: column; } .sidebar { width: 100%; height: auto; } }
  </style>
</head>
<body>
  <div class="sidebar">
    <h2>Menu</h2>
    <a href="index.php">Home</a>
    <a href="about.html">About</a>
    <a href="#">Services</a>
    <a href="#">Portfolio</a>
    <a href="#">Contact</a>
  </div>

  <div class="content">
    <h1>Welcome to VIV Page</h1>
    <p>Explore the sections below and see what we can do!</p>

    <?php if($message != ""): ?>
      <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <h2>Daftar Akun</h2>
    <form action="index.php" method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Daftar</button>
    </form>

    <div class="content-grid">
      <div class="column">
        <a href="https://jigolokayitolun.xyz/ekonomi-rakyat-menuju-era-digital/" target="_blank" style="text-decoration: none; color: inherit">
          <h2>isi</h2>
          <p>Baca artikelnya di sini</p>
        </a>
      </div>
      <div class="column">
        <h2>Section 2</h2>
        <p>This is some sample content for the second section.</p>
      </div>
      <div class="column">
        <h2>Section 3</h2>
        <p>This is some sample content for the third section.</p>
      </div>
      <div class="column">
        <h2>Section 4</h2>
        <p>This is some sample content for the fourth section.</p>
      </div>
    </div>
  </div>
</body>
</html>
