@extends('layouts.master')

@section('title' , 'الفواتير المحذوفه جزئيا')
@section('css')
    @include('layouts.css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الفواتير المحذوفه جزئيا</span>
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
                                        <a class="modal-effect btn btn-outline-primary" data-effect="effect-scale" href="{{ route('invoices.index') }}">عودة للفواتير <i class="fas fa-arrow-circle-left ml-1"></i></a>
                                        <a class="modal-effect btn btn-primary" data-effect="effect-scale" href="{{ route('home') }}">العودة للرئيسية  <i class="fas fa-arrow-circle-left mr-1"></i></a>
                                    </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length="50">
                                        <thead>
                                            <tr class="text-center">
                                                <th class="border-bottom-0">#</th>
                                                <th class="border-bottom-0">رقم الفاتورة</th>
                                                <th class="border-bottom-0">أضيف بواسطة</th>
                                                <th class="border-bottom-0">العلميات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $invoice)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $invoice->invoice_number }} </td>
                                                <td>{{ $invoice->details->user }}</td>
                                                <td>
                                                    <button class="btn btn-outline-primary btn-sm " data-id="{{ $invoice->id }}"
                                                        data-invoice_number="{{ $invoice->invoice_number }}"
                                                        data-id = "{{ $invoice->id }}"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal">استرجاع الفاتورة
                                                    </button>

                                                    <button class="btn btn-outline-danger btn-sm " data-id="{{ $invoice->id }}"
                                                        data-invoice_number="{{ $invoice->invoice_number }}"
                                                        data-id = "{{ $invoice->id }}"
                                                        data-toggle="modal"
                                                        data-target="#modaldemo9">حذف نهائي
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($invoices->count() > 0 )
                        {{-- Restore Deleted Product --}}
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"> استرجاع الفاتورة</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('invoices.restore' , $invoice->id)}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <p>هل انت متاكد من عملية استرجاع الفاتورة للعرض ؟</p><br>
                                            <input type="hidden" name="id" id="id" value="">
                                            <input class="form-control" name="invoice_number" id="invoice_number" type="text" readonly>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- End of Restoring --}}

                        {{-- Modal Force Delete Product --}}
                        <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"> حذف الفاتورة نهائيا</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('invoices.destroy' , $invoice->id)}}" method="POST">
                                        @method("DELETE")
                                        @csrf
                                        <div class="modal-body">
                                            <p>هل انت متاكد من عملية حذف الفاتوره نهائيا ؟</p><br>
                                            <input type="hidden" name="id" id="id" value="">
                                            <input class="form-control" name="invoice_number" id="invoice_number" type="text" readonly>
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
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>
@endsection
