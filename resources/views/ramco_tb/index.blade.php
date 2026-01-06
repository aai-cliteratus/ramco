<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>RAMCO TB Inquiry</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="icon" type="image/png" href="{{ asset('img/favico.ico') }}">

<style>
.column-search { width: 100%; font-size: 0.8rem; padding: 2px 4px; }
.sortable { cursor: pointer; user-select: none; }
.sort-arrows { display: inline-block; vertical-align: middle; margin-left: 4px; font-size: 0.7rem; line-height: 0.6; }
.arrow-up, .arrow-down { display: block; color: #aaa; }
.sortable.asc .arrow-up { color: #000; }
.sortable.desc .arrow-down { color: #000; }
#scrollTopBtn { display: none; position: fixed; bottom: 30px; right: 30px; z-index: 9999; border: none; background: #0d6efd; color: #fff; padding: 10px 14px; border-radius: 50%; font-size: 18px; cursor: pointer; }
#inqTable tbody tr { transition: all 0.15s ease-in-out; }
#inqTable tbody tr:hover { background-color: #eef5ff !important; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
/* Top Bar */
.top-bar {
    position: sticky;
    top: 0;
    width: 100%;
    height: 60px;
    background-color: #a3a3a3ff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    z-index: 1000;
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

/* Top Menu (hidden by default) */
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
    transition: color 0.5s; /* smooth color transition */
}

.top-menu a:hover {
    color: #bccaf7ff; /* change text color on hover */
    background-color: transparent; /* keep background unchanged */
}


/* Show menu when active */
.top-menu.active {
    display: flex;
}

/* Responsive: always visible on large screens */
@media (min-width: 768px) {
    .hamburger {
        display: none;
    }
    .top-menu {
        position: static;
        display: flex !important;
        flex-direction: row;
        background: transparent;
        box-shadow: none;
        border-radius: 0;
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
    Ramco TB Records
</h1>

<form action="{{ route('ramco_tb.index') }}" method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-3" id="tbForm">
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
        <button type="submit" class="btn btn-secondary ripple ocean-wave-btn">Submit</button>
        <button type="submit" formaction="{{ route('ramco_tb.export') }}" class="btn btn-secondary ripple ocean-wave-btn1">Excel</button>
    </div>
</form>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-light fw-bold"><h5 class="mb-0">TB</h5></div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0" id="inqTable">
                <thead>
                    <tr>
                        <th class="sortable" data-col="0">Account Code
                            <span class="sort-arrows"><span class="arrow-up">▲</span><span class="arrow-down">▼</span></span>
                        </th>
                        <th class="sortable" data-col="1">Account Description
                            <span class="sort-arrows"><span class="arrow-up">▲</span><span class="arrow-down">▼</span></span>
                        </th>
                        <th class="sortable" data-col="2">DR Amount (PHP) <span id="drTotalHeader">(0.00)</span>
                            <span class="sort-arrows"><span class="arrow-up">▲</span><span class="arrow-down">▼</span></span>
                        </th>
                        <th class="sortable" data-col="3">CR Amount (PHP) <span id="crTotalHeader">(0.00)</span>
                            <span class="sort-arrows"><span class="arrow-up">▲</span><span class="arrow-down">▼</span></span>
                        </th>
                    </tr>
                    <tr>
                        @foreach(range(0,3) as $i)
                            <th><input class="column-search" data-col="{{ $i }}" placeholder="Search"></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="inqTableBody">
                    @foreach($inqs as $inq)
                    <tr>
                        <td>{{ $inq->acct_code }}</td>
                        <td>{{ $inq->acct_desc }}</td>
                        <td class="text-end">{{ $inq->DR !== null ? number_format($inq->DR,2) : '0.00' }}</td>
                        <td class="text-end">{{ $inq->CR !== null ? number_format($inq->CR,2) : '0.00' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<button id="scrollTopBtn">↑</button>

<script>
$(function() {

    function recalcTotals() {
        let dr=0, cr=0;
        $('#inqTableBody tr:visible').each(function(){
            let drVal = parseFloat($(this).find('td').eq(2).text().replace(/,/g,''))||0;
            let crVal = parseFloat($(this).find('td').eq(3).text().replace(/,/g,''))||0;

            dr += drVal;
            cr += crVal;

            // Optional: ensure blank cells display 0
            if($(this).find('td').eq(2).text().trim() === '') $(this).find('td').eq(2).text('0.00');
            if($(this).find('td').eq(3).text().trim() === '') $(this).find('td').eq(3).text('0.00');
        });

        $('#drTotalHeader').text(`(${dr.toLocaleString(undefined,{minimumFractionDigits:2})})`);
        $('#crTotalHeader').text(`(${cr.toLocaleString(undefined,{minimumFractionDigits:2})})`);
    }

    recalcTotals();

    // Column search
    $('.column-search').on('keyup', function() {
        let col=$(this).data('col');
        let val=$(this).val().toLowerCase();
        $('#inqTableBody tr').each(function(){
            $(this).toggle($(this).find('td').eq(col).text().toLowerCase().includes(val));
        });
        recalcTotals();
    });

    // Sorting
    $('.sortable').on('click', function() {
        let col=$(this).data('col');
        let asc=!$(this).hasClass('asc');
        $('.sortable').removeClass('asc desc');
        $(this).addClass(asc?'asc':'desc');
        let rows=$('#inqTableBody tr').get().sort(function(a,b){
            let A=$(a).children().eq(col).text().replace(/,/g,'') || '0';
            let B=$(b).children().eq(col).text().replace(/,/g,'') || '0';
            return asc? A.localeCompare(B,undefined,{numeric:true}): B.localeCompare(A,undefined,{numeric:true});
        });
        $('#inqTableBody').append(rows);
        recalcTotals();
    });

    $('#scrollTopBtn').click(()=> $('html,body').animate({scrollTop:0},500));

    const y = document.getElementById('filterYear');
    const selectedYear = "{{ request('year') ?? '' }}"; // Get selected year from request
    for(let i=new Date().getFullYear(); i>=2000; i--) {
        let option = new Option(i, i);
        if(i == selectedYear) option.selected = true; // mark selected
        y.add(option);
    }

});

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
</script>

</body>
</html>
