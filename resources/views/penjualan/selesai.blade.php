@extends('layouts.master');

@section('title')
    Transaksi Penjualan
@endsection
@section('nav')
    Kelola Transaksi
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Transaksi
    </li>
@endsection
@section('content')
    <div class="page-content">

        <section class="section">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body ">
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> Data transaksi telah disimpan.
                    </div>
                </div>
                <div class="card-footer">
                    <div class="buttons">
                        @if ($setting->tipe_nota == 1)
                            <a href="{{ url('/transaksi/nota-kecil/') }}" target="_blank"
                                class="btn icon icon-left btn-warning">
                                <i data-feather="file-text"></i> Cetak Struk</a>
                        @else
                            <button class="btn icon icon-left btn-warning"
                                onclick="notaBesar('{{ route('transaksi.nota_besar') }}', 'Nota Kecil')"><i
                                    data-feather="file-text"></i> Cetak
                                Struk</button>
                        @endif

                        <a href="{{ route('transaksi.baru') }}" class="btn icon icon-left btn-primary"><i
                                data-feather="plus-circle"></i>
                            Transaksi Baru</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @includeIf('penjualan.detail')
@endsection

@push('scripts')
    <script>
        function notaKecil(url) {
            .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }

        function notaBesar() {
            popupCenter(url, title, 720, 675);
        }

        // function popupCenter(url, title, w, h) {
        //     const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : window.screenX;
        //     const dualScreenTop = window.screenTop !== undefined ? window.screenTop : window.screenY;

        //     const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
        //         .documentElement.clientWidth : screen.width;
        //     const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
        //         .documentElement.clientHeight : screen.height;

        //     const systemZoom = width / window.screen.availWidth;
        //     const left = (width - w) / 2 / systemZoom + dualScreenLeft
        //     const top = (height - h) / 2 / systemZoom + dualScreenTop
        //     const newWindow = window.open(url, title,
        //         `
    //         scrollbars=yes,
    //         width=${w / systemZoom}, 
    //         height=${h / systemZoom}, 
    //         top=${top}, 
    //         left=${left}
    //         `
        //     )

        //     if (window.focus) newWindow.focus();
        // }
    </script>
@endpush
