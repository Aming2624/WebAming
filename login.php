<?php
   session_start();
   require 'functions.php';

   /* cek cookie */
   if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
      $id = $_COOKIE['id'];
      $key = $_COOKIE['key'];

      /* ambil username berdasarkan id */
      $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
      $row = mysqli_fetch_assoc($result);

      /* cek cookie dan username */
      if( $key === hash('sha256', $row['username']) ) {
         $_SESSION['login'] = true;
      }
   }

   if( isset($_SESSION["login"]) ) {
      header("location: index.php");
      exit;
   }

   if(isset($_POST["login"])) {
      $username = $_POST["username"];
      $password = $_POST["password"];

      // Perbaikan query
      $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

      // Cek username
      if(mysqli_num_rows($result) === 1) {
         
         // Ambil data user
         $row = mysqli_fetch_assoc($result);
         
         // Cek password
         if(password_verify($password, $row["password"])) {

            /* set session */
            $_SESSION["login"] = true;

            /* cek remember me */
            if( isset($_POST['remember']) ) {
               /* buat cookie */
               setcookie('id', $row['id'], time()+60);
               setcookie('key', hash('sha256', $row['username']), time()+60);
            }

            header("Location: index.php");
            exit;
         }
      }

      $error = true;
   }
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Halaman Login</title>
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

         /* Styling Remember Me */
         .remember-container {
            display: flex;
            align-items: center;
            margin-top: 12px;
            cursor: pointer;
         }

         .remember-container input {
            display: none;
         }

         .remember-container label {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
         }

         .remember-container label::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            border: 2px solid #0072ff;
            border-radius: 4px;
            background-color: white;
            transition: all 0.3s ease;
         }

         .remember-container input:checked + label::before {
            background-color: #0072ff;
            border-color: #0072ff;
         }

         .remember-container label::after {
            content: "✔";
            position: absolute;
            left: 5px;
            top: -2px;
            font-size: 18px;
            color: white;
            opacity: 0;
            transition: all 0.3s ease;
         }

         .remember-container input:checked + label::after {
            opacity: 1;
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

         .error-message {
            color: red;
            text-align: center;
            font-style: italic;
            margin-bottom: 10px;
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
         <h1>Halaman Login</h1>

         <?php if(isset($error) ) : ?>
            <p class="error-message">Username/Password Salah</p>
         <?php endif; ?>

         <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autocomplete="off">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <div class="remember-container">
               <input type="checkbox" name="remember" id="remember">
               <label for="remember">Remember Me</label>
            </div>

            <button type="submit" name="login">Login</button>

            <p class="register-link">Belum punya akun? <a href="registrasi.php">Daftar di sini</a></p>
         </form>
      </div>
   </body>
</html>