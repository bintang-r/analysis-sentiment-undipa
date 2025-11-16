<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FileFacade;

/*
|--------------------------------------------------------------------------
| Helper Pungawa Ryoogen Media
|--------------------------------------------------------------------------
|
| Developed and maintained by Ryoogen Pungawa Media.
|
| Ryoogen Pungawa Media adalah perusahaan yang bergerak di bidang IT development,
| mencakup pembuatan sistem berbasis Website, Mobile App, Desktop,
| Internet of Things (IoT), dan automasi (n8n, dll).
|
| Hak cipta © 2025 Ryoogen Media. All rights reserved.
|
*/

/**
 * Mengecek apakah user sedang online
 *
 * @param int $money total money
 *
 * @param boolean $withRp include Rp. format or not?
 *
 * @return string
 */
if (!function_exists('money_format_idr')) {
    function money_format_idr($money, $withRp = true, $desimal = false)
    {
        $money = (float) $money;

        // if (strpos($money, '.')) {
        //     $money = str_replace('.', '', $money);
        // }

        // if (strpos($money, ',')) {
        //     $money = str_replace(',', '', $money);
        // }

        $money = (float) $money;

        return $withRp
            ? 'Rp. ' . number_format($money, $desimal ? 2 : 0, ',', '.') . ''
            : number_format($money, $desimal ? 2 : 0, ',', '.');
    }
}

/**
 * Membuat angka menjadi format terbilang
 *
 * @param int $angka angka yang ingin di buat terbilang
 *
 * @return string
 */
if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = abs($angka);
        $bilangan = [
            '',
            'Satu',
            'Dua',
            'Tiga',
            'Empat',
            'Lima',
            'Enam',
            'Tujuh',
            'Delapan',
            'Sembilan',
            'Sepuluh',
            'Sebelas'
        ];

        if ($angka < 12) {
            return $bilangan[$angka];
        } elseif ($angka < 20) {
            return terbilang($angka - 10) . ' Belas';
        } elseif ($angka < 100) {
            return terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            return 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
        } else {
            return terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
        }
    }
}

/**
 * Membuat angka menjadi format terbilang dalam bentuk rupiah
 *
 * @param int $angka angka yang ingin di buat terbilang
 *
 * @return string
 */
if (!function_exists('terbilang_rupiah')) {
    function terbilang_rupiah($angka)
    {
        return trim(terbilang($angka)) . ' Rupiah';
    }
}

/**
 * Filter user showing
 *
 * @param object $query query builder
 * @return object $data hasil query
 */
if (!function_exists('secret_user')) {
    function secret_user($query)
    {
        $isUser = auth()->user();
        $isAuthorization = $isUser->role;
        $data = $query;

        if ($isAuthorization != 'developer') {
            $data = $query->whereNotIn('email_232187', config('const.developer_user'));
        }

        return $data;
    }
}

/**
 * Mengecek apakah user sedang online
 *
 * @param string $id id dari user
 * @return boolean
 */
if (!function_exists('is_online')) {
    function is_online($id)
    {
        return Cache::has('user-is-online-' . $id) ? true : false;
    }
}

/**
 * Pindahkan file ke storage/public/{directory} untuk example gambar
 *
 * @param \SplFileInfo $file
 * @param string $directory contoh: 'news'
 * @return string nama file baru (relative path)
 */
if (!function_exists('seeder_example_files')) {
    function seeder_example_files($file, $directory)
    {
        $extension = $file->getExtension();
        $filename = uniqid() . '_' . time() . '_example' . '.' . $extension;

        $directory = rtrim($directory, '/') . '/';

        Storage::disk('public')->put(
            $directory . $filename,
            FileFacade::get($file->getPathname())
        );

        return $directory . $filename;
    }
}
