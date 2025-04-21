<?php

    require_once "config.php";

    if (isset($_GET['add']) ) {
        if (!isset($_POST['id_pegawai']) || empty($_POST['id_pegawai'])) {
            echo '<script>alert("ID Pegawai tidak boleh kosong");</script>';
            exit;
        }

        $back_to_id = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $id_pegawai = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $tingkat = strip_tags($_POST['tingkat']);
        $sekolah = strip_tags($_POST['sekolah']);
        $lokasi = strip_tags($_POST['lokasi']);
        $jurusan = strip_tags($_POST['jurusan']);
        $tgl = strip_tags($_POST['tgl']);
        $no_ijazah = strip_tags($_POST['no_ijazah']);

        $create = create("INSERT INTO pendidikan VALUES ('','$id_pegawai','$tingkat','$sekolah','$lokasi','$jurusan','$tgl','$no_ijazah')");
        if(mysqli_affected_rows($koneksi) > 0) { 
            if (!isset($back_to_id) || empty($back_to_id)) {
                echo '<script>
                alert("Data Berhasil Ditambah")
                window.location = "'.base_url('pendidikan').'";
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
                window.location = "'.base_url('pendidikan').'";
                </script>'; 
            } else {
                echo '<script>
                alert("Data Gagal Diperbarui")
                window.location = "'.base_url('detail_pegawai').'?id='.$id_pegawai.'";
                </script>';
            }   
        }
    } elseif (isset($_GET['edit'])) {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $id_pegawai = mysqli_real_escape_string($koneksi, $_POST['id_pegawai']);
        $tingkat = strip_tags($_POST['tingkat']);
        $sekolah = strip_tags($_POST['sekolah']);
        $lokasi = strip_tags($_POST['lokasi']);
        $jurusan = strip_tags($_POST['jurusan']);
        $tgl = strip_tags($_POST['tgl']);
        $no_ijazah = strip_tags($_POST['no_ijazah']);  

        $update = update("UPDATE pendidikan SET tingkat='$tingkat',nama_sekolah='$sekolah',lokasi='$lokasi',jurusan='$jurusan',tgl_ijazah='$tgl',no_ijazah='$no_ijazah' WHERE id_pendidikan='$id' ");
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
    } elseif (isset($_GET['delete'])) {
        $id_pendidikan = intval($_GET['id']);
        $id_pegawai = intval($_GET['id_pegawai']);
        
        // Hapus data pegawai dari database
        $delete = mysqli_query($koneksi, "DELETE FROM pendidikan WHERE id_pendidikan = $id_pendidikan");
    
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
