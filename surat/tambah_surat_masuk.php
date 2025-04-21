<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Tambah Surat Masuk'; 
    //variabel yang berfungsi mengatifkan sidebar
    $surat_masuk = 'surat_masuk';
    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '../_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';
    // menghubungkan file header dengan file tambah Pegawai
    $sub = "../";
    require_once "../_template/_header.php";
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url('surat/surat_masuk')?>">Data Surat Masuk</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah Surat Masuk</li>    
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_surat_masuk') ?>?add" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="tgl_srt" class="col-sm-3 col-form-label">Tanggal Surat</label>
                <div class="col-sm-9">
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
                <label for="alamat" class="col-sm-3 col-form-label">Alamat Surat</label>
                <div class="col-sm-9">
                    <textarea name="alamat" class="form-control" id="alamat" cols="10" rows="2" placeholder="Alamat Surat" required autocomplete="off"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="tgl_srt" class="col-sm-3 col-form-label">Tanggal Terima</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" value="<?= date('Y-m-d'); ?>" name="tgl_terima" id="tgl_terima" placeholder="Tanggal Terima" required autocomplete="off" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="perihal" class="col-sm-3 col-form-label">Perihal Surat</label>
                <div class="col-sm-9">
                    <textarea name="perihal" class="form-control" id="perihal" cols="10" rows="5" placeholder="Perihal Surat" required autocomplete="off"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="penerima" class="col-sm-3 col-form-label">Penerima</label>
                <div class="col-sm-9">
                <select class="form-control" name="penerima" id="penerima" required autocomplete="off" autofocus>
                    <option value="" disabled selected hidden>Pilih Pegawai</option>
                    <?php

                        $data_pegawai = query("SELECT * FROM pegawai ORDER BY nama_pegawai ASC");
                        $penerima = 'Tidak Ada';

                        foreach ($data_pegawai as $pegawai) : ?>
                            <option value="<?= $pegawai['nama_pegawai'] ?>">
                                <?= $pegawai['nama_pegawai'] . ' - ' . $pegawai['nip'] ?>
                            </option>
                    <?php endforeach; ?>
                </select>
                </div>
            </div>
        <!-- disini tanda tempat form -->
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-fw fa-save"></i> Simpan</button>
        <a href="<?= base_url('surat/surat_masuk') ?>" class="btn btn-warning"><i class="fas fa-fw fa-chevron-left"></i> Kembali</a>
    </div>
    </form>
</div>


<?php

    // menambahkan script khusus untuk halaman ini saja
    $addscript = '
        <script src="'.asset('../_assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'"></script>
        <script>
            $(".datepicker").datepicker()

            
        $(document).on("change", ".custom-file-input", function (event) {
            $(this).next(".custom-file-label").html(event.target.files[0].name);
            })    
        </script>
    ';
    // menghubungkan file footer dengan file tambah Pegawai
    require_once "../_template/_footer.php";
?>