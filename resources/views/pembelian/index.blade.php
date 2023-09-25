@extends('layouts.master');

@section('title')
    Pembelian
@endsection
@section('nav')
    Kelola Transaksi
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Pembelian
    </li>
@endsection
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="buttons">

                    <button onclick="addForm()" class="btn btn-secondary rounded-pill"><i data-feather="plus"></i>
                        Pembelian Baru</button>

                </div>
            </div>
        </section>
        <section class="section">
            <div class="card">
                <div class="card-header">Data Transaksi Pembelian</div>
                <div class="card-body table-responsive">

                    <table class="table table-striped table-bordered table-pembelian">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Total Harga</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th width="10%"><i data-feather="settings"></i></th>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @includeIf('pembelian.supplier')
    @includeIf('pembelian.detail')
@endsection

@push('scripts')
    <script>
        let table, table1;

        $(function() {
            table = $('.table-pembelian').DataTable({
                responsive: true,
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('pembelian.data') }}',
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
                        data: 'supplier'
                    },
                    {
                        data: 'total_item'
                    },
                    {
                        data: 'total_harga'
                    },
                    {
                        data: 'diskon'
                    },
                    {
                        data: 'bayar'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false,
                    },
                ]
            });
            $('.table-supplier').DataTable();
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
                        data: 'harga_beli'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'subtotal'
                    },
                ]

            })

        });

        function addForm() {
            $('#modal-supplier').modal('show');
        }

        function showDetail(url) {
            $('#modal-detail').prependTo('body').modal('show');
            table1.ajax.url(url);
            table1.ajax.reload();
        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        swal.fire('Success', 'Behasil Menghapus Data', 'success')
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        swal.fire('Error', 'Gagal Menghapus Data', 'error')
                        return;
                    });
            }
        }
    </script>
@endpush
