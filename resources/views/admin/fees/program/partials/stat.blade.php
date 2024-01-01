<div class="card my-4">
    <div class="card-header">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="card-title mb-0">Statistics</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">
                            {{default_currency(0.0)}}
                        </h5>
                        <small>Total Fee Collected</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-currency ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">
                            {{default_currency(0.0)}}
                        </h5>
                        <small>Total Expected Collection</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                    <div class="card-info">
                        <h5 class="mb-0">{{ default_currency(0.0) }}</h5>
                        <small>Total Transaction</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
