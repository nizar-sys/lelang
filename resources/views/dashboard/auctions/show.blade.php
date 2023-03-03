@extends('layouts.app')
@section('title', 'Auctions Detail')

@section('title-header', 'Auctions Detail')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('auctions.index') }}">Auctions</a></li>
    <li class="breadcrumb-item active">Auctions History</li>
@endsection

@if ($auction->status == 'dibuka' && Auth::user()->role != 'admin')

    @section('action_btn')
        <a href="{{ route('auctions.create-auction', ['auctionId' => $auction->id]) }}" class="btn btn-default">Tambah Data
            Penawaran</a>
    @endsection
@endif

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Auctions History</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Awal</th>
                                    <th>Harga Tawaran</th>
                                    <th>Nama Penawar</th>
                                    <th>Tanggal Tawar</th>
                                    <th>Status Tawaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($auction->historyAuctions()->get() as $historyAuction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $historyAuction->auction->item->item_name ?? '' }}</td>
                                        <td>Rp.
                                            {{ number_format($historyAuction->auction->item->start_price ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td>Rp. {{ number_format((int) $historyAuction->price_quote, 0, ',', '.') }}</td>
                                        <td>{{ $historyAuction->bidder->name }}</td>
                                        <td>{{ $historyAuction->created_at }}</td>
                                        @php
                                            $badge = 'badge badge-danger';
                                            $status = 'Ditolak';
                                            if ($historyAuction->status == 'accepted') {
                                                $badge = 'badge badge-success';
                                                $status = 'Diterima';
                                            } elseif ($historyAuction->status == 'pending') {
                                                $badge = 'badge badge-default';
                                                $status = 'pending';
                                            }
                                        @endphp
                                        <td>
                                            <div class="{{ $badge }}">{{ $status }}</div>
                                        </td>
                                        @if ($auction->status == 'dibuka')
                                            <td class="d-flex jutify-content-center">

                                                @if (Auth::user()->role == 'admin')
                                                    <form id="auction-form-{{ $historyAuction->id }}"
                                                        action="{{ route('auctions.status-auction', ['auctionId' => $auction->id, 'historyId' => $historyAuction->id]) }}"
                                                        class="d-none" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    <button onclick="statusAuction('{{ $historyAuction->id }}')"
                                                        class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                                @endif

                                                @if (Auth::user()->role == 'admin' || $historyAuction->bidder_id == Auth::id())
                                                    <form id="delete-form-{{ $historyAuction->id }}"
                                                        action="{{ route('auctions.destroy-auction', ['auctionId' => $auction->id, 'historyId' => $historyAuction->id]) }}"
                                                        class="d-none" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <button onclick="deleteForm('{{ $historyAuction->id }}')"
                                                        class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteForm(id) {
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

        function statusAuction(id) {
            Swal.fire({
                title: 'Terima tawaran lelang',
                text: "Anda akan menerima tawaran lelang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#auction-form-${id}`).submit()
                }
            })
        }
    </script>
@endsection
