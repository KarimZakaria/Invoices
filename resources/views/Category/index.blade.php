@extends('layouts.master')
@section('title' , 'الأقسام')
@section('css')
    @include('layouts.css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الأقسام</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
            <!-- row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <div class="col-sm-6 col-md-4 col-xl-3">
                                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة قسم</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">اسم القسم</th>
                                            <th class="border-bottom-0">الوصف</th>
                                            <th class="border-bottom-0">اضيف بواسطة</th>
                                            <th class="border-bottom-0">العلميات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td><a href="{{ route('categories.show', $category->id) }}"> {{ $category->category_name }} </a></td>
                                                <td>
                                                    @if( $category->description == null )
                                                        <strong class="text-danger">لا يوجد وصف للقسم</strong>
                                                    @else
                                                        {{ $category->description }}
                                                    @endif
                                                </td>
                                                <td>{{ $category->created_by }}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="{{ route('categories.show', $category->id) }}" title="رؤيه القسم">
                                                        <i class="las la-eye"></i>
                                                    </a>

                                                    <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                       data-id="{{ $category->id }}" data-category_name="{{ $category->category_name }}"
                                                       data-description="{{ $category->description }}" data-toggle="modal" href="#exampleModal2"
                                                       title="تعديل"><i class="las la-pen"></i></a>

                                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                       data-id="{{ $category->id }}" data-category_name="{{ $category->category_name }}" data-toggle="modal"
                                                       href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Basic modal Create New Category-->
                <div class="modal" id="modaldemo8">
                    <div class="modal-dialog" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                    type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('categories.store') }}" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">اسم القسم</label>
                                            <input type="text"  id="category_name" name="category_name" value="{{old('category_name')}}" class="form-control @error('category_name') is-invalid @enderror">
                                        </div>
                                        @error('category_name')
                                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">الوصف</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                        </div>
                                        @error('description')
                                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                                        @enderror

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Basic modal -->

                {{-- See If There are Categories Or Not  --}}
                @if ($categories->count() > 0 )
                    <!-- Basic modal Edit Category-->
                    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{route('categories.update' , $category->id)}}" method="post" autocomplete="off">
                                        @method('PATCH')
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="id" value="">
                                            <label for="recipient-name" class="col-form-label">اسم القسم:</label>
                                            <input class="form-control" name="category_name" id="category_name" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">الوصف:</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">تاكيد</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- End Edit Modal --}}

                    {{-- Start Deleting Category --}}
                    <div class="modal" id="modaldemo9">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title">حذف قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="{{route('categories.destroy' , $category->id)}}" method="POST">
                                    @method("DELETE")
                                    @csrf
                                    <div class="modal-body">
                                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                        <input type="hidden" name="id" id="id" value="">
                                        <input class="form-control" name="category_name" id="category_name" type="text" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- End Of Deleting Category --}}
                @endif

            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    @include('layouts.js')
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
    {{-- Modal Edit Get Value For Each Input --}}
    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var category_name = button.data('category_name')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #category_name').val(category_name);
            modal.find('.modal-body #description').val(description);
        })
    </script>

    <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var category_name = button.data('category_name')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #category_name').val(category_name);
        })
    </script>
@endsection
