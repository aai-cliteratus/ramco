@foreach($inqs as $inq)
<tr>
    <td>{{ $inq->hdr_no }}</td>
    <td>{{ $inq->finance_book ?? '-' }}</td>
    <td>{{ $inq->acct_code ?? '-' }}</td>
    <td class="text-end">{{ $inq->php_amt > 0 ? number_format($inq->php_amt, 2) : '' }}</td>
    <td class="text-end">{{ $inq->php_amt < 0 ? number_format(abs($inq->php_amt), 2) : '' }}</td>
    <td>{{ $inq->trans_type ?? '-' }}</td>
    <td>{{ $inq->cost_center ?? '-' }}</td>
    <td>{{ $inq->analysis_code ?? '-' }}</td>
    <td>{{ $inq->sub_analysis_code ?? '-' }}</td>
    <td>{{ $inq->doc_ref1_type ?? '-' }}</td>
    <td>{{ $inq->doc_ref1 ?? '-' }}</td>
    <td>{{ $inq->month ?? '-' }}</td>
    <td>{{ $inq->year ?? '-' }}</td>
    <td>{{ $inq->supplier_code ?? '-' }}</td>
    <td>{{ $inq->supplier_name ?? '-' }}</td>
    <td>{{ $inq->narration ?? '-' }}</td>
    <td>{{ $inq->created_by ?? '-' }}</td>
</tr>
@endforeach

<input type="hidden" id="nextPageUrl" value="{{ $inqs->nextPageUrl() }}">
