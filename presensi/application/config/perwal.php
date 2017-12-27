<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Copyright (C) 2017 Rinaldi
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Peraturan Walikota (PERWAL)
 *
 * @author Rinaldi
 */
$config['perwal'] = array(
    'presensi' => array(
        'bobot' => 0.3,
        'laporan' => 0,
        'validasi_penilai' => 3,
        'validasi_atasan' => 3,
        'absensi' => array('Hadir', 'Cuti', 'Dinas')
    ),
    'aktivitas' => array(
        'bobot' => 0.45,
        'overtime' => 0.05,
        'laporan' => 2,
        'validasi_penilai' => 3,
        'validasi_atasan' => 3
    ),
    'ppk' => array(
        'bobot' => 0.2,
        'laporan' => 2,
        'validasi_penilai' => 3,
        'validasi_atasan' => 3
    )
);
$config['jenis_perilaku'] = array(
    '1' => 'Orientasi Pelayanan',
    '2' => 'Integritas',
    '3' => 'Komitmen',
    '4' => 'Disiplin',
    '5' => 'Kerjasama',
    '6' => 'Kepemimpinan'
);
$config['status_masuk'] = array(
    '0' => 'Hadir',
    '1' => 'Absen',
    '2' => 'Terlambat',
    '3' => 'Sakit',
    '4' => 'Izin',
    '5' => 'Dinas',
    '6' => 'Cuti'
);
$config['lapor_masuk'] = array(
    '0' => 'Belum Lapor',
    '1' => 'Sakit',
    '2' => 'Izin',
    '3' => 'Dinas'
);
$config['status_lapor_masuk'] = array(
    '0' => 'Belum Lapor',
    '1' => 'Sakit',
    '2' => 'Izin',
    '3' => 'Dinas'
);
$config['status_pulang'] = array(
    '0' => 'Hadir',
    '1' => 'Absen',
    '2' => 'Pulang',
    '3' => 'Sakit',
    '4' => 'Izin',
    '5' => 'Dinas',
    '6' => 'Cuti'
);
$config['lapor_pulang'] = array(
    '0' => 'Belum Lapor',
    '1' => 'Sakit Dengan Keterangan Dokter',
    '2' => 'Sakit Tanpa Keterangan Dokter',
    '3' => 'Izin Keperluan Pribadi',
    '4' => 'Dinas'
);
$config['status_lapor_pulang'] = array(
    '0' => 'Belum',
    '1' => 'SDKD',
    '2' => 'STKD',
    '3' => 'Izin',
    '4' => 'Dinas'
);
$config['status_absensi'] = array(
    '0' => 'Hadir',
    '1' => 'Absen',
    '2' => 'T/P',
    '3' => 'Sakit',
    '4' => 'Izin',
    '5' => 'Dinas',
    '6' => 'Cuti'
);
$config['lapor_absensi'] = array(
    '0' => 'Belum Lapor',
    '1' => 'Sakit Dengan Keterangan Dokter',
    '2' => 'Sakit Tanpa Keterangan Dokter',
    '3' => 'Izin Keperluan Pribadi',
    '4' => 'Dinas'
);
$config['status_lapor_absensi'] = array(
    '0' => 'Belum',
    '1' => 'SDKD',
    '2' => 'STKD',
    '3' => 'Izin',
    '4' => 'Dinas'
);
$config['jenis_cuti'] = array(
    '1' => 'Cuti Tahunan',
    '2' => 'Cuti Besar',
    '3' => 'Cuti Sakit',
    '4' => 'Cuti Melahirkan',
    '5' => 'Cuti Karena Alasan Penting',
    '6' => 'Cuti Bersama',
    '7' => 'Cuti Diluar Tanggungan Negara'
);
$config['jenis_status_skp'] = array(
    '0' => 'Draft',
    '1' => 'Pengajuan',
    '2' => 'Proses',
    '3' => 'Selesai'
);
$config['jenis_status_ijin'] = array(
    '0' => 'Draft',
    '1' => 'Pengajuan',
    '2' => 'Disetujui',
    '3' => 'Ditolak'
);
$config['pengurang_ppk'] = array(
    '15' => 20,
    '25' => 30,
    '35' => 40,
    '45' => 50,
    '55' => 60,
    '65' => 70,
    '75' => 80,
    '85' => 90,
    '100' => 100
);
