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
        'bobot' => 0.5,
        'laporan' => 2,
        'validasi_penilai' => 3,
        'validasi_atasan' => 3
    ),
    'skp' => array(
        'bobot' => 0.2,
        'laporan' => 2,
        'validasi_penilai' => 3,
        'validasi_atasan' => 3
    )
);
