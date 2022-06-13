@extends('layouts.master')
@section('title')
    معلومات الفاتورة
@endsection
@section('css')
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفاتورة {{$invoice->id}}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ معلومات الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<!-- div -->
						<div class="card mg-b-20" id="tabs-style2">
							<div class="card-body">
								<div class="text-wrap">
									<div class="example">
										<div class="panel panel-primary tabs-style-2">
											<div class=" tab-menu-heading">
												<div class="tabs-menu1">
													<!-- Tabs -->
													<ul class="nav panel-tabs main-nav-line">
														<li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
														<li><a href="#tab5" class="nav-link" data-toggle="tab">حالة الدفع</a></li>
														<li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
													</ul>
												</div>
											</div>
											<div class="panel-body tabs-menu-body main-content-body-right border">
												<div class="tab-content">
													<div class="tab-pane active" id="tab4">
                                                        <div class="table table-responsive mt-15">
                                                            <table class="table table-striped text-center">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">رقم الفاتورة</th>
                                                                        <td>{{ $invoice->invoice_number }}</td>
                                                                        <th scope="row">تاريخ الفاتورة</th>
                                                                        <td>{{ $invoice->invoice_date }}</td>
                                                                        <th scope="row">تاريخ الاستحقاق</th>
                                                                        <td>{{ $invoice->due_date }}</td>
                                                                        <th scope="row">القسم</th>
                                                                        <td>{{ $invoice->category->category_name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">المنتج</th>
                                                                        <td>{{ $invoice->product }}</td>
                                                                        <th scope="row">المبلغ المطلوب</th>
                                                                        <td>{{ $invoice->Amount_collection }}</td>
                                                                        <th scope="row">مبلغ االعمولة</th>
                                                                        <td>{{ $invoice->Amount_Commission }}</td>
                                                                        <th scope="row">الخصم</th>
                                                                        <td>{{ $invoice->discount }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">نسبة الضريبة</th>
                                                                        <td>{{ $invoice->rat_vat }}</td>
                                                                        <th scope="row">الضريبة بعد الخصم</th>
                                                                        <td>{{ $invoice->vat_value }}</td>
                                                                        <th scope="row">الاجمالي بعد الخصم</th>
                                                                        <td>{{ $invoice->total }}</td>
                                                                        <th scope="row">الحالة</th>
                                                                        <td>
                                                                            @if ($invoice->status_value == 1)
                                                                                <span class="badge badge-pill badge-success">{{$invoice->status}}</span>
                                                                            @elseif ($invoice->status_value == 2)
                                                                                <span class="badge badge-pill badge-danger">{{$invoice->status}}</span>
                                                                            @else
                                                                                <span class="badge badge-pill badge-warning">{{$invoice->status}}</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>الوصف</th>
                                                                        <td>
                                                                            @if ($invoice->note == null)
                                                                                <span class="badge badge-danger badge-pill">لا يوجد وصف للفاتورة</span>
                                                                            @else
                                                                                {{$invoice->note}}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
													<div class="tab-pane" id="tab5">
                                                        <div class="table table-responsive mt-15">
                                                            <table class="table table-striped text-center">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>رقم الفاتورة</th>
                                                                        <th>نوع المنتج</th>
                                                                        <th>القسم</th>
                                                                        <th>تاريخ الاضافه</th>
                                                                        <th>حالة الدفع</th>
                                                                        <th>تاريخ الدفع</th>
                                                                        <th>قام بالاضافة</th>
                                                                    </tr>
                                                                    <tr>
                                                                        @foreach ($details as $detail)
                                                                            <td>{{ $detail->invoice_number }}</td>
                                                                            <td>{{ $detail->product }}</td>
                                                                            <td>{{ $detail->category->category_name }}</td>
                                                                            <td>{{ $detail->created_at}}</td>
                                                                            <td>
                                                                                @if ($detail->status_value == 1)
                                                                                    <span class="badge badge-pill badge-success">{{$invoice->status}}</span>
                                                                                @elseif ($detail->status_value == 2)
                                                                                    <span class="badge badge-pill badge-danger">{{$invoice->status}}</span>
                                                                                @else
                                                                                    <span class="badge badge-pill badge-warning">{{$invoice->status}}</span>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                @if($detail->Payment_date == null)
                                                                                    <span class="text-danger">لم يتم الدفع</span>
                                                                                @else
                                                                                    <span>{{ $detail->Payment_date }}</span>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $detail->user }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
													<div class="tab-pane" id="tab6">
                                                        {{-- ADD ANOTHER ATTACHMENT --}}
                                                        <div class="card-body">
                                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                            <h5 class="card-title">اضافة مرفقات</h5>
                                                            <form method="post" action="{{ route('invoice_attachments.store') }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="custom-file form-group">
                                                                    <input type="file" class="form-control w-50 custom-file-label" id="customFile" name="file_name" required>
                                                                    <input type="hidden" id="customFile" name="invoice_number" value="{{ $invoice->invoice_number }}">
                                                                    <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                                                                </div><br><br>
                                                                <button type="submit" class="btn btn-primary"
                                                                    name="uploadedFile">تأكيد</button>
                                                            </form>
                                                        </div>
                                                        {{-- END ADDING NEW ATTACHMENT --}}

                                                        <div class="table table-responsive mt-15">
                                                            <table class="table table-striped text-center">
                                                                <tbody>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>اسم الملف</th>
                                                                        <th>تاريخ الاضافه</th>
                                                                        <th>اضيف بواسطة</th>
                                                                        <th>العمليات</th>
                                                                    </tr>
                                                                    @forelse ($attachments as $attachment)
                                                                        <tr>
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $attachment->file_name }}</td>
                                                                            <td>{{ $attachment->created_at }}</td>
                                                                            <td>{{ $attachment->added_by }}</td>
                                                                            <td>
                                                                                <a class="btn btn-outline-success btn-sm"
                                                                                    href="{{ route('open_file' , [$invoice->invoice_number , $attachment->file_name]) }}"
                                                                                    role="button"><i class="fas fa-eye"></i>&nbsp; عرض
                                                                                </a>
                                                                                <a class="btn btn-outline-info btn-sm"
                                                                                    href="{{ route('Download' , [$invoice->invoice_number, $attachment->file_name]) }}"
                                                                                    role="button"><i class="fas fa-download"></i>&nbsp; تحميل
                                                                                </a>
                                                                                <button class="btn btn-outline-danger btn-sm"
                                                                                data-toggle="modal"
                                                                                data-file_name="{{ $attachment->file_name }}"
                                                                                data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                data-file_id="{{ $attachment->id }}"
                                                                                data-target="#delete_file"><i class="fa fa-trash"></i>&nbsp; حذف</button>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <h4 class="text-danger text-center">لا يوجد مرفقات لهذه الفاتورة </h4>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /div -->
				</div>
                <!-- /row -->
                {{-- Delete File --}}
                <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('Delete_File') }}" method="post">
                                @csrf
                                <div class="modal-body bg-light">
                                    <p class="text-center">
                                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                    </p>
                                    <input type="hidden" name="file_id" id="file_id" value="">
                                    <input type="hidden" name="file_name" id="file_name" value="">
                                    <input type="hidden" name="invoice_number" id="invoice_number" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>

<script>
    $('#delete_file').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var file_id = button.data('file_id')
        var file_name = button.data('file_name')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)
        modal.find('.modal-body #file_id').val(file_id);
        modal.find('.modal-body #file_name').val(file_name);
        modal.find('.modal-body #invoice_number').val(invoice_number);
    })
</script>
@endsection
