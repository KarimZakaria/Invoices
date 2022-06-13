@extends('layouts.master')

@section('title' , 'الفواتير المدفوعة جزئيا')
@section('css')
    @include('layouts.css')
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
				<!-- row opened -->
				<div class="row">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
                                    <a class="btn btn-primary" href="{{ route('invoices.create') }}"><i class="fa fa-plus"></i> اضافة فاتورة</a>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table table- key-buttons text-md-nowrap" cellspacing="0" width="100%">
										<thead>
											<tr>
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">رقم الفاتورة</th>
                                                <th class="border-bottom-0">تاريخ الفاتورة</th>
                                                <th class="border-bottom-0">المنتج</th>
                                                <th class="border-bottom-0">القسم</th>
                                                <th class="border-bottom-0">المطلوب</th>
                                                <th class="border-bottom-0">الخصم</th>
                                                <th class="border-bottom-0">قيمة الضريبة</th>
                                                <th class="border-bottom-0">الاجمالي</th>
                                                <th class="border-bottom-0">الحالة</th>
                                                <th class="border-bottom-0">العمليات</th>
                                            </tr>
										</thead>
										<tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr class="text-center">
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$invoice->invoice_number}}</td>
                                                    <td>{{$invoice->invoice_date}}</td>
                                                    <td>{{$invoice->product}}</td>
                                                    <td>{{$invoice->category->category_name}}</td>
                                                    <td>{{$invoice->Amount_collection}}</td>
                                                    <td>{{$invoice->discount}}</td>
                                                    <td>{{$invoice->vat_value}}</td>
                                                    <td>{{$invoice->total}}</td>
                                                    <td>
                                                        @if ($invoice->status_value == 1)
                                                            <span class="text-success">{{$invoice->status}}</span>
                                                        @elseif ($invoice->status_value == 2)
                                                            <span class="text-danger">{{$invoice->status}}</span>
                                                        @else
                                                            <span class="text-warning">{{$invoice->status}}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary btn-sm" data-toggle="dropdown" id="dropdownMenuButton" type="button">العمليات<i class="fas fa-caret-down mr-1"></i></button>
                                                            <div  class="dropdown-menu tx-13">
                                                                <a class="dropdown-item" href="{{route('Invoice_Details', $invoice->id)}}"><i class="fa fa-eye text-primary"></i> معلومات الفاتورة</a>
                                                                <a class="dropdown-item" href="{{ route('invoices.edit', $invoice->id) }}"><i class="fa fa-edit text-success"></i> تعديل الفاتورة</a>
                                                                <a class="dropdown-item" href="#" data-invoice_id ="{{ $invoice->id }}" data-toggle="modal"
                                                                    data-target="#deleteInvoice"><i class="fa fa-trash text-danger"></i> حذف الفاتورة
                                                                </a>
                                                                <a class="dropdown-item" href="{{ route('showStatus', $invoice->id) }}"><i class="fas fa-exchange-alt text-warning"></i> تغيير حالة الدفع</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
                            </div>
						</div>
					</div>
                </div>
                {{-- Strat Invoice Deleting  --}}
                @if($invoices->count() > 0)
                    <div class="modal fade" id="deleteInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="invoice_id" id="invoice_id" value="">
                                        هل أنت متاكد من عملية الحذف ؟
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- End Deleting Invoice --}}
			<!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection

@section('js')
    @include('layouts.js')
    <script>
        $('#deleteInvoice').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
@endsection

