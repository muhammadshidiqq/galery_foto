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

    <style>
        .formpw {
          display: block;
          width: 350px;
          height: calc(1.5em + 0.75rem + 2px);
          padding: 0.375rem 0.75rem;
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: 0.25rem;
          transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #3081D0;">
            <a class="navbar-brand" href="index.php" style="font-family: Comic Sans MS;">Galery Foto</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark " id="sidenavAccordion" style="background-color:#3081D0;">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-camera" aria-hidden="true"></i></div>
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
                        <br>
                        <div class="card mb-4">
                            <div class="card-header">
                                  <!-- Button to Open the Modal -->
                                  <h4>Kelola Akun</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Lengkap</th>
                                                <th>Email</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                           <?php
                                                $userid=$_SESSION['userid'];
                                                $sql=mysqli_query($conn,"select * from user where userid='$userid'");
                                                $id = 1;
                                                while($data=mysqli_fetch_array($sql)){
                                                $em = $data['email'];
                                                $iduser = $data['userid'];
                                                $pw = $data['password'];
                                                $nama= $data['namalengkap'];
                                                $al= $data['alamat'];

                                            ?>

                                            <tr>
                                                <td><?=$id++;?></td>
                                                <td><?=$nama;?></td>
                                                <td><?=$em;?></td>
                                                <td><?=$al;?></td>
                                                
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$iduser;?>">
                                                    Edit</button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$iduser;?>">
                                                    Delete</button>
                                                    
                                                <!-- Edit  Modal -->
                                                <div class="modal fade" id="edit<?=$iduser;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Edit Akun</h4>
                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                          <!-- Modal body -->

                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <input type="text" name="nama" value="<?=$nama;?>" class="form-control">
                                                                <br>
                                                                <input type="email" name="email" value="<?=$em;?>" class="form-control" placeholder="Email" readonly>
                                                                <br>
                                                                <input type="text" name="alamat" value="<?=$al;?>" class="form-control" placeholder="Alamat">
                                                                <br>
                                                                <div style="position: relative;">
                                                                    <input name="password"  type="password" id="password" class="form-control" placeholder="Password" value="<?=$pw;?>">
                                                                    <i onclick="togglePasswordVisibility()" id="visibilityIcon" class="fa fa-eye" aria-hidden="true" style="position: absolute; top: 50%; right: 20px; transform: translateY(-50%); cursor: pointer;"></i>
                                                                </div>
                                                                <br>
                                                                <input type="hidden" name="id" value="<?=$iduser;?>">
                                                                <button type="submit" class="btn btn-primary" name="updateadmin">Submit</button>
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
                                                <div class="modal fade" id="delete<?=$iduser;?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <!-- Modal Header -->
                                                            <div class="modal-header">
                                                              <h4 class="modal-title">Hapus Barang</h4>
                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>

                                                          <!-- Modal body -->

                                                        <form method="post">
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin Menghapus <?=$em;?>
                                                                <input type="hidden" name="id" value="<?=$iduser;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="hapusadmin">Hapus</button>
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
                      <h4 class="modal-title">Tambah Akses</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    
                        <form method="post">
                            <div class="modal-body">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                            <br>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                            <br>
                            <button type="submit" class="btn btn-primary" name="tambahadmin">Submit</button>
                            </div>
                        </form>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
        </script>
</html>
