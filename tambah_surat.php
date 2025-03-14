<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Tambah Surat'; 
    //variabel yang berfungsi mengatifkan sidebar
    $surat = 'surat';
    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';

    $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : '';
    // menghubungkan file header dengan file tambah Pegawai
    require_once "_template/_header.php";
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php if ($jenis == 'masuk') : ?>
        <li class="breadcrumb-item"><a href="<?= base_url('surat') ?>?jenis=masuk">Data Surat Masuk</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Surat Masuk</li>
    <?php else : ?>
        <li class="breadcrumb-item"><a href="<?= base_url('surat') ?>?jenis=keluar">Data Surat Keluar</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Surat Keluar</li>
    <?php endif; ?>
    
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_surat') ?>?add" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="tgl_srt" class="col-sm-3 col-form-label">Tanggal Surat</label>
                <div class="col-sm-9">
                    <input type="hidden" name="jenis" value="<?= $jenis ?>">
                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>" name="tgl_surat" id="tgl_surat" placeholder="Tanggal Surat" required autocomplete="off" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="nmr_surat" class="col-sm-3 col-form-label">Nomor Surat</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nmr_surat" id="nmr_surat" placeholder="Nomor Surat" required autocomplete="off">
                </div>
            </div>
            <div class="form-group row">
                <label for="deskripsi" class="col-sm-3 col-form-label">Deskripsi Surat</label>
                <div class="col-sm-9">
                    <textarea name="deskripsi" class="form-control" id="deskripsi" cols="10" rows="5" placeholder="Deskripsi Surat" required autocomplete="off"></textarea>
                </div>
            </div>
        <!-- disini tanda tempat form -->
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-fw fa-save"></i> Simpan</button>
        <a href="<?= base_url('pegawai') ?>" class="btn btn-warning"><i class="fas fa-fw fa-chevron-left"></i> Kembali</a>
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
    // menghubungkan file footer dengan file tambah Pegawai
    require_once "_template/_footer.php";
?>