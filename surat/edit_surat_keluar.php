<?php
    // Variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Edit Data Surat Keluar';
    // Variabel yang berfungsi mengaktifkan sidebar
    $surat_keluar = 'surat_keluar';
    // Menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';

    // Menghubungkan file header dengan file edit_pegawai
    $sub = "../";
    require_once "../_template/_header.php";

    // Simpan data ID (id_surat) yang dikirim dari halaman sebelumnya ke dalam variabel
    $id_surat = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Pastikan ID surat valid
    if ($id_surat <= 0 ) {
        echo '<script>alert("ID Surat tidak valid!"); window.history.back();</script>';
        exit();
    }

    // Ambil data surat berdasarkan id_surat
    $query = "SELECT tanggal_surat, nomor_surat, alamat_tujuan, perihal, dokumen 
              FROM surat_keluar 
              WHERE id_surat = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_surat);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="<?= base_url('surat/surat_keluar') ?>">
            Data Surat Keluar
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_surat_keluar') ?>?edit" enctype="multipart/form-data">
            <input type="hidden" name="id_surat" value="<?= $id_surat ?>">

            <div class="form-group row">
                <label for="tgl_srt" class="col-sm-3 col-form-label">Tanggal Surat</label>
                <div class="col-sm-9">
                    <input type="date" class="form-control" name="tgl_surat" id="tgl_surat" 
                        value="<?= htmlspecialchars($data['tanggal_surat'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nmr_surat" class="col-sm-3 col-form-label">Nomor Surat</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="nmr_surat" id="nmr_surat" 
                        value="<?= htmlspecialchars($data['nomor_surat'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="alamat" class="col-sm-3 col-form-label">Alamat Tujuan</label>
                <div class="col-sm-9">
                    <textarea name="alamat" class="form-control" id="alamat" cols="10" rows="2" required><?= htmlspecialchars($data['alamat_tujuan'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-group row">
                <label for="perihal" class="col-sm-3 col-form-label">Perihal Surat</label>
                <div class="col-sm-9">
                    <textarea name="perihal" class="form-control" id="perihal" cols="10" rows="5" required><?= htmlspecialchars($data['perihal'] ?? '') ?></textarea>
                </div>
            </div>    
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right">
            <i class="fas fa-fw fa-save"></i> Simpan
        </button>
        <a href="<?= base_url('surat/surat_keluar') ?>" class="btn btn-warning">
            <i class="fas fa-fw fa-chevron-left"></i> Kembali
        </a>
    </div>
    </form>
</div>


<?php

    $addscript = '
        <script src="'.asset('_assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'"></script>
        <script>
            $(".datepicker").datepicker()

            
        $(document).on("change", ".custom-file-input", function (event) {
            $(this).next(".custom-file-label").html(event.target.files[0].name);
            })    
        </script>
    ';

    // menghubungkan file footer dengan file edit_pegawai
    require_once "../_template/_footer.php";
?>