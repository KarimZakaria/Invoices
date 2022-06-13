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
            <table>
                <thead>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>اسم المستخدم :</td>
                        <td> {{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td>البريد الالكتروني :</td>
                        <td> {{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <td>حالة المستخدم :</td>
                        <td>
                            @if ($profile->status == 'مفعل')
                            <span class="label text-success text-center">
                                {{ $profile->status }}
                            </span>
                            @else
                            <span class="label text-danger text-center">
                                <div class="dot-label bg-danger ml-1"></div>{{ $profile->status }}
                            </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>الخواص :</td>
                        <td>
                            @if (!empty($profile->getRoleNames()))
                            @foreach ($profile->getRoleNames() as $roles)
                            <label class="badge badge-success">{{ $roles }}</label>
                            @endforeach
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>صوره الملف الشخصي :</td>
                        <td>
                            <img class="img-fluid" width="60px" height="50px" src="{{ asset('Profile/images/'. $profile->image ) }}" alt="{{ $profile->name }}">
                        </td>
                    </tr>
                </tbody>
            </table>

            <a class="modal-effect btn btn-info mt-2" data-effect="effect-scale"
                data-id="{{ $profile->id }}"
                data-name="{{ $profile->name }}"
                data-email="{{ $profile->email }}"
                data-image="{{ $profile->image}}"
                data-toggle="modal" href="#exampleModal2"
                title="تعديل"><i class="fa fa-edit"></i> تعديل البيانات
            </a>
        </div>

        <!-- Basic modal Edit Category-->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل الملف الشخصي</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('UpdateProfile' , $profile->id)}}" method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">اسم المستخدم:</label>
                                <input class="form-control" name="name" id="name" type="text">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">البريدالالكتروني:</label>
                                <input class="form-control" name="email" id="email" type="email">
                            </div>
                            <div class="form-group">
                                <img class="img-fluid" width="60px" height="50px" src="{{ asset('Profile/images/'. $profile->image ) }}">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">الصورة الشخصية: </label>
                                <input class="form-control" name="image" id="image" type="file">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">تحديث</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Edit Modal --}}
    </div>
    {{-- End row --}}
</div>
{{-- End container --}}
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
