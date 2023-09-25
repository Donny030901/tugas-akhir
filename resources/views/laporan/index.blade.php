@extends('layouts.master')

@section('title')
    Laporan
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}" />
@endpush
@section('nav')
    Laporan
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Laporan Pendapatan
    </li>
@endsection
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="buttons">

                    <button onclick="updatePeriode()" class="btn btn-secondary rounded-pill"><i
                            data-feather="arrow-down-circle"></i> Ubah
                        Periode</button>
                    <a href="{{ route('laporan.exportPDF', [$tanggal_awal, $tanggal_akhir]) }}" target="_blank"
                        onclick="ubahPeriode" class="btn btn-success rounded-pill"><i data-feather="file-text"></i> Export
                        PDF</a>

                </div>
            </div>
        </section>
        <section class="section">
            <div class="card">
                <div class="card-header">Laporan Pendapatan {{ tanggal_indonesia($tanggal_awal, false) }} sd
                    {{ tanggal_indonesia($tanggal_akhir, false) }}</div>
                <div class="card-body table-responsive">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Penjualan</th>
                            <th>Pembelian</th>
                            <th>Pengeluaran</th>
                            <th>Pendapatan</th>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @includeIf('laporan.form', [$tanggal_awal, $tanggal_akhir])
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('laporan.data', [$tanggal_awal, $tanggal_akhir]) }}',
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
                        data: 'penjualan'
                    },
                    {
                        data: 'pembelian'
                    },
                    {
                        data: 'pengeluaran'
                    },
                    {
                        data: 'pendapatan'
                    },
                ],
                dom: 'Brt',
                bSort: false,
                bPaginate: false,

            });

            $('.flatpickr').flatpickr({
                format: 'yyyy-mm-dd',
                autoclose: true,
            });




        });

        function updatePeriode(url) {
            $('#modal-form').modal('show');
        }
    </script>
@endpush
