<div class="panel">
    <form class="toolbar" method="get" action="{{ $indexRoute }}">
        <div class="field" style="margin:0;min-width:min(260px,100%)"><label for="q">Cari</label><input id="q" name="q" value="{{ request('q') }}" placeholder="Kata kunci"></div>
        @if(!empty($filterOptions))<div class="field" style="margin:0;min-width:170px"><label for="status">Status</label><select name="status" id="status"><option value="">Semua status</option>@foreach($filterOptions as $value=>$label)<option value="{{ $value }}" @selected(request('status')===$value)>{{ $label }}</option>@endforeach</select></div>@endif
        <button class="btn btn-sm" type="submit">Terapkan</button><a class="btn btn-secondary btn-sm" href="{{ route($indexRoute) }}">Bersihkan</a>
    </form>
    @if($items->isEmpty())<div class="empty"><strong>{{ $emptyTitle ?? 'Belum ada data' }}</strong>{{ $emptyText ?? 'Data akan tampil di sini setelah tersedia.' }}</div>
    @else<div class="table-wrap"><table class="data-table"><thead><tr>@foreach($columns as $label)<th>{{ $label }}</th>@endforeach<th>Tindakan</th></tr></thead><tbody>@foreach($items as $item)<tr>@foreach($keys as $key)<td>{!! $cell($item,$key) !!}</td>@endforeach<td><a class="btn btn-secondary btn-sm" href="{{ route($editRoute,$item) }}">Buka / edit</a></td></tr>@endforeach</tbody></table></div>@include('admin.partials.pagination',['items'=>$items])@endif
</div>
