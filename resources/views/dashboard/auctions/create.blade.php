@extends('layouts.app')
@section('title', 'Tambah Data Lelang')

@section('title-header', 'Tambah Data Lelang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Data Lelang</a></li>
    <li class="breadcrumb-item active">Tambah Data Lelang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Tambah Data Lelang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('auctions.store') }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="item_id">Barang Lelang</label>
                                    <select class="form-control @error('item_id') is-invalid @enderror" id="item_id" name="item_id">
                                        <option value="" selected>---Barang Lelang---</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}" @if (old('item_id') == $item->id) selected @endif>
                                                {{ $item->item_name }}</option>
                                        @endforeach
                                    </select>

                                    @error('item_id')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{route('auctions.index')}}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
