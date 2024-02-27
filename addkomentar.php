<?php
    require 'fitur.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari formulir
        $fotoid = $_POST['fotoid'];
        $userid = $_POST['userid'];
        $isikomentar = $_POST['isikomentar'];
        $tanggalkomentar = date("Y-m-d");

        // Query untuk memasukkan komentar ke dalam tabel komentarfoto
        $query = "INSERT INTO komentarfoto (fotoid, userid, isikomentar, tanggalkomentar) VALUES ('$fotoid', '$userid', '$isikomentar', '$tanggalkomentar')";
        
        // Jalankan query
        if (mysqli_query($conn, $query)) {
            // Jika berhasil, kembalikan ke halaman komentar untuk foto yang sesuai
            header("Location: index.php?fotoid=".$fotoid);
            exit;
        } else {
            // Jika terjadi kesalahan, tampilkan pesan kesalahan
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        // Jika bukan metode POST, kembalikan ke halaman sebelumnya atau tindakan yang sesuai
        header("Location: index.php");
        exit;
    }
?>