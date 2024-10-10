<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
    {{-- <li>
        <a href="/admin/dashboard" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-house-door-fill"></i> <span class="ms-1 d-none d-sm-inline text-white">Dashboard</span> 
        </a>

    </li> --}}
    <li>          
        <a href="/superadmin/user_management" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-person-fill-add"></i> <span class="ms-1 d-none d-sm-inline text-white">User Management</span>
        </a>
    </li>
    <li>                           
        <a href="/superadmin/system_config" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-gear-wide-connected"></i> <span class="ms-1 d-none d-sm-inline text-white">System Configuration</span>
        </a>
    </li>
    <li>                           
        <a href="{{route('superadmin.logout')}}">
            <button type="button" class="btn btn-outline-light col-md-12 mb-3"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </a>
    </li>
    
</ul>