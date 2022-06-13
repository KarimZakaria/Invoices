@extends('layouts.master')
@section('title')
    قسم {{ $category->category_name}}
@endsection
@section('css')
    @include('layouts.css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ $category->category_name }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات الخاصة</span>
            </div>
            <p class="mt-2">{{ $category->description }}</p>
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
                        <a class="modal-effect btn btn-outline-primary" data-effect="effect-scale"
                            data-toggle="modal" href="#exampleModal"><i class="fa fa-plus ml-2"></i>اضافة منتج للقسم
                        </a>
                        <a class="modal-effect btn btn-primary" data-effect="effect-scale" href="{{ route('categories.index') }}">العودة للأقسام <i class="fas fa-arrow-circle-left mr-1"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                            <thead>
                                <tr class="text-center">
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">وصف المنتج</th>
                                    <th class="border-bottom-0">سعر المنتج</th>
                                    <th class="border-bottom-0">العلميات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category->product as $product)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>
                                            @if($product->description != null)
                                                {{ $product->description }}
                                            @else
                                                <span class="text-danger"> لا يوجد وصف للمنتج </span>
                                            @endif
                                        </td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            <button class="btn btn-outline-success btn-sm"
                                            data-product_name="{{ $product->product_name }}"
                                            data-id="{{ $product->id }}"
                                            data-category_name="{{ $product->category->category_name }}"
                                            data-description="{{ $product->description }}"
                                            data-price="{{ $product->price }}" data-toggle="modal"
                                            data-target="#edit_Product">تعديل</button>

                                            <button class="btn btn-outline-danger btn-sm " data-id="{{ $product->id }}"
                                            data-product_name="{{ $product->product_name }}"
                                            data-id = "{{ $product->id }}"
                                            data-toggle="modal"
                                            data-target="#modaldemo9">حذف</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create New Product --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم المنتج</label>
                                <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" class="form-control @error('product_name') is-invalid @enderror">
                            </div>
                            @error('product_name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="price">سعر المنتج</label>
                                <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror">
                            </div>
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref"> القسم التابع للمنتج</label>
                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="{{ $category->id }}">{{ $category->category_name}}</option>
                                </select>
                            </div>
                            @error('category_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">الوصف</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{old('description') }}</textarea>
                            </div>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End of Creating --}}

        {{-- See If There are Products Or Not  --}}
        <!-- Start Edit Product -->
        @if($category->product->count() > 0)
            <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('products.update' , $product->id)}}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="modal-body">

                                <div class="form-group">
                                    <label for="title">اسم المنتج :</label>

                                    <input type="hidden" class="form-control" name="id" id="id" value="">
                                    <input type="text" class="form-control" name="product_name" id="product_name">
                                </div>

                                <div class="form-group">
                                    <label for="price">السعر</label>
                                    <input type="number" class="form-control" name="price" id="price">
                                </div>

                                <div class="form-group">
                                    <label for="des">ملاحظات :</label>
                                    <textarea name="description" cols="20" rows="5" id='description'
                                        class="form-control"></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End of Editing Product -->

            {{-- Start Delete Product --}}
            <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">حذف المنتج</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('products.destroy' , $product->id)}}" method="post">
                            @method("DELETE")
                            @csrf
                            <div class="modal-body">
                                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                <input type="hidden" name="id" id="id" value="">
                                <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- End Of Deleting Product --}}
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
<script>
    $('#edit_Product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var product_name = button.data('product_name')
        var category_name = button.data('category_name')
        var price = button.data('price')
        var id = button.data('id')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #category_name').val(category_name);
        modal.find('.modal-body #description').val(description);
        modal.find('.modal-body #price').val(price)
        modal.find('.modal-body #id').val(id);
    })

    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
    })
</script>
@endsection

