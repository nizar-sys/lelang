@extends('layouts.app')
@section('title', 'Auctions')

@section('title-header', 'Auctions')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Auctions</li>
@endsection

@if (Auth::user()->role == 'admin')
@section('action_btn')
    <a href="{{route('auctions.create')}}" class="btn btn-default">Tambah Data</a>
@endsection
@endif

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Auctions</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Awal</th>
                                    <th>Harga Akhir</th>
                                    <th>Tanggal Lelang</th>
                                    <th>Penawar Terakhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($auctions as $auction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $auction->item->item_name }}</td>
                                        <td>Rp. {{ number_format($auction->item->start_price, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($auction->lastAuction->price_quote ?? 0, 0, ',', '.') }}</td>
                                        <td>{{ $auction->created_at }}</td>
                                        <td>{{ $auction->lastAuction->bidder?->name ?? '-' }}</td>
                                        @php
                                            $badge = 'badge badge-danger';
                                            if($auction->status == 'dibuka'){
                                                $badge = 'badge badge-success';
                                            }
                                        @endphp
                                        <td>
                                            <div class="{{$badge}}">{{$auction->status}}</div>
                                        </td>
                                        <td class="d-flex jutify-content-center">
                                            <a href="{{route('auctions.show', $auction->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            @if (Auth::user()->role == 'admin')
                                                <form id="delete-form-{{ $auction->id }}" action="{{ route('auctions.destroy', $auction->id) }}" class="d-none" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button onclick="deleteForm('{{$auction->id}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        {{ $auctions->links() }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteForm(id){
            Swal.fire({
                title: 'Hapus data',
                text: "Anda akan menghapus data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit()
                }
            })
        }
    </script>
@endsection
