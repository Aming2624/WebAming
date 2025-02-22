<?php 
  session_start();
   
    if( !isset($_SESSION["login"]) ) {
      header("location: login.php");
   exit;
   }

   require 'functions.php';
   
   $id = $_GET["id"];

   if( hapus($id) > 0) {
      echo "
               <script>
                     Swal.fire({
                     title: 'Berhasil!',
                     text: 'Data Berhasil Dihapus',
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
                     text: 'Data Gagal Dihapus',
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
?>