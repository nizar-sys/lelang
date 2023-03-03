@extends('layouts.app')
@section('title', 'Create Auctions')

@section('title-header', 'Create Auctions')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Auctions</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auctions.show', $auction->id) }}">Auctions Detail</a></li>
    <li class="breadcrumb-item active">Create Auctions</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Create Auctions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('auctions.store-auction', ['auctionId' => $auction->id]) }}" method="POST"
                        role="form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="bidder_id" value="{{ Auth::id() }}">
                        <div class="row">
                            <div class="col-12">
                                <label for="item_image" class="mb-3">Gambar Barang</label>
                                <div class="form-group mb-3">
                                    <img class="img-fluid" width="250"
                                        src="{{ asset('/uploads/images/' . $auction->item->item_image) }}"
                                        alt="{{ $auction->item->item_name }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_name">Nama Barang</label>
                                    <h4>{{ $auction->item->item_name }}</h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="item_price">Harga Barang</label>
                                    <h4>Rp. {{ number_format($auction->item->start_price, 0, ',', '.') }}</h4>

                                    @error('item_price')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="price_qoute">Harga Tawaran</label>
                                    <input type="number" class="form-control @error('price_qoute') is-invalid @enderror"
                                        id="price_qoute" placeholder="Harga Tawaran Barang"
                                        value="{{ old('price_qoute') }}" name="price_qoute">

                                    @error('price_qoute')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tawar</button>
                                <a href="{{ route('auctions.show', $auction->id) }}"
                                    class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @error('bidder_id')
        <script>
            Swal.fire({
                title: 'Maaf!',
                text: "Anda telah menawarkan lelang di barang ini.",
                icon: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
            })
        </script>
    @enderror
@endsection
