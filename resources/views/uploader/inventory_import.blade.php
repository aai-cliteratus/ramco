<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Inventory Master Import</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
/* Top Bar */
.top-bar {
    position: sticky;
    top: 0;
    width: 100%;
    height: 60px;
    background-color: #a3a3a3ff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1rem;
    z-index: 1000;
}
.hamburger { display: flex; flex-direction: column; justify-content: space-between; width: 25px; height: 18px; cursor: pointer; }
.hamburger span { display: block; height: 3px; background: #fff; border-radius: 2px; }
.top-menu { position: absolute; top: 60px; right: 0; background-color: #a3a3a3ff; display: none; flex-direction: column; width: 200px; }
.top-menu a { color: #fff; padding: 10px 20px; text-decoration: none; }
.top-menu a:hover { background-color: rgba(255,255,255,0.1); }
.top-menu.active { display: flex; }
@media (min-width: 1001px) {
    .hamburger { display: none; }
    .top-menu { position: static; display: flex !important; flex-direction: row; width: auto; background: transparent; }
    .top-menu a { padding: 0 15px; }
}
.inner-shadow { text-shadow: 0 2px 3px rgba(0,0,0,0.6); }

.uploader-link {
    font-weight: bold;
    color: black;           /* default color */
    text-decoration: none;
    transition: color 0.3s ease; /* smooth color change */
}

.uploader-link:hover {
    color: gray;
}
</style>
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <a href="/" class="d-flex align-items-center"><img src="{{ asset('img/logo.png') }}" height="40"></a>
    <h5 class="mb-0 text-white inner-shadow text-center">Direct Uploader Management</h5>
    <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    <div class="top-menu" id="topMenu">
        <a href="/uploader" class="uploader-link">Uploader</a>
    </div>
</div>

<!-- CONTENT -->
<div class="container mt-4">

    <h3 class="text-center mb-4" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">
        Inventory Master With Serial Uploader – Excel Import
    </h3>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <!-- Upload Form -->
            <form action="{{ route('uploader.inventory_import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Excel File (.xls / .xlsx)</label>
                    <input type="file" name="file" class="form-control" accept=".xls,.xlsx" required>
                </div>
                <button type="submit" class="btn btn-primary">Import Inventory</button>
            </form>

            <hr>

            <!-- Display Uploaded Data -->
@if(isset($uploadedInventory) && $uploadedInventory->count())
    <h5 class="mt-4">Uploaded Inventory (latest upload {{$uploadedInventory->count()}} rows)</h5>
    <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
        <table class="table table-bordered table-striped table-sm mb-0">
            <thead class="table-light" style="position: sticky; top: 0; z-index: 10; background-color: #f8f9fa;">
                <tr>
                    <th>GR Reference</th>
                    <th>GR Date</th>
                    <th>Item Code</th>
                    <th>Description</th>
                    <th>Total Quantity</th>
                    <th>Available Quantity</th>
                    <th>Used Quantity</th>
                    <th>For Repair</th>
                    <th>Retired</th>
                    <th>Treatment</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($uploadedInventory as $row)
                    <tr>
                        <td>{{ $row->gr_reference }}</td>
                        <td>{{ $row->gr_date }}</td>
                        <td>{{ $row->item_code }}</td>
                        <td>{{ $row->item_desc }}</td>
                        <td class="text-end">{{ $row->rcv_qty }}</td>
                        <td class="text-end">{{ $row->onhand_qty }}</td>
                        <td class="text-end">{{ $row->used }}</td>
                        <td class="text-end">{{ $row->for_repair }}</td>
                        <td class="text-end">{{ $row->retired }}</td>
                        <td class="text-end">{{ $row->treatment }}</td>
                        <td class="text-end">{{ $row->unit_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@if(isset($uploadedSerial) && $uploadedSerial->count())
    <h5 class="mt-4">Uploaded Serials (latest {{$uploadedSerial->count()}} rows)</h5>
    <div class="table-responsive" style="max-height:300px; overflow-y:auto;">
        <table class="table table-bordered table-striped table-sm mb-0">
            <thead class="table-light" style="position: sticky; top: 0; z-index: 10; background-color: #f8f9fa;">
                <tr>
                    <th>Inventory ID</th>
                    <th>Serial No</th>
                    <th>Warranty No</th>
                    <th>Expiry</th>
                    <th>Lot No</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($uploadedSerial as $row)
                    <tr>
                        <td>{{ $row->inv_id }}</td>
                        <td>{{ $row->serial_no }}</td>
                        <td>{{ $row->warranty_no }}</td>
                        <td class="text-end">{{ $row->expiry }}</td>
                        <td class="text-end">{{ $row->lot_no }}</td>
                        <td class="text-end">{{ $row->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif


            <h6 class="mt-3">Expected Inventory Master Excel Columns</h6>
            <table class="table table-bordered table-sm w-75">
                <thead class="table-light">
                    <tr>
                        <th style="background-color:#00A300">gr_reference</th>
                        <th>gr_date</th>
                        <th>item_code</th>
                        <th>item_desc</th>
                        <th>rcv_qty</th>
                        <th>onhand_qty</th>
                        <th>used</th>
                        <th>for_repair</th>
                        <th>retired</th>
                        <th>rcv_uom</th>
                        <th>expiry_date</th>
                        <th>treatment</th>
                        <th>unit_price</th>
                        <th>remarks</th>
                        <th style="background-color:#00D100">line_number</th>
                        <th>ou_code</th>
                    </tr>
                </thead>
            </table>

            <h6 class="mt-3">Expected Serial Excel Columns</h6>
            <table class="table table-bordered table-sm w-75">
                <thead class="table-light">
                    <tr>
                        <th style="background-color:#00A300">gr_reference</th>
                        <th style="background-color:#00D100">line_number</th>
                        <th>serial_no</th>
                        <th>warranty_no</th>
                        <th>expiry</th>
                        <th>lot_no</th>
                        <th>status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
$('#hamburger').on('click', function () {
    $('#topMenu').toggleClass('active');
});
</script>

</body>
</html>
