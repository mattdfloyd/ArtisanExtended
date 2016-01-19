<?php

namespace Sebpro\ArtisanExt;

use DB;

class ArtisanExt
{

    public static function checkDb()
    {
        if (DB::connection('mysql')->table(DB::raw('DUAL'))->first([DB::raw(1)])) {
            return true;
        }

        return false;

    }

    public static function checkPermissions()
    {

        $storage_bool = false;
        $bootstrap_cache_bool = false;

        if (is_writable(base_path('storage'))) {
            printf(base_path('storage'));
            $storage_bool = true;
        }

        if (is_writable(base_path('bootstrap/cache'))) {
            printf(base_path('bootstrap/cache'));
            $bootstrap_cache_bool = true;
        }

        return [
          ['bootstrap/cache' => $bootstrap_cache_bool],
          ['storage' => $storage_bool],
        ];
    }
}