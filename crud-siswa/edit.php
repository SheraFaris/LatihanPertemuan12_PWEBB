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

  if (!is_dir("uploads")) mkdir("uploads", 0777, true);

  $newName = uniqid("siswa_", true) . "." . $ext;
  $dest = "uploads/" . $newName;

  if (!move_uploaded_file($file["tmp_name"], $dest)) {
    throw new Exception("Gagal memindahkan file.");
  }

  return $newName;
}

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) { header("Location: index.php"); exit; }

$stmt = $conn->prepare("SELECT * FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) { header("Location: index.php"); exit; }

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

    $newFoto = uploadFoto($_FILES["foto"] ?? null);
    $fotoFinal = $data["foto"];

    // jika upload foto baru, hapus foto lama
    if ($newFoto !== null) {
      if (!empty($fotoFinal) && file_exists("uploads/".$fotoFinal)) {
        unlink("uploads/".$fotoFinal);
      }
      $fotoFinal = $newFoto;
    }

    $stmt = $conn->prepare("UPDATE siswa SET nis=?, nama=?, kelas=?, alamat=?, foto=? WHERE id=?");
    $stmt->bind_param("sssssi", $nis, $nama, $kelas, $alamat, $fotoFinal, $id);
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
  <title>Edit Siswa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Edit Siswa</h1>
    <a class="btn btn-secondary" href="index.php">← Kembali</a>

    <?php if ($error): ?>
      <div class="notice"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>NIS</label>
        <input type="text" name="nis" value="<?=htmlspecialchars($data["nis"])?>" required>
      </div>
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" value="<?=htmlspecialchars($data["nama"])?>" required>
      </div>
      <div class="form-group">
        <label>Kelas</label>
        <input type="text" name="kelas" value="<?=htmlspecialchars($data["kelas"])?>" required>
      </div>
      <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat"><?=htmlspecialchars($data["alamat"] ?? "")?></textarea>
      </div>

      <div class="form-group">
        <label>Foto Saat Ini</label>
        <?php if (!empty($data["foto"]) && file_exists("uploads/".$data["foto"])): ?>
          <img class="foto" src="<?="uploads/".$data["foto"]?>" alt="foto">
        <?php else: ?>
          <small>(tidak ada)</small>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label>Ganti Foto (opsional)</label>
        <input type="file" name="foto" accept=".jpg,.jpeg,.png,.webp">
        <small>Maks 2MB. Jika upload baru, foto lama otomatis dihapus.</small>
      </div>

      <button class="btn btn-primary" type="submit">Update</button>
    </form>
  </div>
</body>
</html>
