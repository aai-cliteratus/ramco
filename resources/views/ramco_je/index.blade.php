<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>RAMCO Inquiry</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="icon" type="image/png" href="{{ asset('img/favico.ico') }}">

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
        .sort-arrows {
            display: inline-block;
            vertical-align: middle;
            margin-left: 4px;
            font-size: 0.7rem;
            line-height: 0.6; /* stack closer */
        }

        .arrow-up,
        .arrow-down {
            display: block;
            color: #aaa; /* neutral gray */
        }

        /* Sorted ascending */
        .sortable.asc .arrow-up {
            color: #000; /* active black */
        }

        /* Sorted descending */
        .sortable.desc .arrow-down {
            color: #000; /* active black */
        }


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

.ocean-wave-btn1 {
    position: relative;
    overflow: hidden;
    color: #fff;
    background-color: #5f5d5dff;
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
.inner-shadow {
    text-shadow:
        0 2px 3px rgba(0,0,0,0.6),
        0 -1px 1px rgba(255,255,255,0.2);
}
/* Shadow when button appears */
#scrollTopBtn.show-shadow {
    box-shadow: 0 4px 12px rgba(0,0,0,0.4); /* darker shadow */
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}
    </style>
</head>
<body>
<!-- Top Bar with Hamburger -->
<div class="top-bar d-flex align-items-center justify-content-between px-4">
  <a href="./" class="inline-flex flex-col items-center gap-2 cursor-pointer">
    <img src="{{ asset('img/logo.png') }}" alt="Logo" height="40" class="logo-glow">
      </a>
    <h2 class="mb-0 text-white inner-shadow text-center">
      RAMCO Inquiry System
    </h2>



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
<div class="container-fluid px-3">
<h1 class="mt-3 pt-2 mb-4 text-center" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">
    Ramco JE Records
</h1>

<form action="{{ route('ramco_je.index') }}" method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-3" id="jeForm">
    <div class="d-flex flex-column">
        <label class="form-label fw-semibold">Doc No / Acct Code</label>
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
        <small id="monthYearError" class="text-danger d-none">
            Month and Year must be selected together.
        </small>
    </div>

    <div class="d-flex gap-2 mt-auto">
        <button type="submit" class="btn btn-secondary ripple ocean-wave-btn">
            Submit
        </button>

        <button
            type="submit"
            formaction="{{ route('ramco_je.export') }}"
            class="btn btn-secondary ripple ocean-wave-btn1">
            Excel
        </button>
    </div>
</form>
<!-- Card Wrapper -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">
            <h5 class="mb-0">JE</h5>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0" id="inqTable">
                    <thead>
                        <tr>
                            <th class="sortable" data-col="0" style="background-color: #faf8f8ff;">
                                GL Number
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="1" style="background-color: #faf8f8ff;">
                                JE Number
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="2" style="background-color: #faf8f8ff;">
                                Account Code
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="3" style="background-color: #faf8f8ff;">
                                PHP Amount<br>
                                <small>Total: <span id="drTotal">0.00</span></small>
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="4" style="background-color: #faf8f8ff;">
                                USD Amount<br>
                                <small>Total: <span id="crTotal">0.00</span></small>
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="5" style="background-color: #faf8f8ff;">Exrate
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="6" style="background-color: #faf8f8ff;">Account Type
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="7" style="background-color: #faf8f8ff;">Fiscal Period
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="8" style="background-color: #faf8f8ff;">Fiscal Year
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="9" style="background-color: #faf8f8ff;">Prepared By
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="10" style="background-color: #faf8f8ff;">Approved By
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="11" style="background-color: #faf8f8ff;">JE Remarks
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="12" style="background-color: #faf8f8ff;">Entry Date
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                            <th class="sortable" data-col="13" style="background-color: #faf8f8ff;">Effective Date
                                <span class="sort-arrows">
                                    <span class="arrow-up">▲</span>
                                    <span class="arrow-down">▼</span>
                                </span>
                            </th>
                        </tr>

                        <tr>
                            @foreach(range(1,14) as $i)
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
                            <td>
                                {{ \Carbon\Carbon::parse($inq->entry_date)->format('M d, Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($inq->effective_date)->format('M d, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<div id="loadMoreSpinner" class="text-center my-3" style="display:none;">
    <div class="spinner-border text-primary"></div>
</div>

<input type="hidden" id="nextPageUrl" value="{{ $inqs->nextPageUrl() }}">
</div>

<button id="scrollTopBtn" class="show-shadow">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <rect x="10" y="6" width="4" height="12" rx="1" ry="1"/>
    <polygon points="12,2 18,10 6,10"/>
  </svg>
</button>

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
const selectedYear = "{{ request('year') ?? '' }}"; // Get selected year from request
for(let i=new Date().getFullYear(); i>=2000; i--) {
    let option = new Option(i, i);
    if(i == selectedYear) option.selected = true; // mark selected
    y.add(option);
}

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

    // // Reset form after submit/download
    // const form = document.getElementById('jeForm');

    // form.addEventListener('submit', function(e) {
    //     // Allow the form to submit first
    //     setTimeout(() => {
    //         form.reset(); // clear all fields
    //     }, 100); // small delay to ensure submit/download happens
    // });
    (function () {
    const form = document.getElementById('jeForm');
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
</script>

</body>
</html>
