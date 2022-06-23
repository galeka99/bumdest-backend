@php
  $total = $data->total();
  $count = $data->count();
  $mod = $total % $count;
  $total_pages = ($total - $mod) / $count;
  if ($mod !== 0) $total_pages += 1;
@endphp

<div class="flex flex-row gap-x-2">
  <a href="{{ $data->previousPageUrl() }}" class="btn btn-sm btn-primary{{ $data->onFirstPage() ? ' disabled' : '' }}">
    <i class="mdi mdi-chevron-double-left"></i>
  </a>
  @if ($total_pages > 7)
    @if ($data->currentPage() < 4)
      @foreach ($data->getUrlRange(1, 7) as $i => $url)
        <a href="{{ $url }}" class="btn btn-sm btn-primary{{ $data->currentPage() === $i ? ' disabled' : '' }}">{{ $i }}</a>
      @endforeach
    @else
      @foreach ($data->getUrlRange($data->currentPage() - 3, $data->currentPage() + 3) as $i => $url)
        <a href="{{ $url }}" class="btn btn-sm btn-primary{{ $data->currentPage() === $i ? ' disabled' : '' }}">{{ $i }}</a>
      @endforeach
    @endif
  @else
    @foreach ($data->getUrlRange(1, $total_pages) as $i => $url)
      <a href="{{ $url }}" class="btn btn-sm btn-primary{{ $data->currentPage() === $i ? ' disabled' : '' }}">{{ $i }}</a>
    @endforeach
  @endif
  <a href="{{ $data->nextPageUrl() }}" class="btn btn-sm btn-primary{{ $data->lastPage() == $data->currentPage() ? ' disabled' : '' }}">
    <i class="mdi mdi-chevron-double-right"></i>
  </a>
</div>