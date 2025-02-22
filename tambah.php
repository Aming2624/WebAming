<?php
   session_start();
   
    if( !isset($_SESSION["login"]) ) {
      header("location: login.php");
   exit;
   }

   require 'functions.php';

   if(isset($_POST["submit"])) {
      if (tambah($_POST) > 0) {
         echo "
             <script>
                 Swal.fire({
                     title: 'Berhasil!',
                     text: 'Data Berhasil Ditambahkan',
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
                     text: 'Data Gagal Ditambahkan',
                     icon: 'error',
                     confirmButtonText: 'Coba Lagi'
                 });
             </script>
         ";
     }     
   }
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Tambah Data Mahasiswa</title>
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
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 400px;
            animation: fadeIn 0.6s ease-in-out;
         }

         h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #0072ff;
            font-size: 24px;
            font-weight: 600;
         }

         form {
            display: flex;
            flex-direction: column;
         }

         label {
            font-weight: 600;
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

         /* Responsive Design */
         @media (max-width: 500px) {
            .container {
               width: 90%;
            }
         }
      </style>
   </head>
   <body>
      <div class="container">
         <h1>Tambah Data Mahasiswa</h1>

         <form action="" method="post" enctype="multipart/form-data">
            <label for="nama">Nama :</label> 
            <input type="text" name="nama" id="nama" required autocomplete="off">  

            <label for="nrp">NRP :</label> 
            <input type="text" name="nrp" id="nrp" required autocomplete="off">  

            <label for="jurusan">Jurusan :</label> 
            <input type="text" name="jurusan" id="jurusan" required autocomplete="off">  

            <label for="email">Email :</label> 
            <input type="email" name="email" id="email" required autocomplete="off">  

            <label for="gambar">Gambar :</label> 
            <input type="file" name="gambar" id="gambar" autocomplete="off">  

            <button type="submit" name="submit">Tambah Data!</button>

            <a href="index.php" class="back-link">Kembali ke Halaman Utama</a>
         </form>
      </div>
   </body>
</html>