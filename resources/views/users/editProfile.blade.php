@extends('layouts.master')
@section('css')
    @include('layouts.css')
@section('title')
    الملف الشخصي
@stop

<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الملف الشخصي</h4>
        </div>
    </div>
</div>
@endsection

@section('content')
        <div class="table table-responsive">
            <form action="{{route('UpdateProfile' , $user->id)}}" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" value="">
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">اسم المستخدم:</label>
                    <input class="form-control" name="name" id="name" type="text" value="{{ $user->name }}">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">البريدالالكتروني:</label>
                    <input class="form-control" name="email" id="email" type="email" value="{{ $user->email }}">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">حالة الملف الشخصي:</label>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label">الصورة الشخصية: </label>
                    <img class="img-fluid" width="60px" height="50px" src="{{ asset('profile/images/'. $user->image) }}">
                </div>
                <div class="form-group">
                    <label for="{{ $user->image }}">تعديل الصورة الشخصية :</label>
                    <input class="form-control" name="image" id="image" type="file">
                </div>
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> تحديث المعلومات </button>
            </form>

        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var email = button.data('email')
            var image = button.data('image')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #email').val(email);
            modal.find('.modal-body #image').val();
        })
    </script>
@endsection


