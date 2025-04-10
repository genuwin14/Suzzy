@extends('admin.app')

@section('title', 'Key Cabinet - Faculty List')

@section('admincontent')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-2">
        <h2>Faculty List</h2>
        <!-- Search Bar -->
        <input type="text" id="search-bar" class="form-control" placeholder="Search Faculty..." style="width: 250px;">
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Faculty ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="faculty-table-body">
            @forelse ($faculty as $member)
            <tr>
                <td>{{ $member->faculty_id }}</td>
                <td>{{ $member->fname }} {{ $member->mname }} {{ $member->lname }} {{ $member->suffix }}</td>
                <td>{{ $member->role_type}}</td>
                <td>
                    <!-- Toggle Status Button -->
                    <button type="button" class="btn btn-sm {{ $member->status === 'Enabled' ? 'btn-success' : 'btn-danger' }} toggle-status-btn"
                        data-faculty-id="{{ $member->faculty_id }}"
                        data-status="{{ $member->status }}">
                        {{ $member->status === 'Enabled' ? 'Enabled' : 'Disabled' }}
                    </button>

                    <form id="toggle-form-{{ $member->faculty_id }}" action="{{ route('admin.toggleStatus', $member->faculty_id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('PATCH')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No faculty members registered yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Search Bar functionality
        const searchBar = document.getElementById("search-bar");
        searchBar.addEventListener("input", function() {
            let searchValue = searchBar.value.toLowerCase();
            let rows = document.querySelectorAll("#faculty-table-body tr");

            rows.forEach(function(row) {
                let columns = row.getElementsByTagName("td");
                let name = columns[1].textContent.toLowerCase(); // Name column
                let facultyId = columns[0].textContent.toLowerCase(); // Faculty ID column

                if (name.includes(searchValue) || facultyId.includes(searchValue)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        document.querySelectorAll(".toggle-status-btn").forEach(button => {
            button.addEventListener("click", function() {
                let facultyId = this.getAttribute("data-faculty-id");
                let currentStatus = this.getAttribute("data-status");
                let newStatus = currentStatus === "Enabled" ? "Disabled" : "Enabled";
                
                let actionText = newStatus === "Enabled" 
                    ? `Do you want to enable Faculty ID: ${facultyId}?`
                    : `Are you sure you want to disable Faculty ID: ${facultyId}?`;

                let confirmButtonText = newStatus === "Enabled" ? "Yes, Enable it!" : "Yes, Disable it!";
                
                Swal.fire({
                    title: "Confirm Status Change",
                    text: actionText,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: newStatus === "Enabled" ? "#28a745" : "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: confirmButtonText,
                    customClass: {
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title',
                        content: 'custom-swal-content',
                        confirmButton: 'custom-swal-confirm-button',
                        cancelButton: 'custom-swal-cancel-button'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`toggle-form-${facultyId}`).submit();
                    }
                });
            });
        });

        // Retrieve Laravel session messages and show SweetAlert2
        @if(session('success'))
            Swal.fire({
                title: "Success!",
                text: @json(session('success')),
                icon: "success",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                confirmButtonColor: "#28a745",
                customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    content: 'custom-swal-content',
                    confirmButton: 'custom-swal-confirm-button',
                    timerProgressBar: 'custom-timer-progress-bar' // Custom class for progress bar
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: "Error!",
                text: @json(session('error')),
                icon: "error",
                confirmButtonColor: "#d33",
                customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    content: 'custom-swal-content',
                    confirmButton: 'custom-swal-confirm-button'
                }
            });
        @endif
    });
</script>

<!-- Media Queries for SweetAlert2 Styling -->
<style>
    /* Default styles for SweetAlert2 popups */
    .custom-swal-popup {
        width: 500px; /* Default size */
        font-size: 16px;
    }

    .custom-swal-title {
        font-size: 20px;
    }

    .custom-swal-content {
        font-size: 16px;
    }

    .custom-swal-confirm-button,
    .custom-swal-cancel-button {
        font-size: 14px;
        padding: 10px 20px;
    }

    /* Custom progress bar color */
    .custom-timer-progress-bar {
        background-color: #28a745 !important; /* Green color */
    }

    /* Optional: You can customize other aspects of the progress bar as well */
    .swal2-timer-progress-bar {
        height: 4px; /* Adjust height if needed */
        background-color: #28a745 !important; /* Green color */
    }

    /* Optional: Search bar styling */
    #search-bar {
        margin-right: 20px;
    }
</style>

@endsection
