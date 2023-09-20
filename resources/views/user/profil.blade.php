@extends('layouts.master')

@section('title')
    Edit profil
@endsection
@section('nav')
    Profil
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Edit Profil
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
                <form action="{{ route('user.updateProfil') }}" class="form-profil" method="post" data-toggle="validator"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-info alert-dismissible" style="display: none;">
                            {{-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> --}}
                            <i class="bi bi-check-circle"></i> Perubahan berhasil disimpan
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-lg-2 control-label">Nama Lengkap</label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="name" id="name" required autofocus
                                    value="{{ $profil->name }}">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="foto" class="col-lg-2 control-label">Foto Profil</label>
                            <div class="col-lg-4">
                                <input type="file" class="form-control" name="foto" id="foto"
                                    onchange="preview('.tampil-foto', this.files[0])">
                                <span class="help-block with-errors"></span>
                                <br>
                                <div class="tampil-foto">
                                    <img src="{{ url($profil->foto ?? '/') }}" width="150">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="old_password" class="col-lg-2 control-label">Password Lama</label>
                            <div class="col-lg-6">
                                <input type="password" name="old_password" id="old_password" class="form-control"
                                    minlength="6">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-lg-2 control-label">Password</label>
                            <div class="col-lg-6">
                                <input type="password" name="password" id="password" class="form-control" minlength="6">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password_confirmation" class="col-lg-2 control-label">
                                Konfirmasi Password</label>
                            <div class="col-lg-6">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" data-match="#password">
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
            $('#old_password').on('keyup', function() {
                if ($(this).val() != "") $('#password, #password_confirmation').attr('required', true);
                else $('#password, #password_confirmation').attr('required', false);
            });

            $('.form-profil').validator().on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                            url: $('.form-profil').attr('action'),
                            type: $('.form-profil').attr('method'),
                            data: new FormData($('.form-profil')[0]),
                            async: false,
                            processData: false,
                            contentType: false
                        })
                        .done(response => {
                            $('[name=name]').val(response.name);
                            $('.tampil-foto').html(
                                `<img src="{{ url('/') }}${response.foto}" width="200">`);
                            $('img-profil').attr('src', `{{ url('/') }}/${response.foto}`);
                            $('#namaku').text(response.name);
                            $('#namaku_bawah').text(response.name);
                            $('.alert').fadeIn();

                            setTimeout(() => {
                                $('.alert').fadeOut();
                            }, 3000);
                        })
                        .fail(errors => {
                            if (errors.status == 422) {
                                alert(errors.responseJSON);
                            } else {
                                alert('Tidak dapat menyimpan data');
                            }
                            return;
                        });
                }
            });
        });
    </script>
@endpush
