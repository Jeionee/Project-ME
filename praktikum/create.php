<form action="create.php" method="POST">
    NPM: <input type="text" name="npm"><br>
    Nama: <input type="text" name="nama"><br>
    Jurusan: <input type="text" name="jurusan"><br>
    <input type="submit" name="submit" value="Tambah Data">
    <input type="submit" name="update" value="Edit Data">
    <input type="submit" name="delete" value="Hapus Data">
</form>


<?php
include 'koneksi.php';
if(isset($_POST['submit'])){
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    $query = "INSERT INTO mahasiswa (npm, nama, jurusan) VALUES ('$npm','$nama', '$jurusan')";
    mysqli_query($koneksi, $query);
    echo "Data berhasil ditambahkan.";
}

if(isset($_POST['update'])){
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];

    $query = "UPDATE mahasiswa SET nama = '$nama', jurusan = '$jurusan' WHERE npm = '$npm'";
    $result = mysqli_query($koneksi, $query);
    
    if($result) {
        echo "Data berhasil diubah.";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

if(isset($_POST['delete'])){
    $npm = $_POST['npm'];
    
    $query = "DELETE FROM mahasiswa WHERE npm = '$npm'";
    $result = mysqli_query($koneksi, $query);
    
    if($result) {
        echo "Data berhasil dihapus.";
    } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
?>