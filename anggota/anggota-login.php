<?php 
include_once("functions.php");
session_start();
if(!isset($_SESSION["id_anggota"])){
    header("Location: login.php?error=proses");
}
?>
<?php 
$db = dbConnect();
if($db->connect_errno==0)
{
    if(isset($_POST["btnLogin"]))
    {
        $username = $db->escape_string($_POST["username"]);
        $password = $db->escape_string($_POST["pass"]);
        $sql = "SELECT * FROM anggota WHERE username='$username' AND pass=PASSWORD('$password')";
        $res = $db->query($sql);
        if($res)
        {
            if($res->num_rows==1)
            {
                $data=$res->fetch_assoc();
                session_start();
                $_SESSION["id_anggota"]=$data["id_anggota"];
                $_SESSION["nama"]=$data["nama"];
                $_SESSION["jk"]=$data["jk"];
                $_SESSION["alamat"]=$data["alamat"];
                $_SESSION["no_telp"]=$data["no_telp"];
                $_SESSION["id_paket"]=$data["id_paket"];
                $_SESSION["email"]=$data["email"];
                $_SESSION["username"]=$data["username"];
                $_SESSION["password"]=$data["password"];
                header("Location: index-anggota.php");
            }
            else 
                header("Location: login.php?error=input");
        }
    }
    else 
        header("Location: login.php?error=login");
}
else 
    header("Location: login.php?error=koneksi");
?>