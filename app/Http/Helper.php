<?php

namespace App\Http;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Helper
{
  public static function uploadFile($path, $file)
  {
    return Storage::put($path, $file);
  }

  public static function deleteFile($path)
  {
    return Storage::delete($path);
  }

  public static function toRupiah(int $num)
  {
    return 'Rp ' . number_format($num, 0, ',', '.');
  }

  public static function fileUrl($path)
  {
    $url = Str::substr($path, 7);
    return URL::to('public/' . $url);
  }

  public static function paginate($paginator)
  {
    $totalPage = (($paginator->total() - ($paginator->total() % $paginator->perPage())) / $paginator->perPage()) + 1;
    $result = [
      'limit' => $paginator->perPage(),
      'current_page' => $paginator->currentPage(),
      'total_page' => $totalPage,
      'count' => $paginator->count(),
      'total' => $paginator->total(),
      'data' => $paginator->items(),
    ];
    return $result;
  }
}
