<!DOCTYPE html>
<html>
<head>
    <title>Ramco Records</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <style>
        tr:hover { cursor: pointer; background-color: #f0f8ff; }
        .selected { background-color: #d0ebff !important; }
        tfoot tr { background-color: #f1f1f1; font-weight: bold; }

        #detailTable td:nth-child(7),
        #detailTable td:nth-child(8),
        #detailTable tfoot td:nth-child(7),
        #detailTable tfoot td:nth-child(8) {
            text-align: right;
            font-weight: 500;
        }
/* Make summary row darker and bold, override DataTables styles */
#headerTable tbody tr.summary-row td {
    background-color: #d6d8db !important;  /* darker gray */
    font-weight: bold;
}

/* Detail rows slightly lighter for grouping effect */
/* #headerTable tbody tr.detail-row td {
    background-color: #eef0f3 !important;
} */

/* Hover effect */
#headerTable tbody tr:hover td {
    background-color: #cfe2ff !important;
}

/* Selected row */
#headerTable tbody tr.selected td {
    background-color: #b6d4fe !important;
}

/* Optional: add border above summary row for separation */
#headerTable tbody tr.summary-row td {
    border-top: 2px solid #6c757d;
}
/* Hover effect for detail table rows */
#detailTable.dataTable tbody tr {
    background-color: transparent !important; /* reset any DataTables default */
}

#detailTable.dataTable tbody tr:hover td {
    background-color: #cfe2ff !important; /* your hover color */
}
    </style>
</head>

<body>
<div class="container-fluid m-1">

    <h1 class="mb-4 text-center" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">Ramco Records</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">INQ</div>
        <div class="card-body">

            <table id="headerTable" class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                <tr>
                    <th>HDR No</th>
                    <th>Finance Book</th>
                    <th>Account Code</th>
                    <th>DR Total</th>
                    <th>CR Total</th>
                    <th>Trans Type</th>
                    <th>Cost Center</th>
                    <th>Analysis Code</th>
                    <th>Sub Analysis Code</th>
                    <th>Doc Ref Type</th>
                    <th>Doc Ref</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Supplier Code</th>
                    <th>Supplier Name</th>
                    <th>Remarks</th>
                    <th>Created By</th>
                </tr>
                </thead>
                <tbody>
                @php $grouped = $results->groupBy('hdr_no'); @endphp
                @foreach($grouped as $hdr_no => $headers)
@php
    $drTotal = $headers->where('php_amt', '>', 0)->sum('php_amt');
    $crTotal = abs($headers->where('php_amt', '<', 0)->sum('php_amt'));
@endphp

<tr class="summary-row" data-hdr="{{ $hdr_no }}">
    <td>{{ $hdr_no }}</td>
    <td>Summary</td>
    <td></td>
    <td class="text-end">{{ number_format($drTotal, 2) }}</td>
    <td class="text-end">{{ number_format($crTotal, 2) }}</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
</tr>
@foreach($headers as $header)
<tr class="detail-row"
    data-hdr="{{ $hdr_no }}"
    data-details='@json($header->details)'
    style="display: none;">
    <td>{{ $header->hdr_no }}</td>
    <td>{{ $header->finance_book }}</td>
    <td>{{ $header->acct_code }}</td>

    <td class="text-end">
        {{ $header->php_amt > 0 ? number_format($header->php_amt, 2) : '' }}
    </td>
    <td class="text-end">
        {{ $header->php_amt < 0 ? number_format(abs($header->php_amt), 2) : '' }}
    </td>
    <td>{{ $header->trans_type }}</td>
    <td>{{ $header->cost_center }}</td>
    <td>{{ $header->analysis_code }}</td>
    <td>{{ $header->sub_analysis_code }}</td>
    <td>{{ $header->doc_ref1_type }}</td>
    <td>{{ $header->doc_ref1 }}</td>
    <td>{{ $header->month }}</td>
    <td>{{ $header->year }}</td>
    <td>{{ $header->supplier_code }}</td>
    <td>{{ $header->supplier_name }}</td>
    <td>{{ $header->narration }}</td>
    <td>{{ $header->created_by }}</td>
</tr>
@endforeach

                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">JE</div>
        <div class="card-body">
            <table id="detailTable" class="table table-bordered table-striped mb-0">
                <thead class="table-light">
                <tr>
                    <th>JE Number</th>
                    <th>Acct Code</th>
                    <th>Acct Desc</th>
                    <th>DR Amount</th>
                    <th>CR Amount</th>
                    <th>Currency</th>
                    <th>Fiscal Period</th>
                    <th>Fiscal Year</th>
                    <th>Remarks</th>
                    <th>Prepared ID</th>
                    <th>Approver ID</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr class="table-light">
                    <td colspan="3" class="text-start fw-bold border-top">Total:</td>
                    <td id="totalDR" class="border-top">0.00</td>
                    <td id="totalCR" class="border-top">0.00</td>
                    <td colspan="6" class="border-top"></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
const moneyFormatter = new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

$(document).ready(function() {

    var headerTable = $('#headerTable').DataTable({ paging: true, searching: true, ordering: true, pageLength: 25 });
    var detailTable = $('#detailTable').DataTable({ paging: true, searching: true, ordering: true, pageLength: 25 });

    $('#headerTable tbody').on('click', '.summary-row', function(e){
    e.stopPropagation();
    var hdr = $(this).data('hdr');
    var $details = $('#headerTable tbody tr.detail-row[data-hdr="'+hdr+'"]');

    // Collapse all other detail rows
    $('#headerTable tbody tr.detail-row').not($details).hide();

    // Remove 'selected' class from other summary rows
    $('#headerTable tbody tr.summary-row').not(this).removeClass('selected');

    // Toggle the clicked summary row's detail rows
    $details.toggle();

    // Add selected class to clicked summary row
    $(this).toggleClass('selected');

    // Populate detail table (your existing logic)
    var allDetails = [];
    $details.each(function() {
        let data = $(this).data('details');
        if (!Array.isArray(data)) data = [data];
        data.forEach(d => {
            if(!allDetails.some(x => x.je_number === d.je_number && x.acct_code === d.acct_code && x.php_amt === d.php_amt)) {
                allDetails.push(d);
            }
        });
    });

    detailTable.clear();
    var totalDR = 0, totalCR = 0;
    allDetails.forEach(function(d) {
        let amount = parseFloat(d.php_amt) || 0;
        let drAmount = d.acct_type === 'DR' ? amount : 0;
        let crAmount = d.acct_type === 'CR' ? amount : 0;
        totalDR += drAmount; totalCR += crAmount;
        detailTable.row.add([
            d.je_number, d.acct_code, d.acct_desc,
            drAmount ? moneyFormatter.format(drAmount) : '',
            crAmount ? moneyFormatter.format(crAmount) : '', 
            d.currency,
            d.fiscal_period, 
            d.fiscal_year,
            d.je_remarks,
            d.preparer_id, 
            d.approver_id
        ]);
    });
    detailTable.draw(false);
    $('#totalDR').html(moneyFormatter.format(totalDR));
    $('#totalCR').html(moneyFormatter.format(totalCR));
    $('#totalDR, #totalCR').css('color', Math.abs(totalDR-totalCR)>=0.01?'red':'black');
});


});
</script>
</body>
</html>
