# **LAPORAN PRAKTIKUM**

## **PEMBUATAN WEB CRUD DATA SISWA MENGGUNAKAN PHP DAN MYSQL**

---

### **Identitas Mahasiswa**

| Keterangan    | Data                                |
| ------------- | ----------------------------------- |
| Nama          | **Ananda Faris Ghazi Ramadhan**     |
| NRP           | **5025231280**                      |
| Program Studi | Teknik Informatika                  |
| Fakultas      | FTEIC                               |
| Institusi     | Institut Teknologi Sepuluh Nopember |
| Mata Kuliah   | Pemrograman Web                     |
| Topik         | CRUD PHP & MySQL                    |

---

## **1. Pendahuluan**

Perkembangan teknologi web saat ini menuntut kemampuan dalam mengelola data secara dinamis dan terstruktur. Salah satu konsep dasar yang wajib dikuasai dalam pengembangan aplikasi web adalah **CRUD (Create, Read, Update, Delete)**. Konsep ini digunakan untuk melakukan manipulasi data pada sebuah basis data.

Praktikum ini bertujuan untuk membangun sebuah **aplikasi web sederhana manajemen data siswa** menggunakan **PHP** sebagai bahasa pemrograman server-side dan **MySQL** sebagai sistem manajemen basis data. Aplikasi ini juga mengimplementasikan **upload file foto**, sehingga mahasiswa dapat memahami keterkaitan antara pengolahan form, penyimpanan file, dan database.

---

## **2. Tujuan Praktikum**

Tujuan dari praktikum ini adalah:

1. Memahami konsep CRUD pada aplikasi web
2. Mengimplementasikan koneksi PHP dengan database MySQL
3. Mengelola input data menggunakan form HTML
4. Mengimplementasikan fitur upload dan hapus file
5. Menyusun struktur file web yang rapi dan modular
6. Memahami alur penyimpanan data dan file secara terpisah

---

## **3. Teknologi yang Digunakan**

| Teknologi | Fungsi                         |
| --------- | ------------------------------ |
| PHP       | Bahasa pemrograman server-side |
| MySQL     | Database penyimpanan data      |
| HTML      | Struktur halaman web           |
| CSS       | Styling antarmuka              |
| Apache    | Web server                     |
| XAMPP     | Web server & database lokal    |

---

## **4. Struktur File Program**

Struktur file pada aplikasi web ini adalah sebagai berikut:

```
crud-siswa/
│── index.php
│── tambah.php
│── edit.php
│── hapus.php
│── config.php
│── style.css
└── uploads/
```

**Penjelasan fungsi file:**

| File         | Fungsi                             |
| ------------ | ---------------------------------- |
| `index.php`  | Menampilkan data siswa dalam tabel |
| `tambah.php` | Form penambahan data siswa         |
| `edit.php`   | Form pengeditan data siswa         |
| `hapus.php`  | Menghapus data dan foto siswa      |
| `config.php` | Koneksi database MySQL             |
| `style.css`  | Mengatur tampilan web              |
| `uploads/`   | Menyimpan file foto siswa          |

---

## **5. Perancangan Database**

Database yang digunakan bernama **`sekolah_crud`** dengan satu tabel **`siswa`**.

### **Struktur Tabel Siswa**

| Field      | Tipe Data | Keterangan        |
| ---------- | --------- | ----------------- |
| id         | INT (PK)  | Primary Key       |
| nis        | VARCHAR   | Nomor Induk Siswa |
| nama       | VARCHAR   | Nama siswa        |
| kelas      | VARCHAR   | Kelas siswa       |
| alamat     | TEXT      | Alamat siswa      |
| foto       | VARCHAR   | Nama file foto    |
| created_at | TIMESTAMP | Waktu input data  |

---

## **6. Implementasi CRUD**

### **6.1 Create (Tambah Data)**

* Data siswa ditambahkan melalui form `tambah.php`
* Foto siswa di-upload dan disimpan di folder `uploads`
* Nama file foto disimpan di database

### **6.2 Read (Menampilkan Data)**

* Data siswa ditampilkan pada `index.php`
* Data ditampilkan dalam bentuk tabel
* Foto ditampilkan dari folder `uploads`

### **6.3 Update (Edit Data)**

* Data siswa dapat diperbarui melalui `edit.php`
* Jika foto baru diunggah, foto lama akan dihapus otomatis

### **6.4 Delete (Hapus Data)**

* Data dihapus melalui `hapus.php`
* File foto terkait ikut dihapus dari folder `uploads`

---

## **7. Alur Upload File Foto**

1. User memilih file foto melalui form
2. PHP memvalidasi ukuran dan tipe file
3. File dipindahkan ke folder `uploads`
4. Nama file disimpan di database
5. File ditampilkan kembali pada halaman utama

---

## **8. Hasil dan Pembahasan**

Hasil dari praktikum ini adalah sebuah aplikasi web CRUD yang dapat:

* Menyimpan dan menampilkan data siswa
* Mengedit dan menghapus data
* Mengelola file upload dengan aman
* Menghapus file foto secara otomatis saat data dihapus

Aplikasi berjalan dengan baik pada web server lokal XAMPP dan berhasil mengimplementasikan konsep CRUD secara lengkap.

---

## **9. Kesimpulan**

Berdasarkan praktikum yang telah dilakukan, dapat disimpulkan bahwa:

1. Konsep CRUD merupakan dasar penting dalam pengembangan web
2. PHP dan MySQL dapat digunakan untuk membangun aplikasi web dinamis
3. Penyimpanan file sebaiknya dipisahkan dari database
4. Struktur file yang rapi memudahkan pengembangan dan pemeliharaan aplikasi

---
