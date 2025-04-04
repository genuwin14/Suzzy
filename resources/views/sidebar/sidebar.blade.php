<!-- Sidebar -->
<div class="sidebar collapsed" id="sidebar">
    <!-- Navbar brand moved here with key icon -->
    <a class="navbar-brand" href="{{ route('admin.dashboard') }}"> 
        <i class="fa-solid fa-key"></i>
        <!-- <i class="fas fa-key d-inline d-sm-none"></i> -->
        <!-- <span class="d-none d-sm-inline ms-2">Key Cabinet</span> -->
        <span class="key ms-2 text-white">Key Cabinet</span>
    </a>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-chart-simple" style="color: #fcb315; margin-right: 20px;"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.list') }}">
                <i class="fas fa-users" style="color: #fcb315; margin-right: 15px;"></i> <span>Faculty List</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.labkeys') }}">
                <i class="fa-solid fa-key" style="color: #fcb315; margin-right: 19px;"></i> <span>LabKeys</span>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.createFaculty') }}">
                <i class="fas fa-user-plus"></i> <span>Registration</span>
            </a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.log') }}">
                <i class="fa-solid fa-address-card" style="color: #fcb315; margin-right: 19px;"></i> <span>Logs</span>
            </a>
        </li>
    </ul>
</div>