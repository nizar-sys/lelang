@extends('layouts.app')
@section('title', 'Items')

@section('title-header', 'Items')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Items</li>
@endsection

@section('action_btn')
    <a href="{{route('items.create')}}" class="btn btn-default">Tambah Data</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Items</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>gambar Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Awal</th>
                                    <th>Deskripsi Barang</th>
                                    <th>Status Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ asset('/uploads/images/'.$item->item_image) }}" alt="{{ $item->item_name }}" width="100">
                                        </td>
                                        <td>{{ $item->item_name }}</td>
                                        <td>Rp. {{ number_format($item->start_price, 0, ',', '.') }}</td>
                                        <td>
                                            {{ str()->words($item->item_desc, 5, ' >>>') }}
                                        </td>
                                        @php
                                        $statusBarang = 'Belum Terjual';
                                        $badge = 'badge badge-success';
                                        if($item->item_status == '1'){
                                            $statusBarang = 'Terjual';
                                            $badge = 'badge badge-danger';
                                        }
                                        @endphp
                                        <td>
                                            <span class="{{$badge}}">{{$statusBarang}}</span>
                                        </td>
                                        <td class="d-flex jutify-content-center">
                                            <a href="{{route('items.edit', $item->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                            <form id="delete-form-{{ $item->id }}" action="{{ route('items.destroy', $item->id) }}" class="d-none" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{$item->id}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
                                        {{ $items->links() }}
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
