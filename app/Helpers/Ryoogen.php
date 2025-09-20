<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FileFacade;

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
