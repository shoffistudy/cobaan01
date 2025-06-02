<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('numbering')) {
    function numbering($table, $prefix, $key = 'nomor', $digit = 3)
    {
        $max = DB::table($table)
            ->select(DB::raw("MAX($key) as kode"))
            ->where("$key", "like", "$prefix%")
            ->first();

        $last_nomor = substr($max->kode, strlen($prefix), $digit);
        $next_nomor = $prefix . sprintf("%0{$digit}s", (int) $last_nomor + 1);
        return $next_nomor;
    }
}
