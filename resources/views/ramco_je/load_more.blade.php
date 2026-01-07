@foreach($inqs as $inq)
<tr>
    <td>{{ $inq->gl_number }}</td>
    <td>{{ $inq->je_number }}</td>
    <td>{{ $inq->acct_code }}</td>
    <td class="text-end">{{ $inq->php_amt > 0 ? number_format($inq->php_amt,2) : '' }}</td>
    <td class="text-end">{{ $inq->usd_amt > 0 ? number_format(abs($inq->usd_amt),2) : '' }}</td>
    <td>{{ $inq->exrate }}</td>
    <td>{{ $inq->acct_type }}</td>
    <td>{{ $inq->fiscal_period }}</td>
    <td>{{ $inq->fiscal_year }}</td>
    <td>{{ $inq->preparer_id }}</td>
    <td>{{ $inq->approver_id }}</td>
    <td>{{ $inq->je_remarks }}</td>
    <td>
        {{ \Carbon\Carbon::parse($inq->entry_date)->format('M d, Y') }}
    </td>
    <td>
        {{ \Carbon\Carbon::parse($inq->effective_date)->format('M d, Y') }}
    </td>
</tr>
@endforeach

<input type="hidden" id="nextPageUrl" value="{{ $inqs->nextPageUrl() }}">
