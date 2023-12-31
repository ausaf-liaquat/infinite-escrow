@extends('admin.layouts.app')

@section('panel')
    <select class="currency_exchange input-group-text bg--base text-black mb-4" style="color:black; background-color:white;"
        name="" id="amount_sym">

        <option value="NGN">NGN</option>
        <option value="USD">USD</option>
        <option value="USDC">USDC</option>
        <option value="BTC">BTC</option>
        <option value="ETH">ETH</option>
    </select>
    @if (@json_decode($general->sys_version)->version > systemDetails()['version'])
        <div class="row">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button
                                class="btn btn--dark float-right">@lang('Version')
                                {{ json_decode($general->sys_version)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->sys_version)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->sys_version)->message)
        <div class="row">
            @foreach (json_decode($general->sys_version)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row mb-none-30">
        <div class="col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['total_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Users')</span>
                    </div>
                    <a href="{{ route('admin.users.all') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow">
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['verified_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Verified Users')</span>
                    </div>
                    <a href="{{ route('admin.users.active') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow ">
                <div class="icon">
                    <i class="la la-envelope"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['email_unverified_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total Email Unverified Users')</span>
                    </div>

                    <a href="{{ route('admin.users.email.unverified') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow ">
                <div class="icon">
                    <i class="fas fa-sms"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount">{{ $widget['sms_unverified_users'] }}</span>
                    </div>
                    <div class="desciption">
                        <span class="text--small">@lang('Total SMS Unverified Users')</span>
                    </div>

                    <a href="{{ route('admin.users.sms.unverified') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <input type="hidden" id="total_escrow_amount" value="{{ $totalEscrows }}">
                        <span class="amount exchange_amount">{{ showAmount($totalEscrows) }}
                            {{ $general->cur_text }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Total Escrowed Amount')</span>
                    </div>
                    <a href="{{ route('admin.escrow.index') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow">
                <div class="icon">
                    <i class="fa fa-file-invoice-dollar"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <input type="hidden" id="escrow_fundAamount" value="{{ $escrowFund }}">
                        <span class="amount exchangeEscrow_fund">{{ showAmount($escrowFund) }}
                            {{ $general->cur_text }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Escrow Funded')</span>
                    </div>
                    <a href="{{ route('admin.escrow.index') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow">
                <div class="icon">
                    <i class="fa fa-times-circle"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <input type="hidden" value="{{ $cancelledEscrows }}" id="cancelledEscrows">
                        <span class="amount exhange_cancelledEscrows">{{ showAmount($cancelledEscrows) }}
                            {{ $general->cur_text }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Canceled Escrow')</span>
                    </div>

                    <a href="{{ route('admin.escrow.canceled') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--white b-radius--2 box-shadow">
                <div class="icon">
                    <i class="fa fa-spinner"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <input type="hidden" value="{{ $disputedEscrows }}" id="disputedEscrows">
                        <span class="amount exchange_disputedEscrows">{{ showAmount($disputedEscrows) }}
                            {{ $general->cur_text }}</span>
                    </div>
                    <div class="desciption">
                        <span>@lang('Disputed Escrow')</span>
                    </div>

                    <a href="{{ route('admin.escrow.disputed') }}"
                        class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">@lang('View All')</a>
                </div>
            </div>
        </div>
    </div><!-- row end-->



    <div class="row mt-50 mb-none-30">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Deposit & Withdraw Report')</h5>
                    <div id="apex-bar-chart"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-30">
            <div class="row mb-none-30">
                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__content">
                            <input type="hidden" id="totalDepositAmount"
                                value="{{ $payment['total_deposit_amount'] }}">
                            <h2 class="numbers exchange_totalDepositAmount">
                                {{ showAmount($payment['total_deposit_amount']) }}
                                {{ $general->cur_text }}</h2>
                            <p class="text--small">@lang('Total Deposit')</p>
                            <input type="hidden" id="totalDepositAmount_charge"
                                value="{{ $payment['total_deposit_charge'] }}">
                            <h2 class="numbers exchange_totalDepositAmount_charge">
                                <br>{{ showAmount($payment['total_deposit_charge']) }}
                                {{ $general->cur_text }}</h2>
                            <p class="text--small">@lang('Total Deposit Charge')</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__content">
                            <input type="hidden" id="totalWithdrawAmount"
                                value="{{ $paymentWithdraw['total_withdraw_amount'] }}">
                            <h2 class="numbers exchange_totalWithdrawAmount">
                                {{ showAmount($paymentWithdraw['total_withdraw_amount']) }}
                                {{ $general->cur_text }}</h2>
                            <p class="text--small">@lang('Total Withdraw')</p>
                            <input type="hidden" id="totalWithdrawAmount_charge"
                                value="{{ $paymentWithdraw['total_withdraw_charge'] }}">
                            <h2 class="numbers exchnage_totalWithdrawAmount_charge">
                                <br>{{ showAmount($paymentWithdraw['total_withdraw_charge']) }}{{ $general->cur_text }}
                            </h2>
                            <p class="text--small">@lang('Total Withdraw Charge')</p>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--primary  box--shadow2">
                            <i class="las la-cloud-download-alt"></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{ $payment['total_deposit_pending'] }}</h2>
                            <p class="text--small">@lang('Pending Deposit')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
                <div class="col-lg-6 col-sm-6 mb-30">
                    <div class="widget-three box--shadow2 b-radius--5 bg--white">
                        <div class="widget-three__icon b-radius--rounded bg--warning  box--shadow2">
                            <i class="las la-file-export"></i>
                        </div>
                        <div class="widget-three__content">
                            <h2 class="numbers">{{ $paymentWithdraw['total_withdraw_pending'] }}</h2>
                            <p class="text--small">@lang('Pending Withdrawals')</p>
                        </div>
                    </div><!-- widget-two end -->
                </div>
            </div>
        </div>
    </div><!-- row end -->

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Last 30 days Deposit History')</h5>
                    <div id="deposit-line"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Last 30 days Withdraw History')</h5>
                    <div id="withdraw-line"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser')</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS')</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country')</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>

    <script>
        "use strict";
        // apex-bar-chart js
        var options = {
            series: [{
                name: 'Total Deposit',
                data: [
                    @foreach ($months as $month)
                        {{ getAmount(@$depositsMonth->where('months', $month)->first()->depositAmount) }},
                    @endforeach
                ]
            }, {
                name: 'Total Withdraw',
                data: [
                    @foreach ($months as $month)
                        {{ getAmount(@$withdrawalMonth->where('months', $month)->first()->withdrawAmount) }},
                    @endforeach
                ]
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '50%',
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
                categories: @json($months),
            },
            yaxis: {
                title: {
                    text: "{{ __($general->cur_sym) }}",
                    style: {
                        color: '#7c97bb'
                    }
                }
            },
            grid: {
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "{{ __($general->cur_sym) }}" + val + " "
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
        chart.render();


        // apex-line chart
        var options = {
            chart: {
                height: 430,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: "Series 1",
                data: @json($withdrawals['per_day_amount']->flatten())
            }],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($withdrawals['per_day']->flatten())
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#withdraw-line"), options);

        chart.render();




        // apex-line chart
        var options = {
            chart: {
                height: 430,
                type: "area",
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    enabledSeries: [0],
                    top: -2,
                    left: 0,
                    blur: 10,
                    opacity: 0.08
                },
                animations: {
                    enabled: true,
                    easing: 'linear',
                    dynamicAnimation: {
                        speed: 1000
                    }
                },
            },
            colors: ['#00E396', '#0090FF'],
            dataLabels: {
                enabled: false
            },
            series: [{
                name: "Series 1",
                data: @json($deposits['per_day_amount']->flatten())
            }],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($deposits['per_day']->flatten())
            },
            grid: {
                padding: {
                    left: 5,
                    right: 5
                },
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#deposit-line"), options);

        chart.render();


        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });



        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_os_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_os_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });


        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.currency_exchange').change(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "get",
                    url: "{{ route('admin.currency.change') }}",
                    data: {
                        currency: $(this).val(),
                        totalEscrow: $('#total_escrow_amount').val(),
                        escrow_fund_amount: $('#escrow_fundAamount').val(),
                        cancelledEscrows: $('#cancelledEscrows').val(),
                        disputedEscrows: $('#disputedEscrows').val(),
                        totalDepositAmount: $('#totalDepositAmount').val(),
                        totalDepositAmount_charge: $('#totalDepositAmount_charge').val(),
                        totalWithdrawAmount: $('#totalWithdrawAmount').val(),
                        totalWithdrawAmount_charge: $('#totalWithdrawAmount_charge').val(),


                    },

                    success: function(res) {
                        $('.exchange_amount').empty();
                        $('.exchange_amount').html(`${res.data_totalEscrow} ${res.sym}`)
                        $('.exchangeEscrow_fund').empty();
                        $('.exchangeEscrow_fund').html(
                            `${res.data_exchangeEscrow_fund} ${res.sym}`)
                        $('.exhange_cancelledEscrows').empty();
                        $('.exhange_cancelledEscrows').html(
                            `${res.data_cancelledEscrows} ${res.sym}`)
                        $('.exchange_disputedEscrows').empty();
                        $('.exchange_disputedEscrows').html(
                            `${res.data_disputedEscrows} ${res.sym}`)
                        $('.exchange_totalDepositAmount').empty();
                        $('.exchange_totalDepositAmount').html(
                            `${res.totalDepositAmount.toLocaleString()} ${res.sym}`)
                        $('.exchange_totalDepositAmount_charge').empty();
                        $('.exchange_totalDepositAmount_charge').html(
                            `${res.totalDepositAmount_charge.toLocaleString()} ${res.sym}`)
                        $('.exchange_totalWithdrawAmount').empty();
                        $('.exchange_totalWithdrawAmount').html(
                            `${res.totalWithdrawAmount.toLocaleString()} ${res.sym}`)

                        $('.exchnage_totalWithdrawAmount_charge').empty();
                        $('.exchnage_totalWithdrawAmount_charge').html(
                            `${res.totalWithdrawAmount_charge.toLocaleString()} ${res.sym}`)
                    }
                });
            });
            $('.currency_exchange').trigger('change');
        });
    </script>
@endpush
