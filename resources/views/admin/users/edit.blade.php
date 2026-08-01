@extends('layouts.app')

@section('content')
<h1 class="page-title">Edit User</h1>

<form method="POST" action="{{ route('admin.users.update', $item) }}">
    @csrf @method('PUT')
    <div style="margin-bottom:8px;">
        <label>Nama</label>
        <input type="text" name="name" value="{{ old('name', $item->name) }}" style="width:100%; padding:8px;" required>
    </div>
    <div style="margin-bottom:8px;">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $item->email) }}" style="width:100%; padding:8px;" required>
    </div>
    <div style="margin-bottom:8px;">
        <label>Password (kosongkan untuk tidak mengubah)</label>
        <input type="password" name="password" style="width:100%; padding:8px;">
    </div>
    <div style="margin-bottom:8px;">
        <label>Branch</label>
        <input type="text" name="branch" value="{{ old('branch', $item->branch) }}" style="width:100%; padding:8px;">
    </div>
    <div style="margin-bottom:8px;">
        <label><input type="checkbox" name="is_admin" value="1" {{ $item->is_admin ? 'checked' : '' }}> Is Admin</label>
    </div>
    <div>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary" style="margin-right:8px;">Batal</a>
        <button class="btn-primary">Simpan</button>
    </div>
</form>

@endsection
