<?php
require "config.php";

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) { header("Location: index.php"); exit; }

// ambil data dulu untuk foto
$stmt = $conn->prepare("SELECT foto FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
  $foto = $row["foto"];

  // hapus record
  $stmt = $conn->prepare("DELETE FROM siswa WHERE id=?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  // hapus file foto
  if (!empty($foto) && file_exists("uploads/".$foto)) {
    unlink("uploads/".$foto);
  }
}

header("Location: index.php");
exit;
