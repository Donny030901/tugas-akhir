@extends('layouts.master');

@section('title')
    Penjualan
@endsection
@section('nav')
    Kelola Transaksi
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Penjualan
    </li>
@endsection
@section('content')
    <div class="page-content">

        <section class="section">
            <div class="card">
                <div class="card-header">Data Transaksi Penjualan</div>
                <div class="card-body table-responsive">

                    <table class="table table-striped table-bordered table-penjualan">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Total Item</th>
                            <th>Harga Jual</th>
                            <th>Total</th>
                            <th>Kasir</th>
                            <th>Keterangan</th>
                            <th width="10%"><i data-feather="settings"></i></th>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @includeIf('penjualan.detail')
@endsection

@push('scripts')
    <script>
        let table, table1;

        $(function() {
            table = $('.table-penjualan').DataTable({
                responsive: true,
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('penjualan.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'total_item'
                    },
                    {
                        data: 'total_harga'
                    },
                    {
                        data: 'bayar'
                    },
                    {
                        data: 'kasir'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false,
                    },
                ]
            });
            table1 = $('.table-detail').DataTable({
                processing: true,
                bSort: false,
                dom: 'Brt',
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false
                    },
                    {
                        data: 'kode_produk'
                    },
                    {
                        data: 'nama_produk'
                    },
                    {
                        data: 'harga_jual'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'subtotal'
                    },
                ]

            })

        });


        function showDetail(url) {
            $('#modal-detail').prependTo('body').modal('show');
            table1.ajax.url(url);
            table1.ajax.reload();
        }

        // function deleteData(url) {
        //     if (confirm('Yakin ingin menghapus data terpilih?')) {
        //         $.post(url, {
        //                 '_token': $('[name=csrf-token]').attr('content'),
        //                 '_method': 'delete'
        //             })
        //             .done((response) => {
        //                 table.ajax.reload();
        //             })
        //             .fail((errors) => {
        //                 alert('Tidak dapat menghapus data');
        //                 return;
        //             });
        //     }
        // }
    </script>
@endpush
