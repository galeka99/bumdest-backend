<?php

namespace App\Http;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Helper {
  public static function uploadFile($path, $file) {
    return Storage::put($path, $file);
  }

  public static function deleteFile($path) {
    return Storage::delete($path);
  }

  public static function toRupiah(int $num) {
    return 'Rp '.number_format($num, 0, ',', '.');
  }

  public static function fileUrl($path) {
    $url = Str::substr($path, 7);
    return URL::to('public/'.$url);
  }
}