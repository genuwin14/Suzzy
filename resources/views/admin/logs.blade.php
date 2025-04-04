@extends('admin.app')

@section('title', 'Key Cabinet - Access Logs')

@section('admincontent')

<link rel="stylesheet" href="{{ asset('css/admin/logs.css') }}">

<!-- Include DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<div class="container-fluid">
    <h2>Logs</h2>

    <div class="table-responsive logs-table-wrapper">
        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
            <div class="d-flex align-items-center gap-2 mb-2">
                <button id="printButton" class="btn btn-dark">
                    <i class="fa-regular fa-file-pdf"></i> Generate PDF
                </button>
                <input type="date" id="filterDate" class="form-control" style="width: 150px;">
                <input type="time" id="filterTime" class="form-control" style="width: 120px;">
                <button id="resetButton" class="btn btn-dark">Clear</button>
            </div>
            <div id="searchContainer"></div>
        </div>
        
        <div class="table-container">
            <table id="logsTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th class="col-date">DATE</th>
                        <th class="col-name">BORROWER'S NAME</th>
                        <th class="col-lab">LABORATORY</th>
                        <th class="col-details">DETAILS (LAB/TV)</th>
                        <th class="col-time">TIME BORROWED</th>
                        <th class="col-time">TIME RETURNED</th>
                        <th class="col-sig">Signature</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($log->date_time_borrowed)->format('M d, Y') }}</td>
                        <td>
                            @if ($log->faculty)
                                {{ $log->faculty->fname }} {{ $log->faculty->mname }} {{ $log->faculty->lname }} {{ $log->faculty->suffix }}
                            @else
                                Unknown Borrower
                            @endif
                        </td>
                        <td>{{ $log->labKey ? $log->labKey->laboratory : 'No Laboratory Assigned' }}</td>
                        <td>{{ $log->details ?? 'No Details' }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->date_time_borrowed)->format('h:i A') }}</td>
                        <td>{{ $log->date_time_returned ? \Carbon\Carbon::parse($log->date_time_returned)->format('h:i A') : 'N/A' }}</td>
                        <td></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No access logs record yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>  
</div>

<!-- JavaScript for PDF Export -->
<!-- <script src="{{ asset('js/report.js') }}" defer></script> -->
<script src="{{ asset('js/Report/header.js') }}" defer></script>
<script src="{{ asset('js/Report/footer.js') }}" defer></script>
<!-- <script src="{{ asset('js/Report/table.js') }}" defer></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<!-- JavaScript for DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script>
    $(document).ready(function () {
        var table = $('#logsTable').DataTable({
            paging: false, // Disable pagination
            searching: true,
            ordering: true,
            responsive: true,
            scrollY: "630px",
            scrollCollapse: true,
            lengthChange: false,
            language: {
                search: "", // remove the "Search:" label
                searchPlaceholder: "🔍 Search logs...",
                zeroRecords: "No matching records found",
                emptyTable: "No access logs record yet."
            }
        });

        // Move the search bar next to the filter buttons
        $('.dataTables_filter').appendTo('#searchContainer');

        // Custom filter function for date and hour-based time
        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            let filterDate = $('#filterDate').val();  // YYYY-MM-DD
            let filterTime = $('#filterTime').val();  // HH:MM (24-hour format)

            let rowDate = data[0]; // Get DATE column (e.g., Mar 26, 2025)
            let rowTime = data[4]; // Get TIME BORROWED column (e.g., 10:30 AM)

            // Convert row date to 'YYYY-MM-DD' format
            let formattedRowDate = moment(rowDate, 'MMM D, YYYY').format('YYYY-MM-DD');

            // Convert row time to "h A" (e.g., "10 AM", "3 PM")
            let formattedRowTime = moment(rowTime, 'h:mm A').format('h A');

            // Convert input time to "h A" format (ignoring minutes)
            let filterHour = filterTime ? moment(filterTime, 'HH:mm').format('h A') : '';

            // Check if date matches
            let dateMatch = !filterDate || filterDate === formattedRowDate;
            // Check if time matches (only hour & AM/PM)
            let timeMatch = !filterTime || filterHour === formattedRowTime;

            return dateMatch && timeMatch;
        });

        // Automatically apply filter when date or time changes
        $('#filterDate, #filterTime').on('change', function () {
            table.draw();
        });

        // Reset filters
        $('#resetButton').click(function () {
            $('#filterDate').val('');
            $('#filterTime').val('');
            table.search('').draw();
        });
    });
</script>

<script>
    document.getElementById('printButton').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({ orientation: 'landscape', format: 'legal' });

        let base64Logo = ""; 
        const logoImage = new Image();
        logoImage.src = base64Logo ? `data:image/png;base64,${base64Logo}` : '/images/cspc.png';

        logoImage.onload = function () {
            addTableWithHeaderAndFooter(pdf, logoImage);
            const pdfBlob = pdf.output('blob');
            const pdfUrl = URL.createObjectURL(pdfBlob);
            window.open(pdfUrl, '_blank');
        };
    });
</script>

<script>
    function addTableWithHeaderAndFooter(pdf, logoImage) {
        const table = document.getElementById("logsTable");
        const tableData = [];
        const headers = [];

        // Extract table headers
        table.querySelectorAll("thead tr th").forEach(th => {
            headers.push(th.innerText);
        });

        // Extract table body data
        table.querySelectorAll("tbody tr").forEach(tr => {
            const row = [];
            tr.querySelectorAll("td").forEach(td => {
                row.push(td.innerText);
            });
            tableData.push(row);
        });

        const rowsPerPage = 20; // Limit to 20 rows per page
        let isFirstPage = true;
        let currentPage = 1;
        let totalPages = Math.ceil(tableData.length / rowsPerPage);

        for (let i = 0; i < tableData.length; i += rowsPerPage) {
            let pageData = tableData.slice(i, i + rowsPerPage); // Get 20 rows per page
            
            if (!isFirstPage) pdf.addPage(); // Add new page after the first

            addHeader(pdf, logoImage);
            
            pdf.autoTable({
                head: [headers],
                body: pageData,
                theme: 'grid',
                startY: isFirstPage ? 40 : 40, // First page starts at 40, others at 20
                margin: { left: 12 },
                styles: { 
                    fontSize: 10, 
                    valign: 'middle', 
                    halign: 'center',
                    lineColor: [0, 0, 0], // Black border color
                    textColor: [0, 0, 0],
                    lineWidth: 0.05 // Thickness of table borders
                },
                columnStyles: { 
                    0: { cellWidth: 30 },  
                    1: { cellWidth: 80 }, 
                    2: { cellWidth: 33 }, 
                    3: { cellWidth: 60 }, 
                    4: { cellWidth: 40 }, 
                    5: { cellWidth: 40 } 
                },
                headStyles: { 
                    fontSize: 11, 
                    fontStyle: 'bold', 
                    fillColor: false, // Transparent background
                    textColor: [0, 0, 0], // Black text for contrast
                    lineColor: [0, 0, 0], // Black header border
                    lineWidth: 0.05
                }
            });

            addFooter(pdf, currentPage, totalPages);
            isFirstPage = false;
            currentPage++;
        }
    }
</script>

@endsection