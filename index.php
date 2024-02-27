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
        .sizeimg {
            width: 100%;
            height: 300px;
        }
        p {
            font-size: 18px;
            font-family: georgia;
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
                    // Query untuk mengambil data foto beserta informasi user
                    $sql = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.userid=user.userid");
                    while($data = mysqli_fetch_array($sql)) {
                        $fotoid = $data['fotoid'];
                        $namafoto = $data['namalengkap'];
                        $deskripsi = $data['deskripsifoto'];
                        $gambar = $data['lokasifile'];
                    ?>
                    <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center">Postingan</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-3">User: <?=$namafoto;?></h6>
                                <img class="sizeimg" src="gambar/<?=$gambar;?>" alt="Gambar Postingan" >
                                <br><br>
                                <h6 class="mb-3">Deskripsi Foto: <?=$deskripsi;?></h6>
                                <div>
                                    <!-- Tombol Like Menggunakan Link  -->
                                    <a type="button" class="btn btn-danger me-2" href="like.php?fotoid=<?=$fotoid?>"><i class="fa fa-thumbs-up"></i>
                                        <!-- Menampilkan Jumlah Like -->
                                        <?php
                                        $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$fotoid'");
                                        echo mysqli_num_rows($sql2);
                                        ?>
                                    </a>
                                    <button type="button" class="btn btn-primary toggleComment"><i class="fa fa-comment"></i> Komentar</button>
                                </div>
                                <div class="mt-3" id="commentBox" style="display: none;">
                                    <h6>Komentar</h6>
                                    <!-- Menampilkan Komentar -->
                                    <?php
                                    $tblkomentar = mysqli_query($conn, "SELECT * FROM komentarfoto INNER JOIN user ON komentarfoto.userid=user.userid WHERE fotoid='$fotoid'");
                                    while($data_komentar = mysqli_fetch_array($tblkomentar)){
                                        $nama_komentar = $data_komentar['namalengkap'];
                                        $idkomentar = $data_komentar['komentarid'];
                                        $isi_komentar = $data_komentar['isikomentar'];
                                        $waktu_komentar = $data_komentar['tanggalkomentar'];
                                        // Periksa apakah pengguna yang sedang login adalah pemilik komentar
                                        $isOwner = ($_SESSION['userid'] == $data_komentar['userid']);
                                    ?>   
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6><?=$nama_komentar?></h6>
                                                    <p><?=$isi_komentar?></p>
                                                </div>
                                                <!-- Tampilkan tombol edit dan delete jika pengguna adalah pemilik komentar -->
                                                <?php if($isOwner): ?>
                                                <div class="ml-auto">
                                                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#edit<?=$data_komentar['komentarid'];?>">Edit</button>
                                                    <button data-toggle="modal" data-target="#delete<?=$data_komentar['komentarid']?>" class="btn btn-sm btn-danger">Delete</buttton>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <small style="margin-left: 550px;"><?=$waktu_komentar?></small>
                                        </div>
                                    </div>
                                    <!-- Form Edit -->
                                    <div class="modal fade" id="edit<?=$data_komentar['komentarid'];?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Komentar</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->

                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <textarea class="form-control" name="edit_komentar" rows="3"><?=$isi_komentar;?></textarea>
                                                        <br><br>
                                                        <input type="hidden" name="idkomentar" value="<?=$idkomentar;?>">
                                                        <button type="submit" class="btn btn-success" name="editkomentar">Submit</button>
                                                    </div>
                                                </form>


                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Penutup Edit -->                    
                                    </div>
                                    <!-- Form Delete -->
                                    <div class="modal fade" id="delete<?=$data_komentar['komentarid'];?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Komentar</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->

                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin Menghapus Komentar Ini
                                                        <br>
                                                        <br>
                                                        <input type="hidden" name="idkomentar" value="<?=$idkomentar;?>">
                                                        <button type="submit" class="btn btn-danger" name="deletekomentar">Submit</button>
                                                    </div>
                                                </form>


                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Penutup Edit -->                    
                                    </div>
                                    <?php } ?>
                                    <div class="mt-3">
                                        <!-- Tombol Tambah Komentar -->
                                        <a href="komentar.php?fotoid=<?=$fotoid?>" class="btn btn-primary">Tambah Komentar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
                var commentBox = this.parentNode.nextElementSibling;
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
