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
                width: 80px;
            }
            .zoom:hover{
                transform: scale(1.5);
                transition: 0.3s ease;
            }
        </style>
        <link rel="icon" href="logo.png" type="image">
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #3081D0;">
            <a class="navbar-brand" href="index.php" style="font-family: Comic Sans MS;"><?=$_SESSION['namalengkap']?></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark " id="sidenavAccordion" style="background-color:#3081D0 ;">
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
                        <h1 class="mt-4">Foto</h1>

                        <div class="card mb-4">
                            <div class="card-header">
                                  <!-- Button to Open the Modal -->
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Foto
                                  </button>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Deskripsi</th>
                                                <th>Tanggal Unggah</th>
                                                <th>Lokasi File</th>
                                                <th>Album</th>
                                                <th>Disukai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $userid=$_SESSION['userid'];
                                                $id = 1;
                                                $sql=mysqli_query($conn,"select * from foto,album where foto.userid='$userid' and foto.albumid=album.albumid");
                                                while($data= mysqli_fetch_array($sql)) {
                                                $JudulFoto = $data['judulfoto'];
                                                $deskripsi = $data['deskripsifoto'];
                                                $idbg = $data['fotoid'];
                                                $tgl = $data['tanggalunggah'];
                                                $album = $data['namaalbum'];
                                                $gambar = $data['lokasifile'];

                                                // cek ada gambar atau tidak
                                                $gambar = $data['lokasifile'];
                                                if($gambar==null){
                                                    // jika tidak ada gambar
                                                    $img = 'Tidak Ada Gambar';
                                                } else {
                                                    // jika ada gambar
                                                    $img = '<img src="gambar/'.$gambar.'" class="zoom">';
                                                }

                                            ?>

                                            <tr>
                                                <td><?=$id++;?></td>
                                                <td><?=$data['judulfoto']?></td>
                                                <td><?=$data['deskripsifoto']?></td>
                                                <td><?=$data['tanggalunggah']?></td>
                                                <td>
                                                    <?=$img;?>
                                                </td>
                                                <td><?=$album;?></td>
                                                <td>
                                                    <?php
                                                        $fotoid=$data['fotoid'];
                                                        $sql2=mysqli_query($conn,"select * from likefoto where fotoid='$fotoid'");
                                                        echo mysqli_num_rows($sql2);
                                                    ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idbg;?>">
                                                    Edit</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idbg;?>">
                                                    Delete</button>
                                                    
                                                <!-- Form Edit -->
                                                <div class="modal fade" id="edit<?=$idbg;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Edit</h4>
                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                          <!-- Modal body -->

                                                        <form method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <input type="text" name="JudulFoto" value="<?=$JudulFoto;?>" class="form-control" required>
                                                                <br>
                                                                <input type="text" name="deskripsi" value="<?=$deskripsi;?>" class="form-control" placeholder="Deskripsi Foto" required>
                                                                <br>
                                                                <input type="file" name="file" class="form-control">
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idbg;?>">
                                                                <button type="submit" class="btn btn-success" name="editfoto">Submit</button>
                                                            </div>
                                                        </form>


                                                            <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Penutup Edit -->
                                                </td>


                                                <!-- Delete  Modal -->
                                                <div class="modal fade" id="delete<?=$idbg;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Hapus Foto</h4>
                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                          <!-- Modal body -->

                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin Menghapus Foto <?=$JudulFoto;?> ?
                                                                <br>
                                                                <br>
                                                                <input type="hidden" name="idb" value="<?=$idbg;?>">
                                                                <button type="submit" class="btn btn-danger" name="hapusfoto">Hapus</button>
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
                    
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <label for="pilihan">Pilih Album</label>
                            <select name="albumid" class="form-control">
                                <?php
                                $userid=$_SESSION['userid'];
                                $sql=mysqli_query($conn,"SELECT * FROM album WHERE userid='$userid'");
                                while($data=mysqli_fetch_array($sql)){                                    
                                ?>
                                <option value="<?=$data['albumid']?>"><?=$data['namaalbum']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <br>
                            <input type="text" name="JudulFoto" class="form-control" placeholder="Judul Foto" required>
                            <br>
                            <input type="text" name="DeskripsiFoto" class="form-control" placeholder="Deskripsi Foto" required>
                            <br>
                            <label for="file">Pilih Foto:</label><br>
                            <input type="file" id="file" name="file" class="form-control" required><br>
                            <button type="submit" class="btn btn-primary" name="tambahfoto">Submit</button>
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
