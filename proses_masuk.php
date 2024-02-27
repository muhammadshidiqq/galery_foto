<?php
    include "koneksi.php";
    session_start();

    $email=$_POST['email'];
    $password=$_POST['password'];
    

    $sql=mysqli_query($conn,"select * from user where email='$email' and password='$password'");

    $cek=mysqli_num_rows($sql);

    if($cek==1){
        while($data=mysqli_fetch_array($sql)){
            $_SESSION['userid']=$data['userid'];
            $_SESSION['namalengkap']=$data['namalengkap'];

        }
        header("location:index.php");
    }else{
        echo '<script>
                alert("Maaf Email atau Password anda salah..");
                window.location.href="masuk.php";
            </script>';
    }

    
?>