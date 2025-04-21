<?php
    //variabel yang berfungsi menyimpan detail dari sub judul website
    $nama = 'Data akun'; 

    //variabel yang berfungsi mengatifkan sidebar
    $akun = 'akun';

    // menambahkan style khusus untuk halaman ini saja
    $addstyles = '_assets/vendor/datatables/dataTables.bootstrap4.min.css';

    // menghubungkan file header dengan file akun
    $sub = "../";
    require_once "../_template/_header.php";
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">Data akun</li>
    </ol>
</nav>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="<?= base_url('akun/tambah_akun') ?>" class="btn btn-primary btn-sm float-right"><i class="fas fa-user-plus"></i> Tambah akun</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th style="text-align: center; vertical-align: middle;">No.</th>
                <th style="text-align: center; vertical-align: middle;">Username</th>
                <th style="text-align: center; vertical-align: middle;">Nama Pegawai</th>
                <th style="text-align: center; vertical-align: middle;">Role</th>
                <th style="text-align: center; vertical-align: middle;">Opsi</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    // $data_p = query("SELECT * FROM akun GROUP BY nama_akun asc");
                    $data_p = query("SELECT user.*, pegawai.* 
                                    FROM user 
                                    LEFT JOIN pegawai ON user.id_pegawai = pegawai.id_pegawai  
                                    ORDER BY user.id_user ASC
                                    ");
                    foreach ($data_p as $p) : ?>
                        <tr>
                            <td style="text-align: center; vertical-align: top;"><?= $no++; ?></td>
                            <td><?= $p['username'] ?></td>
                            <td><?= !empty($p['nama_pegawai']) ? ucwords($p['nama_pegawai']) : "Tidak Terkait" ?></td>
                            <td><?= $p['role'] ?></td>
                            <td>
                                <a href="<?= base_url('akun/edit_akun') ?>?id=<?= $p['id_user'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <a href="<?= base_url('_config/proses_akun') ?>?reset&id=<?= $p['id_user'] ?>" 
                                    class="btn btn-info btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin mereset password akun ini?')">
                                    <i class="fas fa-undo"></i> Reset Password
                                </a>
                                <?php if ($_SESSION['id_user'] != $p['id_user']) : ?>
                                <a href="<?= base_url('_config/proses_akun') ?>?delete&id=<?= $p['id_user'] ?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                <?php endif; ?>

                            </td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php

    // menambahkan script khusus untuk halaman ini saja
    $addscript = '
        <script src="'.asset('_assets/vendor/datatables/jquery.dataTables.min.js').'"></script>
        <script src="'.asset('_assets/vendor/datatables/dataTables.bootstrap4.min.js').'"></script>
    
        <script src="'.asset('_assets/js/demo/datatables-demo.js').'"></script>
    ';

    // menghubungkan file footer dengan file detail akun
    require_once "../_template/_footer.php";
?>