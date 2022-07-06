<?php

namespace App\Http;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Helper
{
  public static function uploadFile($path, $file)
  {
    return Storage::disk('idcloudhost')->put($path, $file, 'public');
  }

  public static function deleteFile($path)
  {
    return Storage::disk('idcloudhost')->delete($path);
  }

  public static function toRupiah(int $num)
  {
    return 'Rp ' . number_format($num, 0, ',', '.');
  }

  public static function formatNumber(int $num)
  {
    return number_format($num, 0, ',', '.');
  }

  public static function fileUrl($path)
  {
    $url = Str::substr($path, 7);
    return URL::to('public/' . $url);
  }

  public static function paginate($paginator, $hidden_fields = [])
  {
    $totalPage = (($paginator->total() - ($paginator->total() % $paginator->perPage())) / $paginator->perPage()) + 1;
    $result = [
      'limit' => $paginator->perPage(),
      'current_page' => $paginator->currentPage(),
      'total_page' => $totalPage,
      'count' => $paginator->count(),
      'total' => $paginator->total(),
      'data' => $paginator->makeHidden($hidden_fields),
    ];
    return $result;
  }

  public static function sendJson($error_code = null, $data = [], $status = 200)
  {
    return response()->json([
      'status' => $status,
      'error' => $status == 200 ? null : ($error_code ?: 'INVALID_REQUEST'),
      'data' => $data,
    ], $status);
  }
}
