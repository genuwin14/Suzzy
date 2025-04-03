@extends('admin.app')

@section('title', 'Key Cabinet - Dashboard')

@section('admincontent')

<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">

<!-- <style>
    #darkModeContainer {
        bottom: 50px !important; /* Moves it higher from the bottom */
        right: 25px;
        z-index: 1050;
    }

    #darkModeToggle {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s;
    }

    #darkModeToggle:hover {
        transform: scale(1.1);
    }
</style> -->

<!-- Include FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="container-fluid" id="content">
    <div class="row">
        <!-- Big Card on the Left -->
        <div class="col-md-8 mb-3">
            <div class="card big-card mb-4">
                <img src="{{ asset('images/CCSLogo2.png') }}" alt="CCS Logo">
            </div>
        </div>

        <!-- Three Small Cards on the Right -->
        <div class="col-md-4 mb-4">
            <!-- Faculty Registered -->
            <div class="card small-card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-user-graduate icon"></i> Faculty Registered
                    </h5>
                    <p class="data-value">{{ $facultyCount }}</p>
                    <p class="card-text">Total faculty members registered.</p>
                </div>
            </div>

            <!-- Recently Borrowed -->
            <div class="card small-card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-door-closed icon"></i> Faculty Borrowed
                    </h5>
                    <ul class="recent-list">
                        @forelse ($recentFacultyBorrowed as $log)
                            <li>
                                <i class="fa-solid fa-user"></i> 
                                {{ $log->faculty ? $log->faculty->fname . ' ' . $log->faculty->lname : 'Unknown Faculty' }} 
                                - {{ \Carbon\Carbon::parse($log->date_time_borrowed)->format('M d, Y h:i A') }}
                            </li>
                        @empty
                            <li>No recent borrows</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Borrowed Keys with Laboratory -->
            <div class="card small-card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-key icon"></i> Borrowed Keys
                    </h5>
                    <ul class="recent-list">
                        @forelse ($recentBorrowedKeys as $log)
                            <li>
                                <i class="fa-solid fa-door-open"></i> 
                                {{ $log->labKey ? $log->labKey->laboratory : 'Unknown Lab' }} 
                                ({{ $log->faculty ? $log->faculty->fname . ' ' . $log->faculty->lname : 'Unknown Faculty' }})
                            </li>
                        @empty
                            <li>No borrowed keys</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
