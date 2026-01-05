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
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }
        .btn:hover {
            box-shadow: 0 6px 14px rgba(0,0,0,0.2);
            transform: translateY(-2px);
        }

        /* Table shadow */
        #inqTable {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        #inqTable thead tr {
            background-color: #f8f9fa;
            box-shadow: inset 0 -1px 0 rgba(0,0,0,0.1);
        }

        #inqTable tbody tr:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        /* Top Bar */
        .top-bar {
            position: sticky;
            top: 0;
            width: 100%;
            height: 60px;
            background-color: #0d6efd;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .top-bar h1 {
            color: white;
            font-size: 1.25rem;
            margin: 0;
        }

        /* Hamburger */
        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 25px;
            height: 18px;
            cursor: pointer;
        }

        .hamburger span {
            display: block;
            height: 3px;
            width: 100%;
            background: white;
            border-radius: 2px;
        }

        /* Top Menu */
        .top-menu {
            position: absolute;
            top: 60px;
            right: 0;
            background-color: #0d6efd;
            display: none;
            flex-direction: column;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            border-radius: 0 0 6px 6px;
        }

        .top-menu a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.5s;
        }

        .top-menu a:hover {
            color: #bccaf7ff;
            background-color: transparent;
        }

        .top-menu.active {
            display: flex;
        }

        @media (min-width: 768px) {
            .hamburger { display: none; }
            .top-menu {
                position: static;
                display: flex !important;
                flex-direction: row;
                background: transparent;
                box-shadow: none;
                border-radius: 0;
            }
            .top-menu a { padding: 0 15px; }
        }

.ocean-wave-btn {
    position: relative;
    overflow: hidden;
    color: #fff;
    background-color: #0d6efd;
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
    animation: waveScroll 3s linear infinite;
}

/* Infinite horizontal scroll */
@keyframes waveScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); } /* scroll exactly half width */
}
.ocean-wave-btn {
    position: relative;
    overflow: hidden;
    color: #fff;
    /* background-color: #0d6efd; */
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

.ocean-wave-btn1 {
    position: relative;
    overflow: hidden;
    color: #fff;
    border: none;
    padding: 0.6rem 1.5rem;
    font-size: 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
}

/* Wave at the bottom */
.ocean-wave-btn1::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 200%;           /* double width for seamless scroll */
    height: 12px;          /* wave height */
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="200" height="12"><path fill="%23ffffff" d="M0 6 C25 0 50 12 75 6 C100 0 125 12 150 6 C175 0 200 12 200 6 V12 H0 Z"/></svg>') repeat-x;
    opacity: 0.4;
    animation: waveScroll1 5s linear infinite;
}

/* Infinite horizontal scroll */
@keyframes waveScroll1 {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); } /* scroll exactly half width */
}

    </style>
</head>
<body>

<!-- Top Bar with Hamburger -->
<div class="top-bar d-flex align-items-center justify-content-between px-4">
    <h2 class="mb-0 text-white">RAMCO Inquiry System</h2>

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
    </div>
</div>

<div class="container-fluid px-3">
<h1 class="mb-4 text-center" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">Ramco INQ Records</h1>

<form action="{{ route('ramco_inq.index') }}" method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-3" id="inqForm">
    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Doc No. / Acct Code</label>
        <input type="text" class="form-control" name="doc_no">
    </div>

    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Doc Ref Type</label>
        <input type="text" class="form-control" name="doc_ref1_type">
    </div>

    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Doc Ref</label>
        <input type="text" class="form-control" name="doc_ref1">
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

    <div class="d-flex gap-2 mt-auto">
        <button type="submit" class="btn btn-primary ripple ocean-wave-btn">Submit</button>
        <button type="submit" formaction="{{ route('ramco_inq.export') }}" class="btn btn-success ripple ocean-wave-btn1">Excel</button>
    </div>
</form>

<table class="table table-bordered table-striped" id="inqTable">
    <thead>
    <tr>
        <th class="sortable" data-col="0">HDR No</th>
        <th class="sortable" data-col="1">Finance Book</th>
        <th class="sortable" data-col="2">Account Code</th>
        <th class="sortable" data-col="3">DR<br><small>Total: <span id="drTotal">0.00</span></small></th>
        <th class="sortable" data-col="4">CR<br><small>Total: <span id="crTotal">0.00</span></small></th>
        <th class="sortable" data-col="5">Trans Type</th>
        <th class="sortable" data-col="6">Cost Center</th>
        <th class="sortable" data-col="7">Analysis Code</th>
        <th class="sortable" data-col="8">Sub Analysis</th>
        <th class="sortable" data-col="9">Doc Ref Type</th>
        <th class="sortable" data-col="10">Doc Ref</th>
        <th class="sortable" data-col="11">Month</th>
        <th class="sortable" data-col="12">Year</th>
        <th class="sortable" data-col="13">Supplier Code</th>
        <th class="sortable" data-col="14">Supplier Name</th>
        <th class="sortable" data-col="15">Remarks</th>
        <th class="sortable" data-col="16">Created By</th>
    </tr>

    <tr>
    @foreach(range(1,17) as $i)
        <th><input class="column-search" data-col="{{ $i-1 }}" placeholder="Search"></th>
    @endforeach
    </tr>
    </thead>

    <tbody id="inqTableBody">
    @foreach($inqs as $inq)
    <tr>
        <td>{{ $inq->hdr_no }}</td>
        <td>{{ $inq->finance_book }}</td>
        <td>{{ $inq->acct_code }}</td>
        <td class="text-end">{{ $inq->php_amt > 0 ? number_format($inq->php_amt,2) : '' }}</td>
        <td class="text-end">{{ $inq->php_amt < 0 ? number_format(abs($inq->php_amt),2) : '' }}</td>
        <td>{{ $inq->trans_type }}</td>
        <td>{{ $inq->cost_center }}</td>
        <td>{{ $inq->analysis_code }}</td>
        <td>{{ $inq->sub_analysis_code }}</td>
        <td>{{ $inq->doc_ref1_type }}</td>
        <td>{{ $inq->doc_ref1 }}</td>
        <td>{{ $inq->month }}</td>
        <td>{{ $inq->year }}</td>
        <td>{{ $inq->supplier_code }}</td>
        <td>{{ $inq->supplier_name }}</td>
        <td>{{ $inq->narration }}</td>
        <td>{{ $inq->created_by }}</td>
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
        if ($(this).scrollTop() > $(window).height()) { $('#scrollTopBtn').fadeIn(); } 
        else { $('#scrollTopBtn').fadeOut(); }

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
                recalcTotals();
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

    const y = document.getElementById('filterYear');
    for (let i = new Date().getFullYear(); i >= 2000; i--) y.add(new Option(i,i));

    document.querySelectorAll('.ripple').forEach(button => {
        button.addEventListener('click', function(e) {
            const circle = document.createElement('span');
            circle.classList.add('ripple-circle');
            this.appendChild(circle);
            const rect = this.getBoundingClientRect();
            circle.style.left = e.clientX - rect.left - circle.offsetWidth/2 + 'px';
            circle.style.top  = e.clientY - rect.top - circle.offsetHeight/2 + 'px';
            circle.classList.add('ripple-animate');
            circle.addEventListener('animationend', () => circle.remove());
        });
    });

    // Hamburger toggle
    const hamburger = document.getElementById('hamburger');
    const topMenu = document.getElementById('topMenu');
    hamburger.addEventListener('click', () => topMenu.classList.toggle('active'));
});

    // Reset form after submit/download
    const form = document.getElementById('inqForm');

    form.addEventListener('submit', function(e) {
        // Allow the form to submit first
        setTimeout(() => {
            form.reset(); // clear all fields
        }, 100); // small delay to ensure submit/download happens
    });
</script>
</body>
</html>
