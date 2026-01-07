<!DOCTYPE html>
<html>
<head>
    <title>Ramco Records</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="{{ asset('img/favico.ico') }}">
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
        /* Make summary row darker and bold */
        #headerTable tbody tr.summary-row td {
            background-color: #d6d8db !important;
            font-weight: bold;
        }
        #headerTable tbody tr:hover td {
            background-color: #cfe2ff !important;
        }
        #headerTable tbody tr.selected td {
            background-color: #b6d4fe !important;
        }
        #headerTable tbody tr.summary-row td {
            border-top: 2px solid #6c757d;
        }
        #detailTable.dataTable tbody tr {
            background-color: transparent !important;
        }
        #detailTable.dataTable tbody tr:hover td {
            background-color: #cfe2ff !important;
        }
        
.ripple {
    position: relative;
    overflow: hidden;
}

.ripple-circle {
    position: absolute;
    width: 20px;
    height: 20px;
    background: rgba(255,255,255,0.5);
    border-radius: 50%;
    transform: scale(0);
    pointer-events: none;
}

.ripple-animate {
    animation: rippleEffect 0.6s linear;
}

@keyframes rippleEffect {
    to {
        transform: scale(15);
        opacity: 0;
    }
}

/* Buttons shadow */
.btn {
    box-shadow: 0 4px 10px rgba(0,0,0,0.15); /* soft shadow */
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}

.btn:hover {
    box-shadow: 0 6px 14px rgba(0,0,0,0.2); /* deeper shadow on hover */
    transform: translateY(-2px); /* subtle lift effect */
}

/* Table shadow */
#inqTable {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* subtle table shadow */
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Table header shadow on hover (optional) */
#inqTable thead tr {
    background-color: #f8f9fa;
    box-shadow: inset 0 -1px 0 rgba(0,0,0,0.1);
}

/* Optional: add subtle row hover shadow already present */
#inqTable tbody tr:hover {
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

        /* Top Bar */
.top-bar {
    position: sticky;
    top: 0;
    width: 100%;
    height: 60px;
    background-color: #a3a3a3ff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1rem;
}

/* Hamburger */
.hamburger {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 25px;
    height: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.hamburger span {
    display: block;
    height: 3px;
    width: 100%;
    background: white;
    border-radius: 2px;
    transition: all 0.3s ease;
}

/* Hamburger active animation to X */
.hamburger.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}
.hamburger.active span:nth-child(2) {
    opacity: 0;
}
.hamburger.active span:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
}

/* Top Menu */
.top-menu {
    position: absolute;
    top: 60px;
    right: 0;
    background-color: #a3a3a3ff;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    max-height: 0;
    opacity: 0;
    transition: all 0.4s ease;
    border-radius: 0 0 6px 6px;
    width: 200px;
    z-index: 999;
}

.top-menu.active {
    max-height: 500px; /* enough to show all links */
    opacity: 1;
}

.top-menu a {
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

    .top-menu a:hover {
    color: #6e6e6eff; /* change text color on hover */
    background-color: transparent; /* keep background unchanged */
}

/* Hide title on small screens */
@media (max-width: 1000px) {
    .top-bar h2 {
        display: none;
    }
}

/* Responsive: top menu always visible on large screens */
@media (min-width: 1001px) {
    .hamburger {
        display: none;
    }
    .top-menu {
        position: static;
        flex-direction: row;
        display: flex !important;
        background: transparent;
        box-shadow: none;
        border-radius: 0;
        max-height: none;
        opacity: 1;
        width: auto;
    }
    .top-menu a {
        padding: 0 15px;
    }
}
.ocean-wave-btn {
    position: relative;
    overflow: hidden;
    color: #fff;
    background-color: #7e7d7dff;
    border: none;
    padding: 0.6rem 1.5rem;
    font-size: 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
}

/* Wave at the bottom */
.ocean-wave-btn::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 200%;           /* double width for seamless scroll */
    height: 12px;          /* wave height */
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="12"><path fill="%23ffffff" d="M0 6 C25 0 50 12 75 6 C100 0 125 12 150 6 C175 0 200 12 200 6 V12 H0 Z"/></svg>') repeat-x;
    opacity: 0.4;
    animation: waveScroll 4s linear infinite;
}

/* Infinite horizontal scroll */
@keyframes waveScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); } /* scroll exactly half width */
}
.inner-shadow {
    text-shadow:
        0 2px 3px rgba(0,0,0,0.6),
        0 -1px 1px rgba(255,255,255,0.2);
}

#detailTable tbody tr.je-missing-inq td {
    background-color: #e6d2d4ff !important;
}

    </style>
</head>

<body>
    
<!-- Top Bar with Hamburger -->
<div class="top-bar d-flex align-items-center justify-content-between px-4">
  <a href="./" class="inline-flex flex-col items-center gap-2 cursor-pointer">
    <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40" class="logo-glow">
      </a>
    <h2 class="mb-0 text-white inner-shadow">RAMCO Inquiry System</h2>

    <!-- Hamburger -->
    <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Menu Links -->
    <div class="top-menu" id="topMenu">
        <a href="/ramco" class="top-link">Ramco</a>
        <a href="/ramco_inq" class="top-link">Ramco INQ</a>
        <a href="/ramco_je" class="top-link">Ramco JE</a>
        <a href="/ramco_tb" class="top-link">Ramco TB</a>
    </div>
</div>
<div class="container-fluid m-1">

    <h1 class="mt-3 pt-2 mb-4 text-center" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">Ramco Records</h1>
<form action="{{ route('ramco.index') }}" method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-3" id="ramForm">

    <!-- Document Number -->
    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Document Number</label>
        <input
            type="text"
            class="form-control"
            placeholder="Enter Document Number"
            name="doc_no"
            id="filterDocNo"
            value="{{ request('doc_no') }}"
        >
    </div>

    <!-- Month -->
    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Month</label>
        <select class="form-select" name="month" id="filterMonth">
            <option value="">-- Select Month --</option>
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Year -->
    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Year</label>
        <select class="form-select" name="year" id="filterYear">
            <option value="">-- Select Year --</option>
        </select>
        <small id="monthYearError" class="text-danger d-none">
            Month and Year must be selected together.
        </small>
    </div>

    <!-- Submit button -->
    <div class="d-flex flex-column mt-auto">
        <button type="submit" class="btn btn-secondary ripple ocean-wave-btn">Submit</button>
    </div>

</form>


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
                <tr class="detail-row" data-hdr="{{ $hdr_no }}" data-details='@json($header->details)' style="display: none;">
                    <td>{{ $header->hdr_no }}</td>
                    <td>{{ $header->finance_book }}</td>
                    <td>{{ $header->acct_code }}</td>
                    <td class="text-end">{{ $header->php_amt > 0 ? number_format($header->php_amt, 2) : '' }}</td>
                    <td class="text-end">{{ $header->php_amt < 0 ? number_format(abs($header->php_amt), 2) : '' }}</td>
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

<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
const moneyFormatter = new Intl.NumberFormat('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

$(document).ready(function() {

    // Collect INQ account codes from header table
const inqAcctCodes = new Set();

    var headerTable = $('#headerTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', text: 'Export Header to Excel', title: 'INQ Records' }
        ]
    });

    var detailTable = $('#detailTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        pageLength: 25,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', text: 'Export Detail to Excel', title: 'JE Records' }
        ]
    });

$('#headerTable tbody tr.detail-row').each(function () {
    const acctCode = $(this).find('td').eq(2).text().trim(); // acct_code column
    if (acctCode) {
        inqAcctCodes.add(acctCode);
    }
});


    $('#headerTable tbody').on('click', '.summary-row', function(e){
        e.stopPropagation();
        var hdr = $(this).data('hdr');
        var $details = $('#headerTable tbody tr.detail-row[data-hdr="'+hdr+'"]');

        // Collapse all other detail rows
        $('#headerTable tbody tr.detail-row').not($details).hide();

        // Remove 'selected' class from other summary rows
        $('#headerTable tbody tr.summary-row').not(this).removeClass('selected');

        // Toggle clicked row
        $details.toggle();
        $(this).toggleClass('selected');

            // 🔹 Recalculate INQ acct codes every click
    const inqAcctCodes = new Set();
    $('#headerTable tbody tr.detail-row').each(function () {
        const acctCode = $(this).find('td').eq(2).text().trim(); // acct_code column
        if (acctCode) inqAcctCodes.add(acctCode);
    });
    
        // Populate detail table
var allDetails = [];
var seenIds = new Set(); // track already added IDs

$details.each(function() {
    let data = $(this).data('details');
    if (!Array.isArray(data)) data = [data];
    data.forEach(d => {
        if (!seenIds.has(d.id)) {      // only add if id not seen
            allDetails.push(d);
            seenIds.add(d.id);
        }
    });
});

        detailTable.clear();
        var totalDR = 0, totalCR = 0;
        allDetails.forEach(function(d) {
            let amount = parseFloat(d.php_amt) || 0;
            let drAmount = d.acct_type === 'DR' ? amount : 0;
            let crAmount = d.acct_type === 'CR' ? amount : 0;
            totalDR += drAmount; 
            totalCR += crAmount;
const rowNode = detailTable.row.add([
    d.je_number, 
    d.acct_code, 
    d.acct_desc,
    drAmount ? moneyFormatter.format(drAmount) : '',
    crAmount ? moneyFormatter.format(crAmount) : '',
    d.currency,
    d.fiscal_period, 
    d.fiscal_year,
    d.je_remarks,
    d.preparer_id, 
    d.approver_id
]).node();

// 🔥 HIGHLIGHT if JE acct_code NOT found in INQ
const jeAcctCode = String(d.acct_code).trim();
if (!inqAcctCodes.has(jeAcctCode)) {
    $(rowNode).addClass('je-missing-inq');
}
        });
        detailTable.draw(false);

        $('#totalDR').html(moneyFormatter.format(totalDR));
        $('#totalCR').html(moneyFormatter.format(totalCR));
        $('#totalDR, #totalCR').css('color', Math.abs(totalDR-totalCR)>=0.01?'red':'black');
    });

});

        const yearSelect = document.getElementById('filterYear');
        const startYear = 2000;
        const endYear = new Date().getFullYear(); // current year
        
        const y = document.getElementById('filterYear');
        const selectedYear = "{{ request('year') ?? '' }}"; // Get selected year from request
        for(let i=new Date().getFullYear(); i>=2000; i--) {
            let option = new Option(i, i);
            if(i == selectedYear) option.selected = true; // mark selected
            y.add(option);
        }
            y.dispatchEvent(new Event('change'));

        document.querySelectorAll('.ripple').forEach(button => {
            button.addEventListener('click', function(e) {
                const circle = document.createElement('span');
                circle.classList.add('ripple-circle');
                this.appendChild(circle);

                // Position the circle at click
                const rect = this.getBoundingClientRect();
                circle.style.left = e.clientX - rect.left - circle.offsetWidth/2 + 'px';
                circle.style.top  = e.clientY - rect.top - circle.offsetHeight/2 + 'px';

                circle.classList.add('ripple-animate');

                // Remove after animation
                circle.addEventListener('animationend', () => circle.remove());
            });
        });

        // Hamburger toggle
    const hamburger = document.getElementById('hamburger');
    const topMenu = document.getElementById('topMenu');
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active'); // animate X
        topMenu.classList.toggle('active');   // dropdown
    });

(function () {
    const form = document.getElementById('ramForm');
    const month = form.querySelector('select[name="month"]');
    const year  = form.querySelector('select[name="year"]');
    const error = document.getElementById('monthYearError');
    const buttons = form.querySelectorAll('button[type="submit"]');

    function isValid() {
        const hasMonth = month.value !== '';
        const hasYear  = year.value !== '';

        // valid if both empty OR both filled
        return (hasMonth && hasYear) || (!hasMonth && !hasYear);
    }

    function updateUI() {
        if (isValid()) {
            error.classList.add('d-none');
            buttons.forEach(b => {
                b.disabled = false;
                b.classList.remove('opacity-50');
            });
        } else {
            error.classList.remove('d-none');
            buttons.forEach(b => {
                b.disabled = true;
                b.classList.add('opacity-50');
            });
        }
    }

    // React when user changes month/year
    month.addEventListener('change', updateUI);
    year.addEventListener('change', updateUI);

    // Block submit just in case (extra safety)
    form.addEventListener('submit', function (e) {
        if (!isValid()) {
            e.preventDefault();
            updateUI();
        }
    });

    // Initial check on page load
    updateUI();
})();
    // // Reset form after submit/download
    // const form = document.getElementById('jeForm');

    // form.addEventListener('submit', function(e) {
    //     // Allow the form to submit first
    //     setTimeout(() => {
    //         form.reset(); // clear all fields
    //     }, 100); // small delay to ensure submit/download happens
    // });
</script>
</body>
</html>
