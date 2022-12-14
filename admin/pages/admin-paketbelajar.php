<?php 
session_start();
if(!isset($_SESSION["id_admin"]))
{
    header("Location: ../index.php?error=4");
}
include_once("functions.php");
include_once("layout.php");
?>
<?php style_section() ?>
<?php top_section() ?>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Paket Belajar</h1>
          </div><!-- /.col -->   
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin-dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Paket</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <?php 
        if(isset($_GET["success"]))
        {
            $success = $_GET["success"];
            if($success == 1)
              showSuccess("Data berhasil disimpan.");
            else if($success == 2)
              showSuccess("Data berhasil diubah.");
            else if($success == 3)
              showSuccess("Data berhasil dihapus.");
        }

        if(isset($_GET["warning"]))
        {
            $wrn = $_GET["warning"];
            if($wrn == "perubahan")
                showWarning("Tidak ada perubahan data.");                       
        }

        if(isset($_GET["error"]))
        {
            $Error = $_GET["error"];
            if($Error == "id")
              showError("ID Paket sudah ada.");
            else if($Error == "input")
              showError("Kesalahan format masukan :<br> ".$_SESSION["salahinputpaket"]);
            else if($Error == "proses")
              showError("Terjadi kesalahan, silahkan melakukan proses dengan benar");
            else if($Error == "fk")
              showError("Terjadi kesalahan ".$_SESSION["fk"]);
        }
      ?>
    <button type="button" class="btn btn-app" data-toggle="modal" data-target="#modal-lg">
        <i class="fas fa-plus"></i> Tambah
      </button>
      
      <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
        <form action="admin-paketbelajar-simpan.php" method="post">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data Paket Belajar</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">  
                <div class="card-body">
                  <div class="form-group">
                    <label for="id_paket">Kode Paket</label>
                    <input type="text" class="form-control" id="id_paket" maxlength="8" name="id_paket" value="<?php echo kodeOtomatisPaket() ?>" autocomplete="off" readonly>
                  </div>
                  <div class="form-group">
                    <label for="id_kelas">Kelas</label>
                    <select class="form-control" name="id_kelas" id="id_kelas">
                      <option value="">Pilih Kelas</option>
                      <?php 
                        $db = dbConnect();
                        if($db->connect_errno==0)
                        {
                            $sql = "SELECT * FROM kelas";
                            $res = $db->query($sql);
                            if($res)
                            {
                                $data = $res->fetch_all(MYSQLI_ASSOC);
                                foreach($data as $row)
                                {
                                  echo "<option value='".$row["id_kelas"]."'>".$row["nama"]."</option>";
                                }
                                $res->free();
                            }
                        }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="nama">Nama Paket</label>
                    <input type="text" class="form-control" id="nama" maxlength="50" name="nama" placeholder="Masukan Nama Paket" autocomplete="off">
                  </div>    
                  <div class="form-group">
                    <label for="harga">Harga Paket</label>
                    <input type="text" class="form-control" id="harga" maxlength="50" name="harga" placeholder="Masukan Harga Paket" autocomplete="off">
                  </div>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="button" onclick="konfirmasiSimpan()" name="btnSimpan" class="btn btn-primary" style="float:right">Simpan</button>
                </div>
                <!-- /.card-body -->
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Paket</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                  <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                    <thead>
                    <tr>
                      <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">ID Paket</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Nama Paket</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Kelas</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Harga</th>
                      <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>  
                      <?php 
                      $db = dbConnect();
                      if($db->connect_errno==0)
                      {
                          $sql = "SELECT a.*,b.nama as kelas FROM 
                          paket_belajar as a INNER JOIN kelas as b ON a.id_kelas=b.id_kelas";
                          $res = $db->query($sql);
                          if($res)
                          {
                              $data_paket = $res->fetch_all(MYSQLI_ASSOC);
                              foreach($data_paket as $row)
                              {
                                echo "<tr>
                                  <td class='dtr-control sorting_1' tabindex='0'>".$row['id_paket']."</td>
                                  <td>".$row['nama']."</td>
                                  <td>".$row['kelas']."</td>
                                  <td>".number_format($row['harga'],0,',','.')."</td>
                                  <td>
                                      <a href='admin-paketbelajar-form-edit.php?id_paket=".$row['id_paket']."' class='btn btn-sm btn-info'><i class='fas fa-edit'></i></a> | 
                                      <a href='admin-paketbelajar-form-hapus.php?id_paket=".$row['id_paket']."' class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>
                                  </td>
                              </tr>";
                              }
                              $res->free();
                          }
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php bottom_section() ?>
<?php script_section() ?>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
    // Sweetalert
    function konfirmasiSimpan()
    {
        event.preventDefault();
        var form = event.target.form;
        Swal.fire({
            icon: "question",
            title: "Konfirmasi",
            text: "Apakah anda yakin ingin menyimpan data?",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal"
        }).then((result) => {
            if(result.value) {
                form.submit();
            } else {
                Swal.fire("Informasi","Data batal disimpan.","error");
            }
        });
    }
</script>