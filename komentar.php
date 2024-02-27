<?php
    require 'fitur.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Gallery Foto</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/92db931961.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="fontawesome/css/all.min.css" />
    <style type="text/css">
        .zoom {
            width: 100px;
        }
        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #3081D0;">
        <a class="navbar-brand" href="index.php" style="font-family: Comic Sans MS;">
            <?=$_SESSION['namalengkap']?>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color:#3081D0;">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-home" aria-hidden="true"></i></div>
                            Home
                        </a>                            
                        <a class="nav-link" href="album.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-camera" aria-hidden="true"></i></div>
                            Album
                        </a>
                        <a class="nav-link" href="foto.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-file-image" aria-hidden="true"></i></div>
                            Foto
                        </a>
                        <a class="nav-link" href="kelolaakun.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                            Kelola Akun
                        </a>                            
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-sign-out-alt" aria-hidden="true"></i></div>
                            Keluar
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <div class="container mt-4">
                <div class="row justify-content-center">
                    <?php
                        // Ambil ID foto dari URL jika tersedia
                        $fotoid = isset($_GET['fotoid']) ? $_GET['fotoid'] : null;
                        if ($fotoid) {
                            // Query untuk mendapatkan detail postingan berdasarkan ID foto
                            $query = "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid WHERE foto.fotoid = '$fotoid'";
                            $result = mysqli_query($conn, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $data = mysqli_fetch_assoc($result);
                                $namauser = $data['namalengkap'];
                                $deskripsifoto = $data['deskripsifoto'];
                                $gambar = $data['lokasifile'];
                    ?>
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center">Postingan</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-3">User : <?=$namauser;?></h6>
                                <img src="gambar/<?=$gambar;?>"  style="width: 100%; height: 300px;" alt="Gambar Postingan" class="img-fluid mb-3">
                                <h6 class="mb-3">Deskripsi Foto : <?=$deskripsifoto;?></h6>
                                <div>
                                    <a type="button" class="btn btn-danger me-2" href="like.php?fotoid=<?=$fotoid?>"><i class="fa fa-thumbs-up"></i>
                                        <?php
                                            $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                            echo mysqli_num_rows($sql2);
                                        ?>
                                    </a>
                                    <button type="button" class="btn btn-primary toggleComment" data-fotoid="<?=$fotoid?>"><i class="fa fa-comment"></i> Komentar</button>
                                </div>
                                <div class="mt-3 commentBox" id="commentBox<?=$fotoid?>" style="display: none;">
                                    <h6>Komentar</h6>
                                    <?php
                                        $tblkomentar = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE fotoid='$fotoid'");
                                        while($data_komentar = mysqli_fetch_array($tblkomentar)){
                                            $nama_komentar = $data_komentar['namalengkap'];
                                            $isi_komentar = $data_komentar['isikomentar'];
                                            $waktu_komentar = $data_komentar['tanggalkomentar'];
                                    ?>   
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6><?=$nama_komentar?></h6>
                                                    <p><?=$isi_komentar?></p>
                                                </div>
                                                <small><?=$waktu_komentar?></small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="mt-3">
                                        <form action="addkomentar.php" method="post">
                                        <div class="mb-3">
                                            <label for="commentInput<?=$fotoid?>" class="form-label">Tambah Komentar</label>
                                            <textarea class="form-control" name="isikomentar" id="commentInput<?=$fotoid?>" rows="3"></textarea>
                                        </div>
                                        <!-- Menambahkan input untuk fotoid dan userid -->
                                        <input type="hidden" name="fotoid" value="<?=$fotoid?>">
                                        <input type="hidden" name="userid" value="<?=$_SESSION['userid']?>">
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                            } else {
                                echo "<div class='col-md-8 mb-4'><div class='alert alert-danger text-center'>Data tidak ditemukan</div></div>";
                            }
                        } else {
                            echo "<div class='col-md-8 mb-4'><div class='alert alert-danger text-center'>ID foto tidak ditemukan</div></div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        // Fungsi untuk toggle display komentar
        document.querySelectorAll(".toggleComment").forEach(function(element) {
            element.addEventListener("click", function() {
                var fotoid = this.getAttribute("data-fotoid");
                var commentBox = document.getElementById("commentBox" + fotoid);
                if (commentBox.style.display === "none") {
                    commentBox.style.display = "block";
                } else {
                    commentBox.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>
