/* DIBAWAH INI ADALAH SCRIPT MEGGUNAKANN SINTAKS JS SEBELUM MENGGUNAKAN JQUERY*/
   /* ambil elemen' yang dibtuhkan */
      /* var keyword = document.getElementById('keyword');
      var tombolCari = document.getElementById('tombol-cari');
      var container = document.getElementById('container'); */

   /* tambahkan event ketika keyword ditulis */
      /* keyword.addEventListener('keyup', function() { */

         /* buat object ajax */
            /* var xhr = new XMLHttpRequest(); */

         /* cek kesiapan ajax */
            /*   xhr.onreadystatechange = function() {
                  if( xhr.readyState == 4 && xhr.status == 200 ) {
                     container.innerHTML = xhr.responseText;
                  }
               } */

         /* eksekusi ajax */
            /* xhr.open('GET', 'ajax/mahasiswa.php?keyword=' + keyword.value, true);
            xhr.send();
      }); */

      $(document).ready(function() {
         /* hilanngkan tombol cari */
            $('#tombolcari').hide();
         /* event keyika keyword ditulis */
            $('#keyword').on('change', function() {
               /* munculkan icon loading */
               //$('.loader').show();

               Swal.fire({title: 'Mencari data...',text: 'Mohon tunggu.', allowOutsideClick: false, didOpen: () => {Swal.showLoading();}});
               /* ajax menggunakan load */
               /* $('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val()); */

               /* $.get() */
               $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data) {
                  $('#container').html(data);
                  //$('.loader').hide();
                  Swal.close();
               });
            });
      }); 