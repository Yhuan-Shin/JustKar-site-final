<div poll.3000ms>
  <div class="container mt-3">
    <div class="row d-flex justify-content-center">
      <div class="col-md-4 mb-2">
        <div class="card shadow" style="width: 18rem;" >
            <div class="card-body text-center">
              <img src="{{ asset('images/sales-icon.png') }}" alt="" class="img-fluid" style="width: 40px; height: 40px"> 
              <h5 class="card-title text-muted">Sales Overview</h4>
                <div class="container">
                  <div class="row">
                    <div class="col  rounded p-2 me-2 m-auto">
                      <h5 class="card-title text-muted">Today</h5>
                      <h6 class="card-text text-dark">₱{{ number_format($dailySales, 2) }}</h6>
                    </div>
                    <div class="col  rounded p-2  me-2 m-auto">
                      <h5 class="card-title text-muted">Week</h5>
                      <h6 class="card-text " style="white-space: nowrap;">₱{{ number_format($weeklySales, 2) }}</h6>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col  rounded p-2  me-2 m-auto">
                      <h5 class="card-title text-muted">Month</h5>
                      <h6 class="card-text " style="white-space: nowrap;">₱{{ number_format($monthlySales, 2) }}</h6>
                   </div>
                  <div class="col  rounded p-2  me-2 m-auto">
                  <h5 class="card-title text-muted">Total Sales</h5>
                  <h6 class="card-text " style="white-space: nowrap;">₱{{ number_format($totalSales, 2) }}</h6>
                </div>
                  </div>
              </div>
            </div>
          </div>
      </div>
    <div class="col-md-4 mb-2">
      <div class="card shadow" style="width: 18rem;">
          <div class="card-body text-center">
            <img src="{{ asset('images/product.png') }}" alt="" class="img-fluid" style="width: 40px; height: 40px"> 
            <h5 class="card-title text-muted">Purchase Overview</h5>
            {{-- <h6 class="card-text">{{$mostSoldProductType}}</h6> --}}
            <div class="container">
              <div class="row">
                <div class="col rounded p-2 me-2 m-auto">
                  <h5 class="card-title text-muted">Brand</h5>
                  <h6 class="card-text text-dark">{{$mostSoldBrand}}</h6>
                </div>
              </div>
              <div class="row">
                <div class="col  rounded p-2 mt-2 me-2 m-auto">
                  <h5 class="card-title text-muted" style="white-space: nowrap;">Category</h5>
                  <h6 class="card-text text-dark">{{$mostSoldCategory}}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
      <div class="card shadow" style="width: 18rem;">
          <div class="card-body text-center">
            <img src="{{ asset('images/one.png') }}" alt="" class="img-fluid" style="width: 40px; height: 40px">
            <h5 class="card-title text-muted">Product Overview</h5>
            <div class="container">
              <div class="row">
                <div class="col  rounded p-2 me-2 m-auto">
                  <h5 class="card-title text-muted">Total Sold Products</h5>
                  <h6 class="card-text text-dark" style="white-space: nowrap;">{{$totalSoldProducts}}</h6>  
                </div>
              </div>
              <div class="row mt-2">
                <div class="col  rounded p-2 me-2 m-auto">
                  <h5 class="card-title text-muted">Most Sold Product</h5>
                  <h6 class="card-text text-dark">{{$mostSoldProduct}}</h6>  
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
  </div>
</div>

