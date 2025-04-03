@extends('admin.app')

@section('title', 'Key Cabinet - Laboratory Keys')

@section('admincontent')
<style>
    .key-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        max-width: 100%;
    }

    .key-card {
        width: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        background: white;
        cursor: pointer;
    }

    .key-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .status-badge {
        font-size: 1rem;
        padding: 5px 10px;
        border-radius: 5px;
    }

    /* Modal Styling for Responsive Design */
    .modal-content {
        border-radius: 10px;
    }

    .modal-body p {
        font-size: 16px;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .modal-dialog {
            max-width: 90%;
            margin: auto;
        }

        .modal-body p {
            font-size: 14px;
        }

        .modal-title {
            font-size: 18px;
        }

        .modal-footer button {
            font-size: 14px;
            padding: 8px 15px;
        }
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-2">
        <h2>Lab Keys</h2>
    </div>

    <div class="key-container mb-5">
        @forelse ($groupedLabKeys as $laboratory => $keys)
            @foreach ($keys as $labKey)
                <div class="card key-card" data-bs-toggle="modal" data-bs-target="#keyModal" 
                     data-key-id="{{ $labKey->key_id }}" 
                     data-status="{{ $labKey->status }}"
                     data-laboratory="{{ $labKey->laboratory }}"
                     data-faculty="{{ $labKey->faculty_name }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $labKey->key_id }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $laboratory }}</h6>
                        <span class="badge status-badge {{ $labKey->status === 'Borrowed' ? 'bg-danger' : 'bg-success' }}">
                            {{ $labKey->status }}
                        </span>
                    </div>
                </div>
            @endforeach
        @empty
            <p class="text-center w-100">No keys record yet.</p>
        @endforelse
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="keyModal" tabindex="-1" aria-labelledby="keyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="keyModalLabel">Key Details - <span id="modalLaboratory"></span></h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body text-dark">
                <p><strong>Key ID:</strong> <span id="modalKeyId"></span></p>
                <!-- <p><strong>Laboratory:</strong> <span id="modalLaboratory"></span></p> -->
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                <p><strong>Borrowed By:</strong> <span id="modalFaculty"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var keyModal = document.getElementById("keyModal");
        keyModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget;
            var keyId = button.getAttribute("data-key-id");
            var laboratory = button.getAttribute("data-laboratory");
            var status = button.getAttribute("data-status");
            var faculty = button.getAttribute("data-faculty");

            document.getElementById("modalKeyId").textContent = keyId;
            document.getElementById("modalLaboratory").textContent = laboratory;
            document.getElementById("modalStatus").textContent = status;
            document.getElementById("modalFaculty").textContent = faculty;
        });
    });
</script>

@endsection
