@extends('layouts.app')
@section('title', 'Ubah Data Barang')

@section('title-header', 'Ubah Data Barang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Data Barang</a></li>
    <li class="breadcrumb-item active">Ubah Data Barang</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Ubah Data Barang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item->id) }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_name">Nama Barang</label>
                                    <input type="text" class="form-control @error('item_name') is-invalid @enderror" id="item_name"
                                        placeholder="Nama Barang" value="{{ old('item_name', $item->item_name) }}" name="item_name">

                                    @error('item_name')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="start_price">Harga Awal</label>
                                    <input type="number" class="form-control @error('start_price') is-invalid @enderror"
                                        id="start_price" placeholder="Harga Awal Barang" value="{{ old('start_price', $item->start_price) }}"
                                        name="start_price">

                                    @error('start_price')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="item_desc">Deskripsi Barang</label>
                                    <textarea  class="form-control @error('item_desc') is-invalid @enderror"
                                    id="item_desc" placeholder="Deskripsi Barang"
                                    name="item_desc" cols="30" rows="10">{{ old('item_desc', $item->item_desc) }}</textarea>
    
                                    @error('item_desc')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Ubah</button>
                                <a href="{{route('items.index')}}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
