<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <script
        src="https://kit.fontawesome.com/64d58efce2.js"
        crossorigin="anonymous"
      ></script>
      <link rel="stylesheet" href="css/stylelogin.css" />
      <title>MASUK || GALERY FOTO</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="proses_masuk.php" method="post" class="sign-in-form">
            <h2 class="title">MASUK</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="email" placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" />
              <br>
              <p>
              Belum Punya Akun..? <a style="text-decoration: none; font-weight: bold; color: black;" href="daftar.php">Daftar</a></p>
            </div>
            <br>
            <button class="btn solid" name="Login">Login</button>
            </div>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>GALERY FOTO</h3>
            <p>
              Galery Foto adalah sebuah web yang berguna untuk pengelolaan foto kenangan yang pernah ada.
            </p>
            <img src="gambar/logo foto.png" class="image" alt="" />
          </div>
        </div>
      </div>
    </div>

    <script src="js/app.js"></script>
  </body>
</html>