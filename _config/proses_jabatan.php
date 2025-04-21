<?php

    require_once "config.php";

    if (isset($_GET['add']) ) {
        $back_to_id = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $id_pegawai = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $jabatan = strip_tags($_POST['jabatan']);
        $eselon = strip_tags($_POST['eselon']);
        $tmt = strip_tags($_POST['tmt']);
        $sampai_tgl = strip_tags($_POST['sampai_tgl']);

        $create = create("INSERT INTO jabatan VALUES ('','$id_pegawai','$jabatan','$eselon','$tmt','$sampai_tgl','nonaktif')");
        if(mysqli_affected_rows($koneksi) > 0) { 
            if (!isset($back_to_id) || empty($back_to_id)) {
                echo '<script>
                alert("Data Berhasil Ditambah")
                window.location = "'.base_url('jabatan').'";
                </script>'; 
            } else {
                echo '<script>
                alert("Data Berhasil Diperbarui")
                window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
                </script>';
            }                    
        }
        else{
            if (!isset($back_to_id) || empty($back_to_id)) {
                echo '<script>
                alert("Data Gagal Ditambah")
                window.location = "'.base_url('jabatan').'";
                </script>'; 
            } else {
                echo '<script>
                alert("Data Gagal Diperbarui")
                window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
                </script>';
            }   
        }
    }elseif (isset($_GET['edit'])) {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $id_pegawai = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $jabatan = strip_tags($_POST['jabatan']);
        $eselon = strip_tags($_POST['eselon']);
        $tmt = strip_tags($_POST['tmt']);
        $sampai_tgl = strip_tags($_POST['sampai_tgl']);

        $update = update("UPDATE jabatan SET nama_jabatan='$jabatan',eselon='$eselon',tmt='$tmt',sampai_tgl='$sampai_tgl' WHERE id_jabatan='$id' ");
        if(mysqli_affected_rows($koneksi) > 0) { 
            echo '<script>
            alert("Data Berhasil Diperbarui")
            window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
            </script>';                     
        }
        else{
            echo '<script>
            alert("Data Gagal Diperbarui")
            window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
            </script>';  
        }
    }elseif (isset($_GET['set'])) {
        $id = $_GET['id'];
        $id_pegawai = $_GET['id_pegawai'];

        // lakukan pengecekan status jabatan yang aktif dan berdasqarkan id_pegawai pegawai yang bersangkutan
        $cek = mysqli_query($koneksi,"SELECT * FROM jabatan WHERE id_pegawai='$id_pegawai' and status_jabatan='aktif'");
        // apakah hasil pengecekan adalah 0, jika iya maka artonya seluruh data masih nonaktif dan ubah menjadi aktif sesuai dengan id jabatan yang dipilih
        if (mysqli_num_rows($cek) == 0) {
            $update = update("UPDATE jabatan SET status_jabatan='aktif' WHERE id_jabatan='$id' ");
            echo '<script>
            alert("Data Berhasil Diperbarui")
            window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
            </script>';
        }
        // jika sudah ada satu data yang statusnya aktif, maka nonaktifkan dulu semua status yang ada didpegawai tersebut lalu aktifkan sesuai yang diinginkan
        elseif (mysqli_num_rows($cek) == 1) {
            $update = update("UPDATE jabatan SET status_jabatan='nonaktif' WHERE id_pegawai='$id_pegawai' ");
            
            if ($update) {
                $update2 = update("UPDATE jabatan SET status_jabatan='aktif' WHERE id_jabatan='$id' ");
                echo '<script>
                alert("Data Berhasil Diperbarui")
                window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
                </script>';
            }else{
                echo '<script>
                alert("Data Gagal23 Diperbarui")
                window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
                </script>';
            }
        }else{
            echo '<script>
            alert("Data Gagal Diperbarui")
            window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
            </script>';        
        }
    } elseif (isset($_GET['delete'])) {
        $id_jabatan = intval($_GET['id']);
        $id_pegawai = intval($_GET['id_pegawai']);
        
        // Hapus data pegawai dari database
        $delete = mysqli_query($koneksi, "DELETE FROM jabatan WHERE id_jabatan = $id_jabatan");
    
        if ($delete) {
            echo '<script>
            alert("Data Berhasil Dihapus")
            window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
            </script>';  
        } else {
            echo '<script>
            alert("Data Gagal Dihapus")
            window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
            </script>';
        }
    } 