@extends('layouts.master')

@section('title')
    Dashboard
@endsection
@section('nav')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active" aria-current="page">
        Dashboard
    </li>
@endsection
@section('content')
    <div class="col-12 col-lg-9">
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldPaper"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">
                                    Penjualan Hari Ini
                                </h6>
                                <h6 class="font-extrabold mb-0">{{ $penjualan_hariIni }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldUser"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">
                                    Pelanggan Hari Ini
                                </h6>
                                <h6 class="font-extrabold mb-0">{{ $pelanggan }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldWallet"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">
                                    Profit Hari Ini
                                </h6>
                                <h6 class="font-extrabold mb-0">{{ $total_profit }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon red mb-2">
                                    <i class="iconly-boldBuy"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Total Penjualan Hari Ini</h6>
                                <h6 class="font-extrabold mb-0">{{ $total_penjualan }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-7">
                <div class="row">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Grafik Pendapatan Bulan ini</h4>
                                <h6>Periode: {{ $tanggalAwalBulan }} - {{ $tanggalAkhirBulan }}</h6>
                            </div>
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-13 col-lg-5">


                <div class="card">
                    <div class="card-header">
                        <h4>Produk Terlaris Bulan Ini</h4>
                    </div>
                    <div class="card-body">
                        <div id="produk_top"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        var totalPendapatan = @json($totalPendapatan);

        var options = {
            chart: {
                type: 'bar',
                height: 350,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['@json($tanggalAwalBulan) - @json($tanggalAkhirBulan)'],
            },
            series: [{
                name: 'Total Pendapatan (IDR)',
                data: [totalPendapatan]
            }],
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector('#chart'), options);
        chart.render();
    </script>
    {{-- <script>
        var produkTerlaris = @json($produkTerlaris);

        // Pastikan produkTerlaris adalah array yang berisi objek-objek Penjualan

        var options = {
            chart: {
                type: 'pie',
                width: '100%',
                height: '300px',
            },
            labels: produkTerlaris.map(function(item) {
                return item.produk.nama_produk;
            }),
            series: @json($series),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector('#produk_top'), options);
        chart.render();
    </script> --}}
    {{-- <script>
        var produkTerlaris = @json($produkTerlaris);

        // Pastikan produkTerlaris adalah array yang berisi objek-objek Penjualan

        // Hitung total penjualan bulan ini
        var totalPenjualan = produkTerlaris.reduce(function(total, item) {
            return total + item.total_terjual;
        }, 0);

        // Siapkan data chart
        var data = produkTerlaris.map(function(item) {
            var persentase = (item.total_terjual / totalPenjualan) * 100;
            return {
                labels: item.produk.nama_produk,
                value: persentase,
            };
        });

        var options = {
            chart: {
                type: 'pie',
                width: '100%',
                height: '300px',
            },
            labels: data.map(function(item) {
                return item.labels;
            }),
            series: data.map(function(item) {
                return item.value;
            }),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector('#produk_top'), options);
        chart.render();
    </script> --}}
    {{-- <script>
        var produkTerlaris = @json($produkTerlaris);

        // Pastikan produkTerlaris adalah array yang berisi objek-objek Penjualan

        // Hitung total penjualan bulan ini dari database
        var totalPenjualan = produkTerlaris.reduce(function(total, item) {
            return total + item.total_terjual;
        }, 0);

        // Siapkan data chart dengan persentase dan total terjual
        var data = produkTerlaris.map(function(item) {
            var persentase = (item.total_terjual / totalPenjualan) * 100;
            return {
                labels: item.produk.nama_produk,
                value: item.total_terjual,
                persentase: persentase.toFixed(2) + '%'
            };
        });

        var options = {
            chart: {
                type: 'pie',
                width: '100%',
                height: '300px',
            },
            labels: data.map(function(item) {
                return item.labels + ' (' + item.persentase + ')';
            }),
            series: data.map(function(item) {
                return item.value;
            }),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector('#produk_top'), options);
        chart.render();
    </script> --}}
    <script>
        var produkTerlaris = @json($produkTerlaris);

        // Pastikan produkTerlaris adalah array yang berisi objek-objek Penjualan

        // Siapkan data chart
        var data = produkTerlaris.map(function(item) {
            return {
                labels: item.produk.nama_produk,
                value: item.total_terjual
            };
        });

        var options = {
            chart: {
                type: 'pie',
                width: '100%',
                height: '300px',
            },
            labels: data.map(function(item) {
                return item.labels;
            }),
            series: data.map(function(item) {
                return item.value;
            }),
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector('#produk_top'), options);
        chart.render();
    </script>
@endpush
