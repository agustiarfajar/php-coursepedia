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
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php 
      $jmlAnggota = countAnggota();
      $jmlKelas = countKelas();
      $jmlPaket = countPaket();
      $jmlMentor = countMentor();
    ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                  <?php echo $jmlAnggota["jml_anggota"] ?>
                </h3>

                <p>Anggota</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              <a href="admin-anggota.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>
                  <?php echo $jmlKelas["jml_kelas"] ?>
                </h3>

                <p>Kelas</p>
              </div>
              <div class="icon">
                <i class="fas fa-landmark"></i>
              </div>
              <a href="admin-kelas.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>
                <?php echo $jmlPaket["jml_paket"] ?>
                </h3>

                <p>Paket Belajar</p>
              </div>
              <div class="icon">
                <i class="fas fa-book"></i>
              </div>
              <a href="admin-paketbelajar.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>
                  <?php echo $jmlMentor["jml_mentor"] ?>
                </h3>

                <p>Mentor</p>
              </div>
              <div class="icon">
                <i class="fas fa-user"></i>
              </div>
              <a href="admin-mentor.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Anggota Coursepedia Baru Bergabung</h3>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Tanggal Bergabung</th>
                      <th>Pilihan Paket</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $db = dbConnect();
                    $i = 0;
                    if($db->connect_errno==0)
                    {
                        $sql = "SELECT a.id_anggota,a.tgl_pembayaran,b.nama as namaAnggota,c.nama as namaPaket
                                FROM tagihan as a 
                                INNER JOIN anggota as b ON a.id_anggota = b.id_anggota
                                INNER JOIN paket_belajar as C ON a.id_paket = c.id_paket
                                ORDER BY a.tgl_pembayaran DESC
                                LIMIT 5";
                        $res = $db->query($sql);
                        if($res)
                        {
                            $data = $res->fetch_all(MYSQLI_ASSOC);
                            foreach($data as $row)
                            {
                                ?>
                                <tr>
                                  <td><?php echo ++$i ?></td>
                                  <td><?php echo $row["id_anggota"] ?></td>
                                  <td><?php echo $row["namaAnggota"] ?></td>
                                  <td><?php echo $row["tgl_pembayaran"] ?></td>
                                  <td><?php echo $row["namaPaket"] ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a href="#" class="dropdown-item">Add new event</a>
                      <a href="#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<?php bottom_section() ?>
<?php script_section() ?>