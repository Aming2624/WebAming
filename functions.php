<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php 
    /* koneksi ke database */
    $conn = mysqli_connect("localhost", "root", "", "phpdasar");

    function query($query) {
      global $conn;
      $result = mysqli_query($conn, $query);
      $rows = [];
      while($row = mysqli_fetch_assoc($result) ) {
         $rows[] = $row;
      }
      return $rows;
    }

    
    function tambah($data) {
        global $conn;
         /* ambil data dari tiap' elemen dalam form */
         $nama = htmlspecialchars($data["nama"]);
         $nrp = htmlspecialchars($data["nrp"]);
         $jurusan = htmlspecialchars($data["jurusan"]);
         $email = htmlspecialchars($data["email"]);
         $gambar = upload();
         if(!$gambar) {
            return false;
         }

             /* query insert data */
      $query = "INSERT INTO mahasiswa 
                     VALUES
                ('', '$nama', '$nrp', '$jurusan', '$email', '$gambar')
                ";
      mysqli_query($conn, $query);

      return mysqli_affected_rows($conn);
    }


    function upload() {
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        /* cek apakah tidak ada gambar yang diupload */
        if( $error === 4) {
               echo '<script>
                          Swal.fire({icon: "warning",
                              title: "Oops...",
                              text: "Pilih Gambar Dahulu Yaaaa"});
                    </script>';
              return false;
        }

        /* cek apakah yang diupload adalah gambar */
        $ekstensiGambarValid = ['jpg','jpeg','png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
          echo '<script>
                      Swal.fire({icon: "warning",
                              title: "Oops...",
                              text: "Yang Anda Upload Bukan Gambar"});
                </script>';
          return false;
        }

        /* cek jika ukurannya terlalu besar */
        if($ukuranFile > 2000000) {
          echo '<script>
                    Swal.fire({icon: "warning",
                              title: "Oops...",
                              text: "Ukuran Gambar Terlalu Besar"});
                </script>';
          return false;
        }

        /* lolos pengecekan gambar siap diupload */
        /* generate nama gambar baru */
        $namaFileBaru = uniqid();
        $namaFileBaru .= '.';
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName,'image/' . $namaFileBaru);
        return $namaFileBaru;

    }


    function hapus($id) {
      global $conn;
      mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
      return mysqli_affected_rows($conn);
    }


    function ubah($data) {
      global $conn;
       /* ambil data dari tiap' elemen dalam form */
       $id = $data["id"];
       $nama = htmlspecialchars($data["nama"]);
       $nrp = htmlspecialchars($data["nrp"]);
       $jurusan = htmlspecialchars($data["jurusan"]);
       $email = htmlspecialchars($data["email"]);
       $GambarLama = htmlspecialchars($data["GambarLama"]);
       /* cek apakah user memilih gambar baru atau tidak */
       if($_FILES['gambar']['error'] === 4) {
            $gambar = $GambarLama;
       } else {
            $gambar = upload();
       }
    
           /* query insert data */
    $query = "UPDATE mahasiswa SET
                nama = '$nama',
                nrp = '$nrp',
                jurusan = '$jurusan',
                email = '$email',
                gambar = '$gambar'
                WHERE id = $id
              ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
    }


    function cari($keyword) {
      $query = "SELECT * FROM mahasiswa
                  WHERE 
                nama LIKE '%$keyword%' OR
                nrp LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%' OR
                email LIKE '%$keyword%' 
              ";
      return query($query);
    }


    function registrasi($data) {
        global $conn;
        
        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $password2 = mysqli_real_escape_string($conn, $data["password2"]);

        /* cek username sudah ada apa belum */
        $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
        if(mysqli_fetch_assoc($result) ) {
          echo '<script>
                     Swal.fire({icon: "warning",
                              title: "Oops...",
                              text: "Username Sudah Terdaftar!"});
                </script>';
          return false;

        }
        /* cek konfirmasi password */
        if( $password !== $password2) {
          echo '<script>
                    Swal.fire({icon: "warning",
                              title: "Oops...",
                              text: "Konfirmasi Password Tidak Sesuai!"});
                </script>';
          return false;
        }

            /* enkripsi password */
         $password = password_hash($password, PASSWORD_DEFAULT);

          /* tambahkan user baru ke database */
          mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
          return mysqli_affected_rows($conn);

    }


?>
    
    </body>
</html>