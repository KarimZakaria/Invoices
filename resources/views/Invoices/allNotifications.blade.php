@extends('layouts.master')
@section('title' , 'كل الاشعارات')
@section('css')
    @include('layouts.css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">كل الاشعارات</h4>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection

@section('content')
        <div class="main-notification-list Notification-scroll">
            <div id="unreadNotifications">
                @forelse(auth()->user()->unreadNotifications as $notification)
                    <a class="d-flex p-3 border-bottom mt-1" href="{{ route('Invoice_Details', $notification->data['id']) }}">
                        <div class="notifyimg bg-pink">
                            <i class="la la-file-alt text-white"></i>
                        </div>
                        <div class="mr-3">
                            <h5 class="notification-label mb-1">
                                {{ $notification->data['msg'] }} {{ $notification->data['user'] }}
                            </h5>
                            <div class="notification-subtext">{{ $notification->updated_at->diffForHumans() }}</div>
                        </div>
                        <div class="mr-auto" >
                            <i class="las la-angle-left text-left text-muted"></i>
                        </div>
                    </a>
                @empty
                    <h6 class="text-center mt-5 text-danger">عفوا لا توجد اي اشعارات جديده للقراءة</h6>
                @endforelse
            </div>
        </div>
    </div>
{{-- row closed --}}
</div>
{{-- container closed --}}
@endsection
