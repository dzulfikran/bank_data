<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Tambah Akun'; 
    //variabel yang berfungsi mengatifkan sidebar
    $akun = 'akun';
    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';
    // menghubungkan file header dengan file tambah akun
    $sub = "../";
    require_once "../_template/_header.php";
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url('akun/akun') ?>">Data akun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_akun') ?>?add" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="username" id="username" placeholder="username" required autocomplete="off" autofocus>
                    <span class="text-info">* Default password : 12345678</span>
                </div>
            </div>
            <div class="form-group row">
                <label for="id_pegawai" class="col-sm-3 col-form-label">Pilih Pegawai</label>
                <div class="col-sm-9">
                <select class="form-control" name="id_pegawai" id="id_pegawai" required autocomplete="off" autofocus>
                    <?php
                        $data_pegawai = query("SELECT pegawai.* 
                                        FROM pegawai 
                                        LEFT JOIN user ON pegawai.id_pegawai = user.id_pegawai 
                                        WHERE user.id_pegawai IS NULL 
                                        ORDER BY pegawai.nama_pegawai ASC;
                                        ");

                        foreach ($data_pegawai as $pegawai) : ?>
                            <option value="<?= $pegawai['id_pegawai'] ?>" >
                                <?= $pegawai['nama_pegawai'] . ' - ' . $pegawai['nip']?>
                            </option>
                    <?php endforeach; ?>
                </select>
                
                </div>
            </div>
            <div class="form-group row">
                <label for="id_pegawai" class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-9">
                    <select class="form-control" name="role" id="role" required autocomplete="off" autofocus>
                        <option value="admin"> Admin </option>
                        <option value="user"> User </option>
                    </select>
                </div>
            </div>

        <!-- disini tanda tempat form -->
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-fw fa-save"></i> Simpan</button>
        <a href="<?= base_url('akun/akun') ?>" class="btn btn-warning"><i class="fas fa-fw fa-chevron-left"></i> Kembali</a>
    </div>
    </form>
</div>


<?php

    // menambahkan script khusus untuk halaman ini saja
    $addscript = '
        <script src="'.asset('_assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'"></script>
        <script>
            $(".datepicker").datepicker()

            
        $(document).on("change", ".custom-file-input", function (event) {
            $(this).next(".custom-file-label").html(event.target.files[0].name);
            })    
        </script>
    ';
    // menghubungkan file footer dengan file tambah akun
    require_once "../_template/_footer.php";
?>