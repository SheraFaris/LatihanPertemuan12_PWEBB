<?php
require "config.php";

$q = $conn->query("SELECT * FROM siswa ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>CRUD Siswa</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Manajemen Data Siswa</h1>
    <a class="btn btn-primary" href="tambah.php">+ Tambah Siswa</a>

    <table>
      <thead>
        <tr>
          <th>Foto</th>
          <th>NIS</th>
          <th>Nama</th>
          <th>Kelas</th>
          <th>Alamat</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($q->num_rows === 0): ?>
        <tr><td colspan="6">Belum ada data.</td></tr>
      <?php else: ?>
        <?php while($row = $q->fetch_assoc()): ?>
          <tr>
            <td>
              <?php if (!empty($row["foto"]) && file_exists("uploads/".$row["foto"])): ?>
                <img class="foto" src="<?="uploads/".$row["foto"]?>" alt="foto">
              <?php else: ?>
                <small>(tidak ada)</small>
              <?php endif; ?>
            </td>
            <td><?=htmlspecialchars($row["nis"])?></td>
            <td><?=htmlspecialchars($row["nama"])?></td>
            <td><?=htmlspecialchars($row["kelas"])?></td>
            <td><?=nl2br(htmlspecialchars($row["alamat"] ?? ""))?></td>
            <td class="actions">
              <a class="btn btn-secondary" href="edit.php?id=<?=$row["id"]?>">Edit</a>
              <a class="btn btn-danger"
                 href="hapus.php?id=<?=$row["id"]?>"
                 onclick="return confirm('Yakin hapus data ini? Foto juga akan dihapus.');">
                 Hapus
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
