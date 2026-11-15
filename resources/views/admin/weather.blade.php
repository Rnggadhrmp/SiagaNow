@extends('admin.layout')
@section('title','Cuaca BMKG') @section('top-title','Integrasi cuaca')
@section('content')
<div class="page-heading"><div><h2>Cuaca dan peringatan BMKG</h2><p>Halaman ini hanya membaca data dari layanan yang sudah terintegrasi. Admin tidak dapat menulis data BMKG.</p></div></div>
<div class="panel"><h3>Status prakiraan saat ini</h3><dl class="detail-grid"><dt>Status data</dt><dd><span class="status {{ ($forecast['status']??'unknown')==='available'?'status-ok':'status-warn' }}">{{ $forecast['status']??'unknown' }}</span></dd><dt>Tipe data</dt><dd>{{ $forecast['data_type']??'unavailable' }}</dd><dt>Sumber</dt><dd>{{ $forecast['source']??'Tidak tersedia' }}</dd><dt>Wilayah</dt><dd>{{ $forecast['location']??'Tidak tersedia' }}</dd><dt>Diperbarui</dt><dd>{{ $forecast['updated_at']??'Belum diketahui' }}</dd><dt>Pesan</dt><dd>{{ $forecast['message']??'Data prakiraan belum tersedia.' }}</dd></dl></div>
<div class="panel"><h3>Cache peringatan yang tersimpan</h3>
@if($warnings->isEmpty())<div class="empty"><strong>Belum ada peringatan tersimpan</strong>Data kosong berbeda dari kegagalan koneksi; status feed dijelaskan pada panel di atas.</div>
@else<div class="table-wrap"><table class="data-table"><thead><tr><th>Judul</th><th>Area</th><th>Waktu efektif</th><th>Sumber</th><th>Pembaruan cache</th></tr></thead><tbody>@foreach($warnings as $warning)<tr><td>{{ $warning->title }}</td><td>{{ $warning->area_description }}</td><td>{{ $warning->effective_at?->format('d M Y H:i')??'—' }}</td><td>{{ $warning->source??'BMKG' }}</td><td>{{ $warning->last_fetched_at?->format('d M Y H:i')??'—' }}</td></tr>@endforeach</tbody></table></div>@include('admin.partials.pagination',['items'=>$warnings])@endif
</div>
@endsection
