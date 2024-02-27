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
        <title>Galery Foto</title>
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
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Album</h1>

                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                  Tambah Album
                                </button>
                                <br>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal dibuat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                include "koneksi.php";
                                                $userid=$_SESSION['userid'];
                                                $sql=mysqli_query($conn,"select * from album where userid='$userid'");
                                                while($data=mysqli_fetch_array($sql)){
                                                $id= 1;
                                                $albumid = $data['albumid'];
                                                $namaalbum = $data['namaalbum'];
                                                $deskripsi = $data['deskripsi'];
                                                $tanggaldibuat = $data['tanggaldibuat'];
                                            ?>



                                            <tr>
                                                <td><?=$id++;?></td>
                                                <td><?=$namaalbum;?></td>
                                                <td><?=$deskripsi;?></td>
                                                <td><?=$tanggaldibuat;?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$albumid;?>">
                                                    Edit</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$albumid;?>">
                                                    Delete</button>
                                                
                                                <!-- Edit  Modal -->
                                                <div class="modal fade" id="edit<?=$albumid;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Edit Album</h4>
                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                          <!-- Modal body -->

                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <label for="deskripsi">Nama Album:</label>
                                                                <br>
                                                                <input type="text" name="namaalbum" value="<?=$namaalbum?>" class="form-control" placeholder="Nama Album" required>
                                                                <br>
                                                                <label for="deskripsi">Deskripsi Album:</label>
                                                                <br>
                                                                <input type="text" name="deskripsi" value="<?=$deskripsi?>" class="form-control" required>
                                                                <input type="hidden" name="albumid" value="<?=$albumid;?>" class="form-control">
                                                                <br>                                                             
                                                                <button type="submit" class="btn btn-success" name="editbarangmasuk">Submit</button>
                                                            </div>
                                                        </form>

                                                            <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>


                                                <!-- Delete  Modal -->
                                                <div class="modal fade" id="delete<?=$albumid;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Hapus Album</h4>
                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                          <!-- Modal body -->

                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin Menghapus <?=$namaalbum?>
                                                                <br>
                                                                <br>
                                                                <input type="hidden" name="albumid" value="<?=$albumid;?>">
                                                                <button type="submit" class="btn btn-danger" name="hapusalbum">Hapus</button>
                                                            </div>
                                                        </form>

                                                            <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>

                                            <?php
                                                }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
          <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Tambah Foto</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    
                        <form method="post">
                            <div class="modal-body">
                                <input type="text" name="namaalbum" class="form-control" placeholder="Kategori Album" required>
                                <br>
                                <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi" required>
                                <br>
                                <button type="submit" class="btn btn-primary" name="addbarangmasuk">Submit</button>
                            </div>
                        </form>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</html>
