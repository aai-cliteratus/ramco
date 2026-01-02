<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RAMCO Inquiry</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        .column-search {
            width: 100%;
            font-size: 0.8rem;
            padding: 2px 4px;
        }

        .sortable {
            cursor: pointer;
            user-select: none;
        }
        .sortable::after {
            content: ' ⇅';
            font-size: 0.7rem;
            color: #aaa;
        }
        .sortable.asc::after { content: ' ▲'; color: #000; }
        .sortable.desc::after { content: ' ▼'; color: #000; }

        #scrollTopBtn {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            border: none;
            background: #0d6efd;
            color: #fff;
            padding: 10px 14px;
            border-radius: 50%;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        #inqTable tbody tr {
            transition: all 0.15s ease-in-out;
        }
        #inqTable tbody tr:hover {
            background-color: #eef5ff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>

<div class="container my-4">
<h1 class="mb-4 text-center">Ramco JE Records</h1>

<form action="{{ route('ramco_je.index') }}" method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-3">
    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Document Number</label>
        <input type="text" class="form-control" name="doc_no" value="{{ request('doc_no') }}">
    </div>

    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Month</label>
        <select class="form-select" name="month">
            <option value="">-- Select Month --</option>
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ request('month')==$m?'selected':'' }}>
                    {{ DateTime::createFromFormat('!m',$m)->format('F') }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Year</label>
        <select class="form-select" name="year" id="filterYear">
            <option value="">-- Select Year --</option>
        </select>
    </div>

    <div class="d-flex flex-column mt-auto">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<table class="table table-bordered table-striped" id="inqTable">
<thead>
<tr>
    <th class="sortable" data-col="0">GL Number</th>
    <th class="sortable" data-col="1">JE Number</th>
    <th class="sortable" data-col="2">Account Code</th>

    <!-- TOTALS IN HEADER -->
    <th class="sortable" data-col="3">
        PHP Amount<br>
        <small>Total: <span id="drTotal">0.00</span></small>
    </th>
    <th class="sortable" data-col="4">
        USD Amount<br>
        <small>Total: <span id="crTotal">0.00</span></small>
    </th>

    <th class="sortable" data-col="5">Exrate</th>
    <th class="sortable" data-col="6">Account Type</th>
    <th class="sortable" data-col="7">Fiscal Period</th>
    <th class="sortable" data-col="8">Fiscal Year</th>
    <th class="sortable" data-col="9">Prepared By</th>
    <th class="sortable" data-col="10">Approved By</th>
    <th class="sortable" data-col="11">JE Remarks</th>
</tr>

<tr>
@foreach(range(1,12) as $i)
    <th><input class="column-search" data-col="{{ $i-1 }}" placeholder="Search"></th>
@endforeach
</tr>
</thead>

<tbody id="inqTableBody">
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
</tr>
@endforeach
</tbody>
</table>

<div id="loadMoreSpinner" class="text-center my-3" style="display:none;">
    <div class="spinner-border text-primary"></div>
</div>

<input type="hidden" id="nextPageUrl" value="{{ $inqs->nextPageUrl() }}">
</div>

<button id="scrollTopBtn">↑</button>

<script>
function recalcTotals() {
    let dr = 0, cr = 0;
    $('#inqTableBody tr:visible').each(function () {
        dr += parseFloat($(this).find('td').eq(3).text().replace(/,/g,'')) || 0;
        cr += parseFloat($(this).find('td').eq(4).text().replace(/,/g,'')) || 0;
    });
    $('#drTotal').text(dr.toLocaleString(undefined,{minimumFractionDigits:2}));
    $('#crTotal').text(cr.toLocaleString(undefined,{minimumFractionDigits:2}));
}

$(function () {

    recalcTotals(); // initial

    let loading = false;

    $(window).scroll(function () {

        if ($(this).scrollTop() > $(window).height()) {
            $('#scrollTopBtn').fadeIn();
        } else {
            $('#scrollTopBtn').fadeOut();
        }

        if (loading) return;

        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            let nextPage = $('#nextPageUrl').val();
            if (!nextPage) return;

            loading = true;
            $('#loadMoreSpinner').show();

            $.get(nextPage, function (data) {
                $('#inqTableBody').append(data);

                let nextUrl = $(data).filter('#nextPageUrl').val();
                $('#nextPageUrl').val(nextUrl);

                $('#loadMoreSpinner').hide();
                loading = false;

                recalcTotals(); // ✅ update totals on load more
            });
        }
    });

    $('.column-search').on('keyup', function () {
        let col = $(this).data('col');
        let val = $(this).val().toLowerCase();

        $('#inqTableBody tr').each(function () {
            $(this).toggle($(this).find('td').eq(col).text().toLowerCase().includes(val));
        });

        recalcTotals();
    });

    $('.sortable').on('click', function () {
        let col = $(this).data('col');
        let asc = !$(this).hasClass('asc');

        $('.sortable').removeClass('asc desc');
        $(this).addClass(asc ? 'asc' : 'desc');

        let rows = $('#inqTableBody tr').get().sort(function (a, b) {
            let A = $(a).children().eq(col).text().replace(/,/g,'');
            let B = $(b).children().eq(col).text().replace(/,/g,'');
            return asc ? A.localeCompare(B,undefined,{numeric:true}) : B.localeCompare(A,undefined,{numeric:true});
        });

        $('#inqTableBody').append(rows);
        recalcTotals();
    });

    $('#scrollTopBtn').click(() => $('html,body').animate({scrollTop:0},500));
});

const y = document.getElementById('filterYear');
for (let i = new Date().getFullYear(); i >= 2000; i--) y.add(new Option(i,i));
</script>

</body>
</html>
