@extends('layouts.master');

@section('title')
    Supplier
@endsection
@section('nav')
    Daftar Member & Supplier
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Supllier
    </li>
@endsection
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="buttons">

                    <button onclick="addForm('{{ route('supplier.store') }}')" class="btn btn-secondary rounded-pill"><i
                            data-feather="plus"></i>
                        Tambah</button>

                </div>
            </div>
        </section>
        <section class="section">
            <div class="card">
                <div class="card-header">Data Supplier</div>
                <div class="card-body table-responsive">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th width="20%"><i data-feather="settings"></i></th>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @includeIf('supplier.form')
@endsection

@push('scripts')
    <script>
        let table;

        $(function() {
            table = $('.table').DataTable({
                processing: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('supplier.data') }}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        sortable: false,
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'telepon'
                    },
                    {
                        data: 'alamat'
                    },
                    {
                        data: 'aksi',
                        searchable: false,
                        sortable: false,
                    },
                ]
            });

            $('#modal-form').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('#modal-form').attr('action'),
                            type: 'post',
                            data: $('#modal-form form').serialize()
                        })
                        .done((response) => {
                            $('#modal-form').modal('hide');
                            swal.fire('Success', 'Data Berhasil di Simpan', 'success')
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            swal.fire('Error', 'Data Gagal di Simpan', 'error')
                            return;
                        })
                }
            })
        });

        function addForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Tambah Supplier');

            $('#modal-form form')[0].reset();
            $('#modal-form').attr('action', url);
            $('#modal-form [name=_method]').val('post');
            $('#modal-form [name=nama]').focus();
        }

        function editForm(url) {
            $('#modal-form').modal('show');
            $('#modal-form .modal-title').text('Edit Supplier');

            $('#modal-form form')[0].reset();
            $('#modal-form').attr('action', url);
            $('#modal-form [name=_method]').val('put');
            $('#modal-form [name=nama]').focus();

            $.get(url)
                .done((response) => {
                    $('#modal-form [name=nama]').val(response.nama);
                    $('#modal-form [name=telepon]').val(response.telepon);
                    $('#modal-form [name=alamat]').val(response.alamat);
                })
                .fail((errors) => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }

        function deleteData(url) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu tidak bisa mengembalikan data ini",
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
                            table.ajax.reload();
                        })
                        .fail((errors) => {
                            swal.fire('Error', 'Tidak dapat menghapus data', 'error')
                            return;
                        });

                }
            })
            // if (confirm('Yakin ingin menghapus data terpilih?')) {
            //     $.post(url, {
            //             '_token': $('[name=csrf-token]').attr('content'),
            //             '_method': 'delete'
            //         })
            //         .done((response) => {
            //             swal.fire('Success', 'Behasil Menghapus Data', 'success')
            //             table.ajax.reload();
            //         })
            //         .fail((errors) => {
            //             swal.fire('Error', 'Tidak dapat menghapus data', 'error')
            //             return;
            //         });
            // }
        }
    </script>
@endpush
