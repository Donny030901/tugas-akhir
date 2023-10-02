@extends('layouts.master');

@section('title')
    Transaksi Penjualan
@endsection
@section('nav')
    Kelola Transaksi
@endsection
@push('css')
    <style>
        .tampil-bayar {
            font-size: 3em;
            color: #f0f0f0;
            text-align: center;
            height: 100px;
            padding-top: 20px;
        }

        .tampil-terbilang {
            padding: 10px;
            font-size: 15px;
            background: #f0f0f0;
        }

        .table-penjualan tbody tr:last-child {
            display: none;
        }

        @media(max-width: 768px) {
            .tampil-bayar {
                font-size: 3em;
                height: 70px;
                padding-top: 20px;
            }
        }
    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Transaksi
    </li>
@endsection
@section('content')
    <div class="page-content">
        <section class="row">
        </section>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    @if (Session::get('status') == 'error_checkout')
                        <div class="alert alert-danger alert-dismissible" id="alert-error" role="alert">
                            Pilih barang sebelum Bayar!
                        </div>
                    @endif
                    @if (Session::get('status_bayar') == 'error_bayar')
                        <div class="alert alert-danger alert-dismissible" id="alert-error" role="alert">
                            Masukan Nominal Uang Yang Dibayar!
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">

                    </div>
                    <form class="form-produk"">
                        @csrf
                        <div class="form-group row">
                            <label for="kode_produk" class="col-lg-3">Kode Produk</label>
                            <div class="col-lg-5">
                                <div class="input-group mb-3">
                                    <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                    <input type="hidden" name="id_produk" id="id_produk">
                                    <input type="text" class="form-control" placeholder="Pilih Produk" name="kode_produk"
                                        id="kode_produk" />
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button">
                                        <i data-feather="arrow-right"></i>
                                </div>

                            </div>
                        </div>
                    </form>

                    <table class="table table-striped table-bordered table-penjualan">
                        <thead>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th width="13%">Jumlah</th>
                            <th width="13%">diskon</th>
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
                            <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="POST">
                                @csrf
                                <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="total" id="total">
                                <input type="hidden" name="total_item" id="total_item">
                                <input type="hidden" name="bayar" id="bayar">
                                <input type="hidden" name="diskon" id="diskon" value="0">

                                {{-- <div class="form-group row">
                                    <label for="totalrp" class="col-lg-4 control-label">Total</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="totalrp" class="form-control" readonly disabled>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <label for="kode_member" class="col-lg-4 control-label">Member</label>
                                    <div class="col-lg-8">
                                        <div class="input-group mb-3">
                                            <input type="text" id="kode_member" class="form-control">
                                            <button onclick="tampilMember()" class="btn btn-info btn-flat" type="button">
                                                <i data-feather="arrow-right"></i>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="form-group row">
                                    <label for="diskon" class="col-lg-4 control-label">Anda Hemat</label>
                                    <div class="col-lg-8">
                                        <input type="number" name="hemat" id="hemat" class="form-control" readonly>
                                    </div>
                                </div> --}}
                                <div class="form-group row">
                                    <label for="bayar" class="col-lg-4 control-label">Total Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="bayarrp" class="form-control" readonly disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="diterima" class="col-lg-4 control-label">Bayar</label>
                                    <div class="col-lg-8">
                                        <input type="number" id="diterima" class="form-control" value="0"
                                            name="diterima">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kembali" class="col-lg-4 control-label">Kembalian</label>
                                    <div class="col-lg-8">
                                        <input type="text" id="kembali" class="form-control" value="0"
                                            name="kembali" readonly disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-end btn-simpan"><i data-feather="save"></i>
                            Bayar</button>
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
    @includeIf('penjualan_detail.produk')
@endsection

@push('scripts')
    <script>
        let table, table2;

        $(function() {

            setTimeout(() => {
                $('#alert-error').hide()
            }, 5000);

            table = $('.table-penjualan').DataTable({
                    processing: true,
                    autoWidth: false,
                    ajax: {
                        url: '{{ route('transaksi.data', $id_penjualan) }}',
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

            $(document).on('input', '.quantity', function() {
                let id = $(this).data('id');
                let jumlah = parseInt($(this).val());
                let stok = $(this).attr("data-stok");
                if (jumlah > stok) {
                    $(this).val(stok);
                    swal.fire('Warning', 'Jumlah tidak boleh lebih dari stok', 'warning')
                    return;
                }
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

                $.post(`{{ url('/transaksi') }}/${id}`, {
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
                        alert('Tidak dapat menyimpan data')
                        return;
                    });
            });

            $(document).on('input', '#diskon', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();

                }

                loadForm($('#diskon').val());
            });

            $('#diterima').on('input', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($('#diskon').val(), $(this).val());
            }).focus(function() {
                $(this).select();
            });

            $('.btn-simpan').on('click', function() {
                $('.form-penjualan').submit();
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
            $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
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
            Swal.fire({
                title: 'Yakin ingin menghapus data terpilih?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_token': $('[name=csrf-token]').attr('content'),
                            '_method': 'delete'
                        })
                        .done((response) => {
                            swal.fire('Deleted!', 'Behasil Menghapus Data', 'success')
                            table.ajax.reload(() => loadForm($('#diskon').val()));
                        })
                        .fail((errors) => {
                            swal.fire('Error', 'Tidak dapat menghapus data', 'error')
                            return;
                        });

                }
            })
        }
        // function deleteData(url) {
        //     if (confirm('Yakin ingin menghapus data terpilih?')) {
        //         $.post(url, {
        //                 '_token': $('[name=csrf-token]').attr('content'),
        //                 '_method': 'delete'
        //             })
        //             .done((response) => {
        //                 swal.fire('Success', 'Berhasil Menghapus Produk Terpilih ', 'success')
        //                 table.ajax.reload(() => loadForm($('#diskon').val()));
        //             })
        //             .fail((errors) => {
        //                 swal.fire('Error', 'Tidak dapat menghapus data', 'error')
        //                 return;
        //             });
        //     }
        // }

        function loadForm(diskon = 0, diterima = 0) {
            $('#total').val($('.total').text());
            $('#total_item').val($('.total_item').text());

            $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total ').text()}/${diterima}`)
                .done(response => {
                    $('#totalrp').val('Rp. ' + response.totalrp);
                    $('#bayarrp').val('Rp. ' + response.bayarrp);
                    $('#bayar').val(response.bayar);
                    $('.tampil-bayar').text('Bayar : Rp. ' + response.bayarrp);
                    $('.tampil-terbilang').text(response.terbilang);

                    $('#kembali').val('Rp.' + response.kembalirp);
                    if ($('#diterima').val() != 0) {
                        $('.tampil-bayar').text('Kembali : Rp. ' + response.kembalirp);
                        $('.tampil-terbilang').text(response.kembali_terbilang);
                    }
                })
                .fail(response => {
                    alert('Tidak dapat menampilkan data');
                    return;
                })
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#kategori').on('change', function() {
                var selectedKategori = $(this).val();

                // Semua kategori dipilih
                if (selectedKategori === '') {
                    $('.table-produk tbody tr').show();
                } else {
                    // Sembunyikan semua baris tabel
                    $('.table-produk tbody tr').hide();
                    // Tampilkan baris-baris yang sesuai dengan kategori yang dipilih
                    $('.table-produk tbody tr[data-kategori="' + selectedKategori + '"]').show();
                }
            });
        });
    </script>
@endpush
