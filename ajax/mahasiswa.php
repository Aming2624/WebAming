<?php
usleep(500000);
   require '../functions.php';

   $keyword = $_GET["keyword"];

   $query = "SELECT * FROM mahasiswa
                  WHERE 
                nama LIKE '%$keyword%' OR
                nrp LIKE '%$keyword%' OR
                jurusan LIKE '%$keyword%' OR
                email LIKE '%$keyword%' 
              ";
   $mahasiswa = query($query);
?>
<table>
            <tr>
                <th>No.</th>
                <th>Nrp</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>

            <?php $i = 1; ?>
            <?php foreach ($mahasiswa as $row) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row["nrp"]; ?></td>
                    <td><img src="image/<?= $row["gambar"]; ?>" width="70"></td>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["email"]; ?></td>
                    <td><?= $row["jurusan"]; ?></td>
                    <td class="aksi">
                        <a href="ubah.php?id=<?= $row["id"]; ?>" class="ubah">Ubah</a>
                        <a href="hapus.php?id=<?= $row["id"]; ?>" class="hapus" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>