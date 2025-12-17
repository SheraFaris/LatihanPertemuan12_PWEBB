<?php
require "config.php";

function uploadFoto($file){
  if (!isset($file) || $file["error"] === UPLOAD_ERR_NO_FILE) return null;

  if ($file["error"] !== UPLOAD_ERR_OK) {
    throw new Exception("Upload gagal. Kode error: " . $file["error"]);
  }

  $maxSize = 2 * 1024 * 1024; // 2MB
  if ($file["size"] > $maxSize) {
    throw new Exception("Ukuran foto maksimal 2MB.");
  }

  $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
  $allowed = ["jpg","jpeg","png","webp"];
  if (!in_array($ext, $allowed)) {
    throw new Exception("Tipe file tidak valid. Gunakan JPG/JPEG/PNG/WEBP.");
  }

  // Pastikan folder uploads ada
  if (!is_dir("uploads")) mkdir("uploads", 0777, true);

  $newName = uniqid("siswa_", true) . "." . $ext;
  $dest = "uploads/" . $newName;

  if (!move_uploaded_file($file["tmp_name"], $dest)) {
    throw new Exception("Gagal memindahkan file.");
  }

  return $newName;
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nis    = trim($_POST["nis"] ?? "");
  $nama   = trim($_POST["nama"] ?? "");
  $kelas  = trim($_POST["kelas"] ?? "");
  $alamat = trim($_POST["alamat"] ?? "");

  try {
    if ($nis === "" || $nama === "" || $kelas === "") {
      throw new Exception("NIS, Nama, dan Kelas wajib diisi.");
    }

    $fotoName = uploadFoto($_FILES["foto"] ?? null);

    $stmt = $conn->prepare("INSERT INTO siswa (nis, nama, kelas, alamat, foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nis, $nama, $kelas, $alamat, $fotoName);
    $stmt->execute();

    header("Location: index.php");
    exit;
  } catch (Exception $e) {
    $error = $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Tambah Siswa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Tambah Siswa</h1>
    <a class="btn btn-secondary" href="index.php">← Kembali</a>

    <?php if ($error): ?>
      <div class="notice"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>NIS</label>
        <input type="text" name="nis" required>
      </div>
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" required>
      </div>
      <div class="form-group">
        <label>Kelas</label>
        <input type="text" name="kelas" required>
      </div>
      <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat"></textarea>
      </div>
      <div class="form-group">
        <label>Foto (opsional)</label>
        <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp">
        <small>Maks 2MB. Format: JPG/JPEG/PNG/WEBP.</small>
      </div>

      <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
  </div>
</body>
</html>
