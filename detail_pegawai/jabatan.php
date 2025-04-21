<?php
$data_jabatan = query("SELECT * FROM jabatan WHERE id_pegawai='$id_pegawai' ORDER BY tmt");
$id_pegawai_login = $_SESSION['id_pegawai'];
?>
<div class="table-responsive mt-3">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Jabatan</th>
                <th>Eselon</th>
                <th>TMT</th>
                <th>Sampai Tanggal</th>
                <th>Status Jabatan</th>
                <?php if (cek_role('admin') || ($id_pegawai_login == $id_pegawai)) : ?>
                <th>Opsi</th>
                <?php endif ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data_jabatan as $jabatan) :
            ?>
                <tr>
                    <td><?= ucwords($jabatan['nama_jabatan']) ?></td>
                    <td><?= ucwords($jabatan['eselon']) ?></td>
                    <td><?= date('d-m-Y',strtotime($jabatan['tmt'])) ?></td>
                    <td><?= date('d-m-Y',strtotime($jabatan['sampai_tgl'])) ?></td>
                    <td><?= ucwords($jabatan['status_jabatan']) ?></td>
                    <?php if (cek_role('admin') || ($id_pegawai_login == $id_pegawai)) : ?>
                    <td>
                        <a href="<?= base_url('detail_pegawai/edit_jabatan') ?>?id=<?= $jabatan['id_jabatan'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a href="<?= base_url('_config/proses_jabatan') ?>?set&id=<?= $jabatan['id_jabatan'] ?>&id_pegawai=<?= $id_pegawai ?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Setup</a>
                        <a href="<?= base_url('_config/proses_jabatan') ?>?delete&id=<?= $jabatan['id_jabatan'] ?>&id_pegawai=<?= $jabatan['id_pegawai']?>" 
                            class="btn btn-danger btn-sm" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                    <?php endif ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>