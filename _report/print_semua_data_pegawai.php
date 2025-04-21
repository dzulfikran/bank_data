<?php
include "../_config/config.php";
require_once "../_assets/vendor/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$pegawai = query("SELECT * FROM pegawai GROUP BY nama_pegawai asc");

$content = '<html><head><style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .kop {
        text-align: center;
        margin-bottom: 20px;
    }
    .kop img {
        width: auto; 
        height: 80px;
        position: absolute;
        left: 50px;
        top: 8px;
    }
    .kop h2, .kop h3 {
        margin: 5px;
    }
    .kop hr {
        border: 1px solid black;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
        text-align: center;
    }
</style></head><body>';

// Ambil logo kop surat (ubah path sesuai dengan lokasi file Anda)
$logo_path = "../_assets/img/logo_buton.png";
if (file_exists($logo_path)) {
    $logo_data = file_get_contents($logo_path);
    $logo_base64 = 'data:image/png;base64,' . base64_encode($logo_data);
} else {
    $logo_base64 = "";
}

// $content .= '<div class="kop">
//     <img src="'.$logo_base64.'" alt="Logo">
//     <h2>PEMERINTAH KABUPATEN BUTON</h2>
//     <h3>DINAS KOMUNIKASI, INFORMATIKA, DAN PERSANDIAN</h3>
//     <p style="margin:2px;">Kompleks Perkantoran TAKAWA Gedung B Lantai II</p>
//     <p style="margin:2px;">Telepon (0402) 2810302 Faximile (0402) 2821221</p>
//     <hr/>
// </div>';

$content .= '<center><h3>DAFTAR PEGAWAI</h3></center>';
$content .= '<table>
<thead>
<tr>
    <th>No</th>
    <th>NIP</th>
    <th>Nama Pegawai</th>
    <th>Tempat, Tanggal Lahir</th>
    <th>Jenis Kelamin</th>
    <th>No HP</th>
    <th>Agama</th>
    <th>Email</th>
    <th>Alamat</th>
</tr>
</thead>
<tbody>';

$no = 1;
foreach ($pegawai as $all_pegawai) {
    $content .= "<tr>
        <td>".$no."</td>
        <td>".$all_pegawai['nip']."</td>
        <td>".ucwords($all_pegawai['nama_pegawai'])."</td>
        <td>".ucwords($all_pegawai['tempat_lahir']).", ".date('d-m-Y', strtotime($all_pegawai['tanggal_lahir']))."</td>
        <td>".ucwords($all_pegawai['jenis_kelamin'])."</td>
        <td>".$all_pegawai['no_hp']."</td>
        <td>".strtoupper($all_pegawai['agama'])."</td>
        <td>".$all_pegawai['email']."</td>
        <td>".ucwords($all_pegawai['alamat'])."</td>
    </tr>";
    $no++;
}
$content .= '</tbody></table></body></html>';

$dompdf->loadHtml($content);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Daftar_Pegawai.pdf", ["Attachment" => false]);
