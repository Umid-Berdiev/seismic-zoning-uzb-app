<?php

use Carbon\Carbon;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

/**
 * Write code on Method
 *
 * @return Boolean
 */
if (!function_exists('extractUploadedZip')) {
    function extractUploadedZip($zipfile)
    {
        $zip = new ZipArchive();
        $status = $zip->open($zipfile->getRealPath());

        if ($status !== true) {
            throw new \Exception($status);
        } else {
            $storageDestinationPath = storage_path("app/uploads/unzip/");

            if (!\File::exists($storageDestinationPath)) {
                \File::makeDirectory($storageDestinationPath, 0755, true);
            }
            $zip->extractTo($storageDestinationPath);
            $zip->close();
            return true;
        }
    }
}
