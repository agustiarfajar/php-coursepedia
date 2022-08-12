<?php 
include_once("functions.php");
session_start();
$db = dbConnect();
if($db->connect_errno==0)
{
    $id_materi = $db->escape_string($_POST["id_materi"]);
    $id_kategori = $db->escape_string($_POST["id_kategori"]);
    $id_mentor = $db->escape_string($_POST["id_mentor"]);
    $nama = $db->escape_string($_POST["nama"]);
    $deskripsi = $db->escape_string($_POST["deskripsi"]);
    $link = $db->escape_string($_POST["link"]);
    $id_kelas = $db->escape_string($_POST["id_kelas"]);

    $sql = "INSERT INTO materi(id_materi,id_kategori,id_mentor,nama,deskripsi,link,id_kelas)
    VALUES('$id_materi','$id_kategori','$id_mentor','$nama','$deskripsi','$link','$id_kelas')";
    $res = $db->query($sql);
    if($res)
    {
        if($db->affected_rows>0)
        {
            header("Location: mentor-materi.php?success=1");
        }
    }
    else
        return FALSE;
}
else
    echo "Gagal koneksi".(DEVELOPMENT?" : ".$db->connect_error:"")."<br>";
?>
