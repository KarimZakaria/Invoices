@extends('layouts.master')

@section('title' , 'الرئيسية-لوحة التحكم')

@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">أهلا {{ Auth::user()->name }}</h2>
                <span>تم تسجيل دخولك  {{ Auth::user()->created_at->diffForHumans() }} </span>
                <p class="mg-b-0">لوحة التحكم الخاصة بالفواتير</p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">Customer Ratings</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>
            <div>
                <label class="tx-13">عدد الفواتير</label>
                <h5><a href="{{ route('invoices.index') }}">{{ App\Invoice::count() }}</a></h5>
            </div>
            <div>
                <label class="tx-13">الفواتير المدفوعه</label>
                <h5><a href="{{ route('PaidInvoices') }}">{{ App\Invoice::where('status_value', 1)->count() }}</a></h5>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
            <!-- row -->
            <div class="row row-sm">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                        <a href="{{ route('invoices.index') }}">
                            <div class="card overflow-hidden sales-card bg-primary-gradient">
                                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                    <div class="">
                                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
                                    </div>
                                    <div class="pb-0 mt-0">
                                        <div class="d-flex">
                                            <div class="">
                                                <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ number_format($paidInvoices,2) }}</h4>
                                                <p class="mb-0 tx-12 text-white op-7">+ {{ $weeklyInvoices->count() }} فواتير اسبوعية جديدة</p>
                                            </div>
                                            <span class="float-right my-auto mr-auto">
                                                <i class="fas fa-arrow-circle-up text-white"></i>
                                                <span class="text-white op-7">
                                                    @if(App\Invoice::count() > 0)
                                                        {{ number_format(App\Invoice::count() / App\Invoice::count() *100, 2) }} %
                                                    @else
                                                        0%
                                                    @endif
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                            </div>
                        </a>
                    </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <a href="{{ route('PaidInvoices') }}">
                        <div class="card overflow-hidden sales-card bg-danger-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ App\Invoice::where('status_value', 1)->count() }}</h4>
                                            <p class="mb-0 tx-12 text-white op-7"> + {{ $weeklyPaid->count() }} فواتير اسبوعية مدفوعة</p>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="fas fa-arrow-circle-down text-white"></i>
                                            <span class="text-white op-7">
                                                @if(App\Invoice::count() > 0)
                                                    {{ number_format(App\Invoice::where('status_value', 1)->count() / App\Invoice::count() *100, 2) }} %
                                                @else
                                                    0%
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <a href="{{ route('unPaidInvoices') }}">
                        <div class="card overflow-hidden sales-card bg-success-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">الفواتير غير المدفوعة</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ App\Invoice::where('status_value',2)->count() }}</h4>
                                            <p class="mb-0 tx-12 text-white op-7">+ {{$weeklyUnPaid->count()}} اسبوعية غير مدفوعة</p>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="fas fa-arrow-circle-up text-white"></i>
                                            <span class="text-white op-7">
                                                @if(App\Invoice::count() > 0)
                                                    {{ number_format(App\Invoice::where('status_value', 2)->count() / App\Invoice::count() *100, 2) }} %
                                                @else
                                                    0%
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                    <a href="{{ route('PartialPaidInvoices') }}">
                        <div class="card overflow-hidden sales-card bg-warning-gradient">
                            <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                                <div class="">
                                    <h6 class="mb-3 tx-12 text-white">المدفوعة جزئيا</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <div class="">
                                            <h4 class="tx-20 font-weight-bold mb-1 text-white">{{ App\Invoice::where('status_value', 3)->count() }}</h4>
                                            <p class="mb-0 tx-12 text-white op-7">+ {{$partialPaid->count()}} فواتير مدفوعة جزئيا جديدة</p>
                                        </div>
                                        <span class="float-right my-auto mr-auto">
                                            <i class="fas fa-arrow-circle-down text-white"></i>
                                            <span class="text-white op-7">
                                                @if(App\Invoice::count() > 0)
                                                    {{ number_format(App\Invoice::where('status_value', 3)->count() / App\Invoice::count() *100, 2) }} %
                                                @else
                                                    0%
                                                @endif
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- row closed -->

            <!-- row opened -->
            <div class="row row-sm">
                <div class="col-md-12 col-lg-12 col-xl-7">
                    <div class="card">
                        <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">حالة الفواتير بيانيا ({{ \App\Invoice::count()}} فواتير)</h4>
                                <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                            <p class="tx-12 text-muted mb-0">حالة الفواتير بالنسبه المئوية الشكل الاول بيانيا</p>
                        </div>
                        <div class="card-body">
                            <div style="width: 93%">
                                {!! $chartjs->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-5">
                    <div class="card card-dashboard-map-one">
                        <label class="main-content-label">الحالة البيانية للفواتير ({{ \App\Invoice::count()}} فواتير) </label>
                        <span class="d-block mg-b-20 text-muted tx-12">الشكل البياني الثاني لحالة الفواتير </span>
                        <div class="card-body w-100" >
                            <div>
                                {!! $chartjs2->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row closed -->

            <!-- row opened -->
            <div class="row row-sm">
                <div class="col-xl-4 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header pb-1">
                            <h3 class="card-title mb-2">Recent Customers</h3>
                            <p class="tx-12 mb-0 text-muted">A customer is an individual or business that purchases the goods service has evolved to include real-time</p>
                        </div>
                        <div class="card-body p-0 customers mt-1">
                            <div class="list-group list-lg-group list-group-flush">
                                <div class="list-group-item list-group-item-action" href="#">
                                    <div class="media mt-0">
                                        <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/3.jpg')}}" alt="Image description">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center">
                                                <div class="mt-0">
                                                    <h5 class="mb-1 tx-15">Samantha Melon</h5>
                                                    <p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-success ml-2">Paid</span></p>
                                                </div>
                                                <span class="mr-auto wd-45p fs-16 mt-2">
                                                    <div id="spark1" class="wd-100p"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item list-group-item-action" href="#">
                                    <div class="media mt-0">
                                        <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/11.jpg')}}" alt="Image description">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center">
                                                <div class="mt-1">
                                                    <h5 class="mb-1 tx-15">Jimmy Changa</h5>
                                                    <p class="mb-0 tx-13 text-muted">User ID: #1234 <span class="text-danger ml-2">Pending</span></p>
                                                </div>
                                                <span class="mr-auto wd-45p fs-16 mt-2">
                                                    <div id="spark2" class="wd-100p"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item list-group-item-action" href="#">
                                    <div class="media mt-0">
                                        <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/17.jpg')}}" alt="Image description">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center">
                                                <div class="mt-1">
                                                    <h5 class="mb-1 tx-15">Gabe Lackmen</h5>
                                                    <p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-danger ml-2">Pending</span></p>
                                                </div>
                                                <span class="mr-auto wd-45p fs-16 mt-2">
                                                    <div id="spark3" class="wd-100p"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item list-group-item-action" href="#">
                                    <div class="media mt-0">
                                        <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/15.jpg')}}" alt="Image description">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center">
                                                <div class="mt-1">
                                                    <h5 class="mb-1 tx-15">Manuel Labor</h5>
                                                    <p class="mb-0 tx-13 text-muted">User ID: #1234<span class="text-success ml-2">Paid</span></p>
                                                </div>
                                                <span class="mr-auto wd-45p fs-16 mt-2">
                                                    <div id="spark4" class="wd-100p"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item list-group-item-action br-br-7 br-bl-7" href="#">
                                    <div class="media mt-0">
                                        <img class="avatar-lg rounded-circle ml-3 my-auto" src="{{URL::asset('assets/img/faces/6.jpg')}}" alt="Image description">
                                        <div class="media-body">
                                            <div class="d-flex align-items-center">
                                                <div class="mt-1">
                                                    <h5 class="mb-1 tx-15">Sharon Needles</h5>
                                                    <p class="b-0 tx-13 text-muted mb-0">User ID: #1234<span class="text-success ml-2">Paid</span></p>
                                                </div>
                                                <span class="mr-auto wd-45p fs-16 mt-2">
                                                    <div id="spark5" class="wd-100p"></div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-header pb-1">
                            <h3 class="card-title mb-2">Sales Activity</h3>
                            <p class="tx-12 mb-0 text-muted">Sales activities are the tactics that salespeople use to achieve their goals and objective</p>
                        </div>
                        <div class="product-timeline card-body pt-2 mt-1">
                            <ul class="timeline-1 mb-0">
                                <li class="mt-0"> <i class="ti-pie-chart bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Products</span> <a href="#" class="float-left tx-11 text-muted">3 days ago</a>
                                    <p class="mb-0 text-muted tx-12">1.3k New Products</p>
                                </li>
                                <li class="mt-0"> <i class="mdi mdi-cart-outline bg-danger-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Total Sales</span> <a href="#" class="float-left tx-11 text-muted">35 mins ago</a>
                                    <p class="mb-0 text-muted tx-12">1k New Sales</p>
                                </li>
                                <li class="mt-0"> <i class="ti-bar-chart-alt bg-success-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Toatal Revenue</span> <a href="#" class="float-left tx-11 text-muted">50 mins ago</a>
                                    <p class="mb-0 text-muted tx-12">23.5K New Revenue</p>
                                </li>
                                <li class="mt-0"> <i class="ti-wallet bg-warning-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Toatal Profit</span> <a href="#" class="float-left tx-11 text-muted">1 hour ago</a>
                                    <p class="mb-0 text-muted tx-12">3k New profit</p>
                                </li>
                                <li class="mt-0"> <i class="si si-eye bg-purple-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Customer Visits</span> <a href="#" class="float-left tx-11 text-muted">1 day ago</a>
                                    <p class="mb-0 text-muted tx-12">15% increased</p>
                                </li>
                                <li class="mt-0 mb-0"> <i class="icon-note icons bg-primary-gradient text-white product-icon"></i> <span class="font-weight-semibold mb-4 tx-14 ">Customer Reviews</span> <a href="#" class="float-left tx-11 text-muted">1 day ago</a>
                                    <p class="mb-0 text-muted tx-12">1.5k reviews</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h3 class="card-title mb-2">Recent Orders</h3>
                            <p class="tx-12 mb-0 text-muted">An order is an investor's instructions to a broker or brokerage firm to purchase or sell</p>
                        </div>
                        <div class="card-body sales-info ot-0 pt-0 pb-0">
                            <div id="chart" class="ht-150"></div>
                            <div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
                                <div class="col-md-6 col">
                                    <p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>Delivered</p>
                                    <h3 class="mb-1">5238</h3>
                                    <div class="d-flex">
                                        <p class="text-muted ">Last 6 months</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col">
                                    <p class="mb-0 d-flex"><span class="legend bg-info brround"></span>Cancelled</p>
                                        <h3 class="mb-1">3467</h3>
                                    <div class="d-flex">
                                        <p class="text-muted">Last 6 months</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center pb-2">
                                        <p class="mb-0">Total Sales</p>
                                    </div>
                                    <h4 class="font-weight-bold mb-2">$7,590</h4>
                                    <div class="progress progress-style progress-sm">
                                        <div class="progress-bar bg-primary-gradient wd-80p" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-4 mt-md-0">
                                    <div class="d-flex align-items-center pb-2">
                                        <p class="mb-0">Active Users</p>
                                    </div>
                                    <h4 class="font-weight-bold mb-2">$5,460</h4>
                                    <div class="progress progress-style progress-sm">
                                        <div class="progress-bar bg-danger-gradient wd-75" role="progressbar"  aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row close -->

            <!-- row opened -->
            <div class="row row-sm row-deck">
                <div class="col-md-12 col-lg-4 col-xl-4">
                    <div class="card card-dashboard-eight pb-2">
                        <h6 class="card-title">Your Top Countries</h6><span class="d-block mg-b-10 text-muted tx-12">Sales performance revenue based by country</span>
                        <div class="list-group">
                            <div class="list-group-item border-top-0">
                                <i class="flag-icon flag-icon-us flag-icon-squared"></i>
                                <p>United States</p><span>$1,671.10</span>
                            </div>
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-nl flag-icon-squared"></i>
                                <p>Netherlands</p><span>$1,064.75</span>
                            </div>
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-gb flag-icon-squared"></i>
                                <p>United Kingdom</p><span>$1,055.98</span>
                            </div>
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-ca flag-icon-squared"></i>
                                <p>Canada</p><span>$1,045.49</span>
                            </div>
                            <div class="list-group-item">
                                <i class="flag-icon flag-icon-in flag-icon-squared"></i>
                                <p>India</p><span>$1,930.12</span>
                            </div>
                            <div class="list-group-item border-bottom-0 mb-0">
                                <i class="flag-icon flag-icon-au flag-icon-squared"></i>
                                <p>Australia</p><span>$1,042.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 col-xl-8">
                    <div class="card card-table-two">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title mb-1">قائمه باخر الفواتير المضافة</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <span class="tx-12 tx-muted mb-3 ">قامئه اخر خمس فواتير تم اضافتها </span>
                        <div class="table-responsive country-table">
                            <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                                <thead>
                                    <tr>
                                        <th class="wd-lg-25p tx-right">تاريخ الاضافه</th>
                                        <th class="wd-lg-25p">رقم الفاتورة</th>
                                        <th class="wd-lg-25p tx-right">المنتج</th>
                                        <th class="wd-lg-25p tx-right">القسم</th>
                                        <th class="wd-lg-25p tx-right">الحالة</th>
                                        <th class="wd-lg-25p tx-right">المزيد</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lastFiveInvoices as $last)
                                        <tr>
                                            <td>{{ $last->invoice_date }}</td>
                                            <td class="tx-right tx-medium tx-inverse">{{ $last->invoice_number }}</td>
                                            <td class="tx-right tx-medium tx-inverse">{{$last->product}}</td>
                                            <td class="tx-right tx-medium tx-inverse">{{$last->category->category_name}}</td>
                                            <td class="tx-right tx-medium tx-danger">
                                                @if($last->status == "مدفوعة")
                                                    <span class="badge badge-primary">{{$last->status}}</span>
                                                @elseif($last->status == "غير مدفوعه")
                                                    <span class="badge badge-danger">{{$last->status}}</span>
                                                @elseif($last->status == "مدفوعة جزئيا")
                                                    <span class="badge badge-warning">{{$last->status}}</span>
                                                @endif
                                            </td>
                                            <td class="tx-right tx-medium tx-danger">
                                                <a class="btn btn-primary btn-sm" href="{{ route('Invoice_Details', $last->id) }}">المعلومات</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <h6 class="text-center">لا يوجد فواتير مضافة</h6>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>
@endsection
