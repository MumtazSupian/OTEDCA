@extends('layouts.app')

@section('content')
<h1 class="page-title">Data Users</h1>

@if(session('success'))
    <div style="margin:8px 0; padding:8px; background:#d1fae5; border-radius:6px;">{{ session('success') }}</div>
@endif

<div style="margin-bottom:12px; display:flex; justify-content:flex-end;">
    <a href="{{ route('admin.users.create') }}" class="btn-primary">Create</a>
    </div>

<table style="width:100%; border-collapse:collapse; background:#fff;">
    <thead>
        <tr>
            <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">#</th>
            <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Nama</th>
            <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Email</th>
            <th style="text-align:left; padding:8px; border-bottom:1px solid #eee;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $i => $item)
        <tr>
            <td style="padding:8px; border-bottom:1px solid #f4f4f4;">{{ $items->firstItem() + $i }}</td>
            <td style="padding:8px; border-bottom:1px solid #f4f4f4;">{{ $item->name }}</td>
            <td style="padding:8px; border-bottom:1px solid #f4f4f4;">{{ $item->email }}</td>
            <td style="padding:8px; border-bottom:1px solid #f4f4f4;">
                <a href="{{ route('admin.users.edit', $item) }}" class="btn-primary" style="background:#06b6d4;">Edit</a>
                <form action="{{ route('admin.users.destroy', $item) }}" method="POST" style="display:inline-block; margin-left:8px;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-primary" style="background:#ef4444;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top:12px;">{{ $items->links() }}</div>

@endsection
