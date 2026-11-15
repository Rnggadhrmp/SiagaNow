@extends('admin.layout')
@section('title','Data shelter') @section('top-title','Shelter')
@section('content')
<div class="page-heading"><div><h2>{{ $shelter->exists?'Edit shelter':'Tambah shelter' }}</h2><p>Shelter baru berstatus belum diverifikasi dan tidak dipublikasikan sebagai lokasi resmi.</p></div></div>
<form class="panel" method="post" action="{{ $shelter->exists?route('admin.shelters.update',$shelter):route('admin.shelters.store') }}">
@csrf @if($shelter->exists)@method('PUT')@endif
<div class="form-grid">
<div class="field"><label for="name">Nama shelter</label><input id="name" name="name" value="{{ old('name',$shelter->name) }}" required></div>
<div class="field"><label for="status">Kondisi</label><select id="status" name="status">@foreach(['unknown'=>'Belum diketahui','open'=>'Buka','closed'=>'Tutup'] as $v=>$label)<option value="{{ $v }}" @selected(old('status',$shelter->status)===$v)>{{ $label }}</option>@endforeach</select></div>
<div class="field span-2"><label for="address">Alamat</label><textarea id="address" name="address" required>{{ old('address',$shelter->address) }}</textarea></div>
<div class="field"><label for="latitude">Latitude</label><input id="latitude" name="latitude" type="number" step="any" min="-90" max="90" value="{{ old('latitude',$shelter->latitude) }}"></div>
<div class="field"><label for="longitude">Longitude</label><input id="longitude" name="longitude" type="number" step="any" min="-180" max="180" value="{{ old('longitude',$shelter->longitude) }}"></div>
<div class="field"><label for="capacity">Kapasitas (jika tersedia)</label><input id="capacity" name="capacity" type="number" min="0" value="{{ old('capacity',$shelter->capacity) }}"></div>
<div class="field"><label for="source">Sumber verifikasi</label><input id="source" name="source" value="{{ old('source',$shelter->source) }}" required></div>
<div class="field span-2"><label for="source_url">URL sumber</label><input id="source_url" type="url" name="source_url" value="{{ old('source_url',$shelter->source_url) }}" placeholder="https://"></div>
</div><div class="form-actions"><button class="btn">Simpan</button><a class="btn btn-secondary" href="{{ route('admin.shelters.index') }}">Kembali</a></div></form>
@if($shelter->exists)<form class="panel" method="post" action="{{ route('admin.shelters.verify',$shelter) }}">@csrf @method('PATCH')<h3>Verifikasi shelter</h3><div class="field"><label for="verified">Status verifikasi</label><select id="verified" name="verified"><option value="0">Belum diverifikasi</option><option value="1" @selected($shelter->verified_at)>Terverifikasi</option></select></div><p class="help">Pilih terverifikasi hanya setelah memeriksa sumber, alamat, dan koordinat.</p><button class="btn btn-secondary" type="submit">Simpan verifikasi</button></form>@endif
@endsection
