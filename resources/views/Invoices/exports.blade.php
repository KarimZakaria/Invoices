<table>
    <thead>
    <tr>
        <strong>
            <th>#</th>
            <th>رقم الفاتورة</th>
            <th>تاريخ الفاتورة</th>
            <th>تاريخ الاستحقاق</th>
            <th>المنتج</th>
            <th>القسم</th>
            <th>المبلغ الكلي</th>
            <th>العمولة</th>
            <th>الخصم</th>
            <th>نسبه الضريبه</th>
            <th>قيمة الضريبه</th>
            <th>المطلوب سدادة</th>
            <th>حالة الدفع</th>
            <th>تاريخ الدفع</th>
            <th>الوصف</th>
            <th>حاله الفاتورة</th>
        </strong>
    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->invoice_number }}</td>
            <td>{{ $invoice->invoice_date }}</td>
            <td>{{ $invoice->due_date }}</td>
            <td>{{ $invoice->product }}</td>
            <td>{{ $invoice->category->category_name }}</td>
            <td>{{ $invoice->Amount_collection }}</td>
            <td>{{ $invoice->Amount_Commission }}</td>
            <td>{{ $invoice->discount }}</td>
            <td>{{ $invoice->rat_vat }}</td>
            <td>{{ $invoice->vat_value }}</td>
            <td>{{ $invoice->total }}</td>
            <td>{{ $invoice->status }}</td>
            @if($invoice->status_value == 2)
                <td>ليست مدفوعة</td>
            @elseif($invoice->status_value == 1)
                <td>{{ $invoice->payment_date }} مدفوعه كاملا</td>
            @elseif($invoice->status_value == 3)
                <td>{{ $invoice->payment_date }} مدفوعة جزئيا</td>
            @endif
            @if($invoice->note != null)
            <td>{{ $invoice->note }}</td>
            @else
                <td class="text-warning">لا يوجد وصف للفاتورة</td>
            @endif
            @if($invoice->deleted_at == null)
                <td>موجودة</td>
            @else
                <td>محذوفة جزئيا</td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
