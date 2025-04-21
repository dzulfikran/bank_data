<?php
$data_pangkat = query("SELECT * FROM pangkat WHERE id_pegawai='$id_pegawai' ORDER BY tmt_pangkat");
$id_pegawai_login = $_SESSION['id_pegawai'];
?>
<div class="table-responsive mt-3">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nama pangkat</th>
                <th>Jenis Pangkat</th>
                <th>TMT</th>
                <th>Sah SK</th>
                <th>Nama Pengesah SK</th>
                <th>No SK</th>
                <th>Status pangkat</th>
                <?php if (cek_role('admin') || ($id_pegawai_login == $id_pegawai)) : ?>
                <th>Opsi</th>
                <?php endif ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($data_pangkat as $pangkat) :
            ?>
                <tr>
                    <td><?= ucwords($pangkat['nama_pangkat']) ?></td>
                    <td><?= ucwords($pangkat['jenis_pangkat']) ?></td>
                    <td><?= date('d-m-Y',strtotime($pangkat['tmt_pangkat'])) ?></td>
                    <td><?= date('d-m-Y',strtotime($pangkat['sah_sk'])) ?></td>
                    <td><?= ucwords($pangkat['nama_pengesah_sk']) ?></td>
                    <td><?= ucwords($pangkat['no_sk']) ?></td>
                    <td><?= ucwords($pangkat['status_pangkat']) ?></td>
                    <?php if (cek_role('admin') || ($id_pegawai_login == $id_pegawai)) : ?>
                    <td>
                        <a href="<?= base_url('detail_pegawai/edit_pangkat') ?>?id=<?= $pangkat['id_pangkat'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a href="<?= base_url('_config/proses_pangkat') ?>?set&id=<?= $pangkat['id_pangkat'] ?>&id_pegawai=<?= $id_pegawai ?>" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Setup</a>
                        <a href="<?= base_url('_config/proses_pangkat') ?>?delete&id=<?= $pangkat['id_pangkat'] ?>&id_pegawai=<?= $pangkat['id_pegawai']?>" 
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