<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Edit Data akun'; 
    //variabel yang berfungsi mengatifkan sidebar
    $akun = 'akun';
    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css';

    // menghubungkan file header dengan file edit_akun
    $sub = "../";
    require_once "../_template/_header.php";
    //simpan data id(nip) yang dikirim dari halaman akun ke dalam variabel nip
    $id_user = $_GET['id'];

    // paggil data akun berdasarkan nip untuk ditampilkan di form sebelum melakukan perubahan data
    $result = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id_user'");

    // hasil dari proses result akan disimpan ke variabel data
    $data = mysqli_fetch_assoc($result);
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= base_url('akun/akun') ?>">Data akun</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
  </ol>
</nav>

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="<?= base_url('_config/proses_akun') ?>?edit" enctype="multipart/form-data">
            <div class="form-group row">
                <input type="hidden" name="id_user" value="<?= $id_user ?>">
                <label for="username" class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="username" id="username" value="<?= $data['username'] ?>" placeholder="Username" required autocomplete="off">
                </div>
            </div>
            
            <?php
                // Ambil data user berdasarkan id_user
                $id_user = $_GET['id'] ?? ''; // Pastikan ID diambil dari URL
                $user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                $user_data = mysqli_fetch_assoc($user);

                // Pastikan role yang dipilih sesuai dengan yang ada di database
                $selected_admin = ($user_data['role'] == 'admin') ? 'selected' : '';
                $selected_user = ($user_data['role'] == 'user') ? 'selected' : '';
            ?>
            <div class="form-group row">
                <label for="role" class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-9">
                    <select class="form-control" name="role" id="role" required autocomplete="off">
                        <option value="admin" <?= $selected_admin ?>> Admin </option>
                        <option value="user" <?= $selected_user ?>> User </option>
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

    $addscript = '
        <script src="'.asset('_assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'"></script>
        <script>
            $(".datepicker").datepicker()

            
        $(document).on("change", ".custom-file-input", function (event) {
            $(this).next(".custom-file-label").html(event.target.files[0].name);
            })    
        </script>
    ';

    // menghubungkan file footer dengan file edit_akun
    require_once "../_template/_footer.php";
?>