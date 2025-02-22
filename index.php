<?php
session_start();

// Jika sesi tidak ada, arahkan ke halaman login
if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

require 'functions.php';

// Pagination
$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// Jika ada pencarian, ubah query dan reset pagination
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
    $jumlahData = count($mahasiswa);
    $jumlahHalaman = ($jumlahData > 0) ? ceil($jumlahData / $jumlahDataPerHalaman) : 1;
    $halamanAktif = 1;
} else {
    $mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData, $jumlahDataPerHalaman");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Halaman Admin</title>
    <style>
        /* Reset Style */
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: "Poppins", sans-serif;
      }

      /* Body Styling */
      body {
         background-color: #f4f4f4;
         color: #333;
         padding: 20px;
      }

      /* Container Styling */
      .container {
         max-width: 1000px;
         margin: auto;
         background: white;
         padding: 20px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      /* Heading */
      h1 {
         text-align: center;
         margin-bottom: 20px;
         color: #007bff;
      }

      /* Button Container */
      .button-container {
         display: flex;
         justify-content: space-between;
         margin-bottom: 20px;
      }

      /* Button Styling */
      .button-container {
         display: flex;
         justify-content: space-between;
         align-items: center;
      }

      .right-buttons {
         display: flex;
         gap: 10px;
      }

      .btn {
         text-decoration: none;
         color: white;
         background: #007bff;
         padding: 10px 15px;
         border-radius: 5px;
         transition: 0.3s;
         text-align: center;
         min-width: 100px;
      }

      .btn:hover {
         opacity: 0.8;
      }

      .tambah {
         background:  #007bff;
      }

      .tambah:hover {
         background: #0056b3;
      }

      .logout {
         background: #dc3545;
      }

      .logout:hover {
         background: #b02a37;
      }

      .cetak {
         background: #007bff;
      }

      .cetak:hover {
         background: #0056b3;
      }

      /* Form Pencarian */
      form {
         display: flex;
         justify-content: center;
         gap: 10px;
         margin-bottom: 20px;
      }

      input[type="text"] {
         width: 60%;
         padding: 10px;
         border: 1px solid #ccc;
         border-radius: 5px;
         font-size: 16px;
      }

      input[type="text"]:focus {
         outline: none;
         border-color: #007bff;
         box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      }

      button {
         background: #007bff;
         color: white;
         border: none;
         padding: 10px 15px;
         font-size: 16px;
         border-radius: 5px;
         cursor: pointer;
         transition: 0.3s;
      }

      button:hover {
         background: #0056b3;
      }

      /* Table Styling */
      table {
         width: 100%;
         border-collapse: collapse;
      }

      th, td {
         border: 1px solid #ddd;
         padding: 12px;
         text-align: center;
         vertical-align: middle;
      }

      th {
         background-color: #007bff;
         color: white;
      }

      tr:nth-child(even) {
         background-color: #f9f9f9;
      }

      tr:hover {
         background-color: #f1f1f1;
      }

      /* Image Styling */
      img {
         border-radius: 5px;
         transition: 0.3s;
      }

      img:hover {
         transform: scale(1.1);
      }

      /* Aksi Styling */
      td.aksi {
         vertical-align: middle;
         height: 100%;
      }

      .aksi {
         display: flex;
         justify-content: center;
         align-items: center;
         gap: 10px;
         height: 100%;
      }

      .aksi a {
         padding: 8px 12px;
         font-size: 14px;
         border-radius: 5px;
         text-decoration: none;
         display: flex;
         justify-content: center;
         align-items: center;
         min-width: 80px; /* Memastikan ukuran seragam */
         height: 35px; /* Menyesuaikan tinggi tombol agar sejajar */
         text-align: center;
      }

      .ubah {
         background: #ffc107;
         color: white;
      }

      .ubah:hover {
         background: #d39e00;
      }

      .hapus {
         background: #dc3545;
         color: white;
      }

      .hapus:hover {
         background: #b02a37;
      }

      /* Pagination Styling */
      .pagination {
         display: flex;
         justify-content: center;
         margin-top: 20px;
         gap: 5px;
      }

      .pagination a, .pagination span {
         text-decoration: none;
         padding: 8px 12px;
         border-radius: 5px;
         font-size: 16px;
         border: 1px solid #007bff;
         color: #007bff;
         transition: 0.3s;
      }

      .pagination a:hover {
         background: #007bff;
         color: white;
      }

      .pagination .active {
         background: #007bff;
         color: white;
         font-weight: bold;
      }
      
      @media print {
         .logout, .tambah, .form-cari, .aksi2 {
            display: none;
         }
      }
    </style>
</head>
<body>

    <div class="container">
        <h1>Daftar Mahasiswa</h1>

         <div class="button-container">
            <a href="tambah.php" class="btn tambah">Tambah Data Mahasiswa</a>
            <div class="right-buttons"> 
               <a href="logout.php" class="btn logout">Logout</a>
            </div>
         </div>


        <form action="" method="post" class="form-cari">
            <input type="text" name="keyword" size="40" 
               autofocus placeholder="Masukkan Keyword Pencarian..." autocomplete="off" id="keyword">
            <button type="submit" name="cari" id="tombolcari">Cari</button>
        </form>

        <!-- Pagination -->
        <div class="pagination">
            <?php if ($halamanAktif > 1) : ?>
                <a href="?halaman=<?= $halamanAktif - 1; ?>">❮ Kembali</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                <?php if ($i == $halamanAktif) : ?>
                    <span class="active"><?= $i; ?></span>
                <?php else : ?>
                    <a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($halamanAktif < $jumlahHalaman) : ?>
                <a href="?halaman=<?= $halamanAktif + 1; ?>">Berikutnya ❯</a>
            <?php endif; ?>
        </div>
        
        <br><br>
      <div id="container">
        <table>
            <tr>
                <th>No.</th>
                <th>Nrp</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
                <th class="aksi2">Aksi</th>
            </tr>

            <?php $i = $awalData + 1; ?>
            <?php foreach ($mahasiswa as $row) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row["nrp"]; ?></td>
                    <td><img src="image/<?= $row["gambar"]; ?>" width="70"></td>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["email"]; ?></td>
                    <td><?= $row["jurusan"]; ?></td>
                    <td class="aksi" class="aksi2">
                        <a href="ubah.php?id=<?= $row["id"]; ?>" class="ubah">Ubah</a>
                        <a href="hapus.php?id=<?= $row["id"]; ?>" data-id="<?= $row['id']; ?>" class="hapus">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
      </div>
   
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
         document.querySelectorAll('.hapus').forEach(button => {
            button.addEventListener('click', function (e) {
                  e.preventDefault();
                  const id = this.getAttribute('data-id');
                  Swal.fire({
                     title: "Apakah Anda Yakin?",
                     text: "Coba Fikirkan Lagi",
                     icon: "warning",
                     showCancelButton: true,
                     confirmButtonColor: "#3085d6",
                     cancelButtonColor: "#d33",
                     confirmButtonText: "Hapus Data"
                  }).then((result) => {
                     if (result.isConfirmed) {
                        window.location.href = `hapus.php?id=${id}`;
                     }
                  });
            });
         });
      </script>
   <script src="js/jquery-3.7.1.min.js"></script>
   <script src="js/script.js"></script>
</body>
</html>
