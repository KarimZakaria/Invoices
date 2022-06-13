@extends('layouts.master')
@section('title')
    تعديل الفاتورة {{$invoice->id}}
@endsection
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل فاتورة {{ $invoice->id }} </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
             <!-- row -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('invoices.update', $invoice->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                            @method('PATCH')
                            @csrf
                                <input type="hidden" name="id" value="{{ $invoice->id }}">
                                {{-- 1 --}}
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">رقم الفاتورة</label>
                                        <input type="text" class="form-control" id="inputName" name="invoice_number"
                                            value="{{ $invoice->invoice_number }}" title="يرجي ادخال رقم الفاتورة" required>
                                    </div>

                                    <div class="col">
                                        <label>تاريخ الفاتورة</label>
                                        <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                            type="text" value="{{ $invoice->invoice_date }}" required>
                                    </div>

                                    <div class="col">
                                        <label>تاريخ الاستحقاق</label>
                                        <input class="form-control fc-datepicker" name="due_date" placeholder="YYYY-MM-DD"
                                            value="{{ $invoice->due_date }}" type="text" required>
                                    </div>

                                </div>

                                {{-- 2 --}}
                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">القسم</label>
                                        <select name="category_id" class="form-control SlectBox" onclick="console.log($(this).val())">
                                            <!--placeholder-->
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @if($category->id == $invoice->category_id) selected @endif> {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col">
                                        <label for="inputName" class="control-label">المنتج</label>
                                        <select id="product" name="product" class="form-control">
                                            <option value="{{ $invoice->product}}"> {{ $invoice->product }}</option>
                                        </select>
                                    </div>

                                    <div class="col">
                                        <label for="inputName" class="control-label">مبلغ التحصيل</label>
                                        <input type="number" class="form-control" id="inputName" name="Amount_collection" value="{{ $invoice->Amount_collection }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                    </div>
                                </div>


                                {{-- 3 --}}

                                <div class="row">

                                    <div class="col">
                                        <label for="inputName" class="control-label">مبلغ العمولة</label>
                                        <input type="number" class="form-control form-control-lg" id="Amount_Commission" value="{{ $invoice->Amount_Commission }}"
                                            name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            required>
                                    </div>

                                    <div class="col">
                                        <label for="inputName" class="control-label">الخصم</label>
                                        <input type="number" class="form-control form-control-lg" id="discount" name="discount"
                                            value="{{ $invoice->discount }}" title="يرجي ادخال مبلغ الخصم "
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                            value=0 required>
                                    </div>

                                    <div class="col">
                                        <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                        <select name="rat_vat" id="rat_vat" class="form-control" onchange="myFunction()">
                                            <!--placeholder-->
                                            <option @if(old('rat_vat', $invoice->rat_vat) == '5%') selected @endif>
                                                5%
                                            </option>
                                            <option @if(old('rat_vat', $invoice->rat_vat) == '10%') selected @endif>
                                                10%
                                            </option>
                                        </select>
                                    </div>

                                </div>

                                {{-- 4 --}}

                                <div class="row">
                                    <div class="col">
                                        <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                        <input type="text" class="form-control" id="vat_value" name="vat_value" value="{{ $invoice->vat_value }}" readonly>
                                    </div>

                                    <div class="col">
                                        <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                        <input type="text" class="form-control" id="total" name="total" value="{{ $invoice->total }}" readonly>
                                    </div>
                                </div>

                                {{-- 5 --}}
                                <div class="row">
                                    <div class="col">
                                        <label for="exampleTextarea">ملاحظات</label>
                                        <textarea class="form-control" id="exampleTextarea" name="note" rows="3">{{ $invoice->note }}</textarea>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- row closed -->
        </div>
        <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

    <script>
        $(document).ready(function() {
            $('select[name="category_id"]').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: "{{ URL::to('category') }}/" + categoryId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>

    {{-- Start Calcualtions  --}}
    <script>
        function myFunction()
        {
            let Amount_Commission   = parseFloat(document.getElementById('Amount_Commission').value); // مبلغ العمولة
            let discount            = parseFloat(document.getElementById('discount').value); // الخصم
            let rat_vat            = parseFloat(document.getElementById('rat_vat').value); // نسبه الضريبه
            let vat_value           = parseFloat(document.getElementById('vat_value').value); // قيمه الاضافه من الضريبه

            let Amount_Commission2  = Amount_Commission - discount ; // العموله ما بعد الخصم

            if (typeof Amount_Commission === undefined || !Amount_Commission)
            {
                alert('يرجي ادخال مبلغ العموله اولا ') ;
            }
            else
            {
                // خصم النسبه المئويه للضريبه للعموله الخاصه من مبلغ التحصيل
                let Rate_Discount   = Amount_Commission2 * rat_vat / 100;
                let Final_Value     = parseFloat(Amount_Commission2 - Rate_Discount);

                Final_Rate    = parseFloat(Rate_Discount).toFixed(2);
                Final_Resault = parseFloat(Final_Value).toFixed(2);

                document.getElementById('vat_value').value = Final_Rate ;
                document.getElementById('total').value     = Final_Resault ;
            }
        }
    </script>
@endsection
