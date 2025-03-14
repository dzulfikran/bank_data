<?php

    require_once "config.php";

    if (isset($_GET['add']) ) {
        if (!isset($_POST['id_pegawai']) || empty($_POST['id_pegawai'])) {
            echo '<script>alert("ID Pegawai tidak boleh kosong");</script>';
            exit;
        }

        $back_to_id = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $id_pegawai = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $pangkat = strip_tags($_POST['pangkat']);
        $jenis_pangkat = strip_tags($_POST['jenis_pangkat']);
        $tmt = strip_tags($_POST['tmt']);
        $tgl_sah = strip_tags($_POST['tgl_sah']);
        $sah_sk = strip_tags($_POST['sah_sk']);
        $no_sk = strip_tags($_POST['no_sk']);

        $create = create("INSERT INTO pangkat VALUES ('','$id_pegawai','$pangkat','$jenis_pangkat','$tmt','$tgl_sah','$sah_sk','$no_sk','nonaktif')");
        if(mysqli_affected_rows($koneksi) > 0) { 
            if (!isset($back_to_id) || empty($back_to_id)) {
                echo '<script>
                alert("Data Berhasil Ditambah")
                window.location = "'.base_url('pangkat').'";
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
                window.location = "'.base_url('pangkat').'";
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
        $pangkat = strip_tags($_POST['pangkat']);
        $jenis_pangkat = strip_tags($_POST['jenis_pangkat']);
        $tmt = strip_tags($_POST['tmt']);
        $tgl_sah = strip_tags($_POST['tgl_sah']);
        $sah_sk = strip_tags($_POST['sah_sk']);
        $no_sk = strip_tags($_POST['no_sk']);

        $update = update("UPDATE pangkat SET nama_pangkat='$pangkat',jenis_pangkat='$jenis_pangkat',tmt_pangkat='$tmt',sah_sk='$tgl_sah',nama_pengesah_sk='$sah_sk',no_sk='$no_sk' WHERE id_pangkat='$id' ");
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

        // lakukan pengecekan status pangkat yang aktif dan berdasqarkan id_pegawai pegawai yang bersangkutan
        $cek = mysqli_query($koneksi,"SELECT * FROM pangkat WHERE id_pegawai='$id_pegawai' and status_pangkat='aktif'");
        // apakah hasil pengecekan adalah 0, jika iya maka artonya seluruh data masih nonaktif dan ubah menjadi aktif sesuai dengan id pangkat yang dipilih
        if (mysqli_num_rows($cek) == 0) {
            $update = update("UPDATE pangkat SET status_pangkat='aktif' WHERE id_pangkat='$id' ");
            echo '<script>
            alert("Data Berhasil Diperbarui")
            window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
            </script>';
        }
        // jika sudah ada satu data yang statusnya aktif, maka nonaktifkan dulu semua status yang ada didpegawai tersebut lalu aktifkan sesuai yang diinginkan
        elseif (mysqli_num_rows($cek) == 1) {
            $update = update("UPDATE pangkat SET status_pangkat='nonaktif' WHERE id_pegawai='$id_pegawai' ");
            
            if ($update) {
                $update2 = update("UPDATE pangkat SET status_pangkat='aktif' WHERE id_pangkat='$id' ");
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
    }