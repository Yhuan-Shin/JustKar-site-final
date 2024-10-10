<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu" 
">
    <li>
        <a href="/admin/dashboard" class="nav-link px-0 align-middle text-decoration-none">
            <i class="fs-4 bi bi-house-door-fill" style="color: #DC3545"></i> <span class="ms-1 d-none d-sm-inline text-white">Dashboard</span> 
        </a>

    </li>
    <li>
        <a href="/admin/products" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-bag-check-fill" style="color: #DC3545"></i> <span class="ms-1 d-none d-sm-inline text-white">Products</span>
        </a>
    </li>
    <li>                           
        <a href="/admin/sales" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-receipt-cutoff" style="color: #DC3545"></i> <span class="ms-1 d-none d-sm-inline text-white">Sales Logs</span>
        </a>
    </li>
    <li>                           
        <a href="/admin/user_management" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-person-fill-add" style="color: #DC3545"></i> <span class="ms-1 d-none d-sm-inline text-white">User Management</span>
        </a>
    </li>
    <li>                           
        <a href="/admin/announcements" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-megaphone-fill" style="color:#DC3545"></i> <span class="ms-1 d-none d-sm-inline text-white">Announcements</span>
        </a>
    </li>
    <li>                           
        <a href="/admin/inventory" class="nav-link px-0 align-middle">
            <i class="fs-4 bi bi-box-seam-fill" style="color:#DC3545"></i> <span class="ms-1 d-none d-sm-inline text-white">Inventory</span>
        </a>
    </li>
    <li>
        <a data-bs-toggle="modal" data-bs-target="#logoutModal" class="nav-link px-0 align-middle col-md-12">
           <button class="btn btn-danger col-md-12 d-flex align-items-center">
            <i class="fs-4 bi bi-box-arrow-right" style="color: white"></i> <span class="ms-1 d-none d-sm-inline">Logout</span>
           </button>
        </a>

        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-dark" id="logoutModalLabel" >Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-dark">
                Are you sure you want to logout?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="{{ route('user.logout') }}">
                    <button type="button" class="btn btn-danger">Logout</button>
                </a>
              </div>
            </div>
          </div>
        </div>
    </li>
</ul>