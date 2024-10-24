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
        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <button type="button" class="btn btn-danger col-md-12 mb-3"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </a>

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title text-dark" id="logoutModalLabel">Confirm Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-dark">
                Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{route('superadmin.logout')}}" class="btn btn-danger">Confirm</a>
                </div>
            </div>
            </div>
        </div>
    </li>
    
</ul>