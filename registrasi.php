<?php
   require 'functions.php';

   if(isset($_POST["register"])) {
      if(registrasi($_POST) > 0) {
         echo "<script>
                  Swal.fire({
                              title: 'Data Baru Berhasil Ditambahkan!',
                              icon: 'success',
                              draggable: true
                              });
                  document.location.href = 'login.php';
               </script>";
      } else {
         echo mysqli_error($conn);
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Halaman Registrasi</title>
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

         .register-link {
         margin-top: 10px;
         font-size: 14px;
      }

      .register-link a {
         color: #1e3c72;
         text-decoration: none;
         font-weight: bold;
      }

      .register-link a:hover {
         text-decoration: underline;
      }
      </style>
   </head>
   <body>
      <div class="container">
         <h1>Halaman Registrasi</h1>

         <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autocomplete="off">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="password2">Konfirmasi Password</label>
            <input type="password" name="password2" id="password2" required>

            <button type="submit" name="register">Register</button>

            <p class="register-link">Sudah Punya Akun? <a href="login.php">Login Disini</a></p>
         </form>
      </div>
   </body>
</html>
