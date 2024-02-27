<?php
require 'cek_sesi.php';
require 'koneksi.php';
// Fitur Tambah Foto
if(isset($_POST['tambahfoto'])) {
    $JudulFoto = $_POST['JudulFoto'];
    $DeskripsiFoto = $_POST['DeskripsiFoto'];
    $userid = $_SESSION['userid'];

    // Soal gambar
    $formatfoto = array('png', 'jpg'); // Ekstensi foto yang diperbolehkan
    $nama = $_FILES['file']['name']; // Nama file gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot)); // Ekstensi file gambar
    $ukuran = $_FILES['file']['size']; // Ukuran file gambar
    $file_tmp = $_FILES['file']['tmp_name']; // Lokasi file sementara gambar

    // Penamaan file dengan enkripsi
    $LokasiFile = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; // Gabungan hasil enkripsi dengan ekstensi file
    
    // Mendapatkan albumid dari formulir
    $albumid = $_POST['albumid'];

    // Validasi apakah albumid sudah ada
    $cek_album = mysqli_query($conn, "SELECT * FROM album WHERE albumid='$albumid'");
    $jumlah_album = mysqli_num_rows($cek_album);
    if ($jumlah_album > 0) {
        // Jika albumid valid, lanjutkan proses penyimpanan data foto
        
        // Validasi apakah judul foto sudah ada
        $cek_judul = mysqli_query($conn, "SELECT * FROM foto WHERE JudulFoto='$JudulFoto'");
        $jumlah_judul = mysqli_num_rows($cek_judul);
        
        if ($jumlah_judul < 1) {
            // Jika judul foto belum ada
            
            // Proses upload gambar
            if (in_array($ekstensi, $formatfoto)) {
                // Validasi ukuran file
                if ($ukuran < 15000000) {
                    // Pindahkan file ke direktori tujuan
                    if (move_uploaded_file($file_tmp, 'gambar/' . $LokasiFile)) {
                        // Masukkan data ke dalam database
                        $addtotable = mysqli_query($conn, "INSERT INTO foto (fotoid, judulfoto, deskripsifoto, lokasifile, albumid, userid) VALUES (NULL, '$JudulFoto', '$DeskripsiFoto', '$LokasiFile', '$albumid', '$userid')");
                        if ($addtotable) {
                            // Jika data berhasil dimasukkan, redirect ke halaman foto
                            header('location:foto.php');
                        } else {
                            // Jika gagal memasukkan data ke dalam database
                            echo '<script>alert("Gagal memasukkan data ke dalam database"); window.location.href="foto.php";</script>';
                        }
                    } else {
                        // Jika gagal memindahkan file ke direktori tujuan
                        echo '<script>alert("Gagal mengunggah file"); window.location.href="foto.php";</script>';
                    }
                } else {
                    // Jika ukuran file terlalu besar
                    echo '<script>alert("Ukuran file terlalu besar"); window.location.href="foto.php";</script>';
                }
            } else {
                // Jika ekstensi file tidak didukung
                echo '<script>alert("File harus berupa PNG atau JPG"); window.location.href="foto.php";</script>';
            }
        } else {
            // Jika judul foto sudah ada
            echo '<script>alert("Judul foto sudah terdaftar"); window.location.href="foto.php";</script>';
        }
    } else {
        // Jika albumid tidak valid
        echo '<script>alert("Album tidak valid"); window.location.href="foto.php";</script>';
    }
}

		

	// Fitur Tambah Album
	if(isset($_POST['addbarangmasuk'])) {
	    $namaalbum=$_POST['namaalbum'];
	    $deskripsi=$_POST['deskripsi'];
	    $tanggaldibuat=date("Y-m-d");
	    $userid=$_SESSION['userid'];

	    $addtomasuk = mysqli_query($conn,"insert into album values('','$namaalbum','$deskripsi','$tanggaldibuat','$userid')");
	    if($addtomasuk) {
	        header('location:album.php');
	    } else {
	        echo "Gagal";
	        header('location:album.php');
	    }
	}

		// Fitur Edit Foto
		if(isset($_POST['editfoto'])) {
		    $idb = $_POST['idb'];
		    $JudulFoto = $_POST['JudulFoto'];
		    $deskripsi = $_POST['deskripsi'];

		    // Validasi pengiriman file
		    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
		        // Proses upload file gambar
		        $formatfoto = array('png', 'jpg');
		        $nama = $_FILES['file']['name'];
		        $dot = explode('.',$nama);
		        $ekstensi = strtolower(end($dot));
		        $ukuran = $_FILES['file']['size'];
		        $file_tmp = $_FILES['file']['tmp_name'];
		        $LokasiFile = md5(uniqid($nama,true) . time()).'.'.$ekstensi;

		        if(in_array($ekstensi, $formatfoto)) {
		            if($ukuran < 15000000) {
		                // Pindahkan file ke direktori tujuan
		                if(move_uploaded_file($file_tmp, 'gambar/'.$LokasiFile)) {
		                    // Perbarui data foto dengan lokasi file yang baru
		                    $edit = mysqli_query($conn, "UPDATE foto SET JudulFoto='$JudulFoto', DeskripsiFoto='$deskripsi', LokasiFile='$LokasiFile' WHERE FotoID='$idb'");
		                    if($edit) {
		                        header('location:foto.php');
		                    } else {
		                        echo "Gagal";
		                        header('location:foto.php');
		                    }
		                } else {
		                    echo "Gagal mengunggah file";
		                }
		            } else {
		                echo "Ukuran file terlalu besar";
		            }
		        } else {
		            echo "Format file harus PNG atau JPG";
		        }
		    } else {
		        // Jika pengguna tidak mengunggah file baru, hanya perbarui judul dan deskripsi foto
		        $edit = mysqli_query($conn, "UPDATE foto SET JudulFoto='$JudulFoto', DeskripsiFoto='$deskripsi' WHERE FotoID='$idb'");
		        if($edit) {
		            header('location:foto.php');
		        } else {
		            echo "Gagal";
		            header('location:foto.php');
		        }
		    }
		}


		// Fitur Delete Foto
		if(isset($_POST['hapusfoto'])) {
		    // Ambil ID foto dari formulir POST
		    $idb = $_POST['idb'];

		    // Query database untuk mendapatkan lokasi file gambar
		    $query = mysqli_query($conn, "SELECT lokasiFile FROM foto WHERE fotoid='$idb'");
		    $data = mysqli_fetch_assoc($query);

		    // Pastikan lokasi file ditemukan sebelum mencoba menghapusnya
		    if($data && isset($data['lokasiFile'])) {
		        $lokasiFile = 'gambar/' . $data['lokasiFile'];

		        // Hapus file gambar dari folder 'gambar'
		        if(file_exists($lokasiFile) && unlink($lokasiFile)) {
		            // Jika file berhasil dihapus, hapus entri dari database
		            $hapus = mysqli_query($conn, "DELETE FROM foto WHERE fotoid='$idb'");
		            if($hapus) {
		                header('location:foto.php');
		                exit(); // Keluar dari skrip setelah mengarahkan pengguna
		            } else {
		                echo "Gagal menghapus entri dari database";
		            }
		        } else {
		            echo "Gagal menghapus file gambar";
		        }
		    } else {
		        echo "Data foto tidak ditemukan";
		    }
		}

		// Fitur Edit Album
		if (isset($_POST['editbarangmasuk'])) {
		    $albumid=$_POST['albumid'];
		    $namaalbum=$_POST['namaalbum'];
		    $deskripsi=$_POST['deskripsi'];

		    $edit = mysqli_query($conn,"update album set namaalbum='$namaalbum',deskripsi='$deskripsi' where albumid='$albumid'");

		    if ($edit) {
		        header('location: album.php');
		    } else {
		        echo "Gagal: " . mysqli_error($conn);
		    }
		}

			

		// Fitur Delete Albun
		if(isset($_POST['hapusalbum'])) {
			$albumid = $_POST['albumid'];
			
			$hapusdata = mysqli_query($conn,"delete from album where albumid='$albumid'");
			if($hapusdata) {
				     echo '<script>
				        alert("Berhasil..");
				        window.location.href="album.php";
				    </script>';
			} else {
				echo '<script>
				        alert("gagal..");
				        window.location.href="album.php";
				    </script>';
			}

		}
		//Menambah Admin Baru
		if(isset($_POST['tambahadmin'])){
			$email = $_POST['email'];
			$password = $_POST['password'];

			$queryinsert = mysqli_query($conn,"insert into login (email, password) values ('$email', '$password')");

			if($queryinsert){
				// if berhasil
				header('location:admin.php');

			} else {
				//kalau gagal insert ke db
				header('location:admin.php');

			}
		}

		//Edit data admin
		if(isset($_POST['updateadmin'])){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
			$idnya = $_POST['id'];

			$queryupdate = mysqli_query($conn,"update user set namalengkap='$nama', alamat='$alamat', email='$email', password='$password' where userid='$idnya'");

			if($queryupdate){
				header('location:kelolaakun.php');

			} else {
				echo "Gagal";
				header('location:kelolaakun.php');

			}

		}

		//hapus admin
		if(isset($_POST['hapusadmin'])){
			$id = $_POST['id'];

			$querydelete = mysqli_query($conn,"delete from user where UserID='$id'");

			if($querydelete){
				header('location:admin.php');

			} else {
				header('location:admin.php');

			}
		}

		// Fitur Edit Komentar
		if(isset($_POST['editkomentar'])) {
		    $edit_komentar = $_POST['edit_komentar'];
		    $idkomentar = $_POST['idkomentar']; // ID komentar yang akan diedit

		    // Buat kueri SQL untuk memperbarui komentar yang ada di database
		    $query = "UPDATE komentarfoto SET isikomentar = '$edit_komentar' WHERE komentarid = '$idkomentar'";
		    $result = mysqli_query($conn, $query);

		    // Periksa apakah kueri berhasil dieksekusi
		    if ($result) {
		        // Redirect ke halaman yang sesuai atau tampilkan pesan berhasil
		        header("Location: index.php"); // Ganti foto.php dengan halaman yang sesuai
		        exit();
		    } else {
		        // Tampilkan pesan error jika kueri gagal dieksekusi
		        echo "Error: " . mysqli_error($conn);
		    }
		}		
		// Fitur Delete Komentar
		if(isset($_POST['deletekomentar'])) {
	    // Ambil ID komentar yang akan dihapus
	    $idkomentar = $_POST['idkomentar'];

	    // Buat kueri SQL untuk menghapus komentar dari tabel komentarfoto
	    $query = "DELETE FROM komentarfoto WHERE komentarid = '$idkomentar'";
	    $result = mysqli_query($conn, $query);

	    // Periksa apakah kueri berhasil dieksekusi
	    if ($result) {
	        // Redirect ke halaman yang sesuai atau tampilkan pesan berhasil
	        header("Location: index.php"); // Ganti foto.php dengan halaman yang sesuai
	        exit();
	    } else {
	        // Tampilkan pesan error jika kueri gagal dieksekusi
	        echo "Error: " . mysqli_error($conn);
	    }
	}

		// tambah admin
		if(isset($_POST['tambahadmin'])) {
			$email = $_POST['email'];
			$password = $_POST['password'];

			$queryinsert = mysqli_query($conn,"INSERT INTO login (email,password) values ('$email', '$password')");
			
			if($queryinsert){
				header('location:admin.php');

			} else {
				header('location:admin.php');

			}
		
		}
?>
