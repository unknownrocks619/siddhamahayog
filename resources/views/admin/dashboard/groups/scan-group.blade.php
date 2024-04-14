<div class="row">
    <!-- Sales Overview -->
        <div class="col-lg-12 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-1">Quick Group Scanning</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input  type="text" placeholder="Group Bar Code" name="groupScanning" id="groupScanning" class="form-control fs-2" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none row " id="scanErrorDisplay">
                        <div class="col-md-12 bg-danger fs-2 text-center text-white d-flex align-items-center justify-content-center">

                        </div>
                    </div>
                    <div class="row mt-4 d-none" id="group-scan-status">
                        <div class="col-md-12 h-75 bg-success text-center d-flex align-items-center justify-content-center">
                            <div>
                                <h1 class="text-white" id="groupConfirmationText">Category: Atithi</h1>
                                <div id="groupScanCount" class="fs-2 text-white">Total Scanned: 0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--/ Sales Overview -->
</div>
