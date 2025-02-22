<?php
   session_start();
   
    if( !isset($_SESSION["login"]) ) {
      header("location: login.php");
   exit;
   }

   require 'functions.php';

   $id = $_GET["id"];
   $mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];

   if(isset($_POST["submit"])) {
      if(ubah($_POST) > 0) {
         echo "
               <script>
                     Swal.fire({
                     title: 'Berhasil!',
                     text: 'Data Berhasil Diubah',
                     icon: 'success',
                     confirmButtonText: 'OK'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         window.location.href = 'index.php';
                     }
                 });
               </script>
               ";
      } else {
         echo "
         <script>
               Swal.fire({
                     title: 'Gagal!',
                     text: 'Data Gagal Diubah',
                     icon: 'error',
                     confirmButtonText: 'OK'
                 }).then((result) => {
                     if (result.isConfirmed) {
                         window.location.href = 'index.php';
                     }
                 });
         </script>
         ";
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Ubah Data Mahasiswa</title>
      <style>
         /* Reset Style */
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
         }

         body {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
         }

         .container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            animation: fadeIn 0.5s ease-in-out;
         }

         h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #0072ff;
            font-size: 22px;
         }

         form {
            display: flex;
            flex-direction: column;
         }

         label {
            font-weight: bold;
            margin-top: 12px;
            color: #333;
         }

         input {
            padding: 10px;
            margin-top: 5px;
            border: 2px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: 0.3s;
         }

         input:focus {
            border-color: #0072ff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            outline: none;
         }

         .preview-container {
            text-align: center;
            margin-top: 10px;
         }

         .preview-container img {
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-top: 5px;
         }

         button {
            background: #0072ff;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
         }

         button:hover {
            background: #0056b3;
            transform: scale(1.05);
         }

         .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #0072ff;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
         }

         .back-link:hover {
            text-decoration: underline;
            color: #0056b3;
         }

         /* Animasi Fade In */
         @keyframes fadeIn {
            from {
               opacity: 0;
               transform: translateY(-10px);
            }
            to {
               opacity: 1;
               transform: translateY(0);
            }
         }
      </style>
   </head>
   <body>
      <div class="container">
         <h1>Ubah Data Mahasiswa</h1>

         <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
            <input type="hidden" name="GambarLama" value="<?= $mhs["gambar"]; ?>">

            <label for="nama">Nama :</label> 
            <input type="text" name="nama" id="nama" value="<?= $mhs["nama"]; ?>" required>  

            <label for="nrp">NRP :</label> 
            <input type="text" name="nrp" id="nrp" value="<?= $mhs["nrp"]; ?>" required>  

            <label for="jurusan">Jurusan :</label> 
            <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"]; ?>" required>  

            <label for="email">Email :</label> 
            <input type="email" name="email" id="email" value="<?= $mhs["email"]; ?>" required>  

            <label for="gambar">Gambar :</label>
            <div class="preview-container">
               <img src="image/<?= $mhs['gambar']; ?>" width="70">
            </div>
            <input type="file" name="gambar" id="gambar">   

            <button type="submit" name="submit">Ubah Data!</button>

            <a href="index.php" class="back-link">Kembali ke Halaman Utama</a>
         </form>
      </div>
   </body>
</html>