@extends('layouts.master');

@section('title')
    Pengaturan Toko
@endsection
@section('nav')
    Pengaturan Toko
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Pengaturan Toko
    </li>
@endsection
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">

            </div>
        </section>
        <section class="section">
            <div class="card">
                <form action="{{ route('setting.update') }}" class="form-setting" method="post" data-toggle="validator"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-info alert-dismissible" style="display: none;">
                            {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                            <i class="bi bi-check-circle"></i> Perubahan berhasil disimpan
                        </div>
                        <div class="form-group row">
                            <label for="nama_perusahaan" class="col-lg-2 control-label">Nama Toko</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan"
                                    required autofocus>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telepon" class="col-lg-2 control-label">Telepon</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="telepon" id="telepon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-lg-2 control-label">Alamat</label>
                            <div class="col-lg-6">
                                <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_logo" class="col-lg-2 control-label">Logo Toko</label>
                            <div class="col-lg-4">
                                <input type="file" class="form-control" name="path_logo" id="path_logo"
                                    onchange="preview('.tampil-logo', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-logo"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="path_kartu_member" class="col-lg-2 control-label">Desain Kartu Member</label>
                            <div class="col-lg-4">
                                <input type="file" class="form-control" name="path_kartu_member" id="path_kartu_member"
                                    onchange="preview('.tampil-kartu-member', this.files[0], 250)">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-kartu-member"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                            <div class="col-lg-2">
                                <input type="number" class="form-control" name="diskon" id="diskon" required>
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>


                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-end btn-simpan"><i data-feather="save"></i>
                            Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
    @includeIf('supplier.form')
@endsection

@push('scripts')
    <script>
        $(function() {
            showData();

            $('.form-setting').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('.form-setting').attr('action'),
                            type: $('.form-setting').attr('method'),
                            data: new FormData($('.form-setting')[0]),
                            async: false,
                            processData: false,
                            contentType: false
                        })
                        .done(response => {
                            showData();
                            $('.alert').fadeIn();

                            setTimeout(() => {
                                $('.alert').fadeOut();
                            }, 3000);
                        })
                        .fail(errors => {
                            alert('Tidak dapat menyimpan data');
                            return;
                        });
                }
            });
        });

        function showData() {
            $.get('{{ route('setting.show') }}')
                .done(response => {
                    console.log(response)
                    $('[name=nama_perusahaan]').val(response.nama_perusahaan);
                    $('[name=telepon]').val(response.telepon);
                    $('[name=alamat]').val(response.alamat);
                    $('[name=diskon]').val(response.diskon);
                    $('title').text(response.nama_perusahaan + ' | Pengaturan Toko');


                    $('.tampil-logo').html(`<img src="{{ url('/') }}${response.path_logo}" width="150">`);
                    $('.tampil-kartu-member').html(
                        `<img src="{{ url('/') }}${response.path_kartu_member}" width="250">`);
                    $('[rel=icon]').attr('href', `{{ url('/') }}/${response.path_logo}`);
                })
                .fail(errors => {
                    alert('Tidak dapat menampilkan data');
                    return;
                });
        }
    </script>
@endpush
