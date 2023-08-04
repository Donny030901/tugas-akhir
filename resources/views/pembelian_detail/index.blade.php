@extends('layouts.master');

@section('title')
    Transaksi Pembelian
@endsection
@section('nav')
    Kelola Transaksi
@endsection
@push('css')
    <style>
        .tampil-bayar {
            font-size: 4em;
            color: #f0f0f0;
            text-align: center;
            height: 100px;
        }

        .tampil-terbilang {
            padding: 10px;
            background: #f0f0f0;
        }

        .table-pembelian tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 15px;
            }
        }
    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Transaksi Pembelian
    </li>
@endsection
@section('content')
    <div class="page-content">
        <section class="row">




        </section>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="col-lg-4">
                        <div class="col-12 col-lg-9">
                            <table>
                                <tr>
                                    <td>Supplier</td>
                                    <td>: {{ $supplier->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Telepon</td>
                                    <td>: {{ $supplier->telepon }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{ $supplier->alamat }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                @if (Session::get('status') == 'error_checkout')
                    <div class="alert alert-danger alert-dismissible" id="alert-error" role="alert">
                        Pilih barang sebelum Bayar!
                    </div>
                @endif
                <div class="card-body">
                    <div class="row">

                    </div>
                    <form class="form-produk"">
                        @csrf
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-3">Kode Produk</label>
                            <div class="col-lg-5">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="id_pembelian" id="id_pembelian" value="{{ $id_pembelian }}">
                                    <input type="hidden" name="id_produk" id="id_produk">
                                    <input type="text" class="form-control" placeholder="Pilih Produk" name="kode_produk"
                                        id="kode_produk" />
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button">
                                        <i data-feather="arrow-right"></i>
                                </div>

                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered table-pembelian">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th width="13%">Jumlah</th>
                            <th>Subtotal</th>
                            <th width="10%"><i data-feather="settings"></i></th>

                        </thead>
                    </table>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="tampil-bayar bg-primary"></div>
                            <div class="tampil-terbilang"></div>
                        </div>
                        <div class="col-lg-4">
                            <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="POST">
                                @csrf
                                <input type="hidden" name="id_pembelian" value="{{ $id_pembelian }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">

                                <div class="form-group row">
                                    <label for="totalrp" class="col-lg-4 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="totalrp" class="form-control" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diskon" class="col-lg-4 control-label">Diskon</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="diskon" id="diskon" class="form-control"
                                            value="0">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bayar" class="col-lg-4 control-label">Total Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="bayarrp" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-end btn-simpan"><i data-feather="save"></i>
                            Simpan
                            Transaksi</button>
                    </div>
                </div>
            </div>
        </section>
        {{-- <section class="section">
            <div class="card">
                <div class="card-body">

                </div>
            </div>
        </section> --}}
    </div>
    @includeIf('pembelian_detail.produk')
@endsection

@push('scripts')
    <script>
        let table, table2;

        $(function() {


            setTimeout(() => {
                $('#alert-error').hide()
            }, 5000);

            table = $('.table-pembelian').DataTable({
                    processing: true,
                    autoWidth: false,
                    ajax: {
                        url: '{{ route('pembelian_detail.data', $id_pembelian) }}',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            sortable: false,
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
                        {
                            data: 'aksi',
                            searchable: false,
                            sortable: false,
                        },
                    ],
                    dom: 'Brt',
                    bSort: false,
                })
                .on('draw.dt', function() {
                    loadForm($('#diskon').val());
                });

            table2 = $('.table-produk').DataTable();

            $(document).on('input', '.edit-jumlah', function() {
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());

                if (jumlah < 1) {
                    $(this).val(1);
                    swal.fire('Warning', 'Jumlah tidak boleh kurang dari 1', 'warning')
                    return;
                }
                if (jumlah > 10000) {
                    $(this).val(10000);
                    swal.fire('Warning', 'Jumlah tidak boleh lebih dari 10000', 'warning')
                    return;
                }

                $.post(`{{ url('/pembelian_detail') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'put',
                        'jumlah': jumlah
                    })
                    .done(response => {
                        $(this).on('mouseout', function() {
                            table.ajax.reload(() => loadForm($('#diskon').val()));

                        });
                    })
                    .fail(errors => {
                        swal.fire('Error', 'Data Gagal di Simpan', 'error')
                        return;
                    });
            });

            $(document).on('input', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();

                }

                loadForm($(this).val());
            });

            $('.btn-simpan').on('click', function() {
                $('.form-pembelian').submit();
            });


        });

        function tampilProduk() {
            $('#modal-produk').modal('show');


        }

        function hideProduk() {
            $('#modal-produk').modal('hide');


        }

        function pilihProduk(id, kode) {
            $('#id_produk').val(id);
            $('#kode_produk').val(kode);
            hideProduk();
            tambahProduk();


        }

        function tambahProduk() {
            $.post('{{ route('pembelian_detail.store') }}', $('.form-produk').serialize())
                .done(response => {
                    $('#kode_produk').focus();
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })

                .fail(response => {
                    swal.fire('Error', 'Tidak dapat menyimpan data', 'error')
                    return;
                });

        }

        function deleteData(url) {
            if (confirm('Yakin ingin menghapus data terpilih?')) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        swal.fire('Deleted!', 'Berhasil Menghapus Produk Terpilih ', 'success')
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    })
                    .fail((errors) => {
                        swal.fire('Error', 'Tidak dapat menghapus data', 'error')
                        return;
                    });
            }
        }

        function loadForm(diskon = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/pembelian_detail/loadform') }}/${diskon}/${$('.total ').text()}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val('Rp. ' + response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Rp. ' + response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);
                })
                .fail(response => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }
    </script>
@endpush
