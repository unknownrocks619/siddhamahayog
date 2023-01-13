 <!-- Expense Overview -->
 <div class="col-md-6 col-lg-4 order-1 mb-4">
     <div class="card h-100">
         <div class="card-header">
             <h5>
                 Donation
             </h5>
             @if(site_settings('donation') || user()->role_id == 1)
             <form method="post" action="{{ route('donations.donate',['esewa']) }}" class="mt-3">
                 @csrf
                 <div class="input-group">
                     <span class="input-group-text">NRs</span>
                     <input name="amount" type="text" require class="form-control" placeholder="Amount" aria-label="Amount">
                     <span class="input-group-text">.00</span>
                 </div>
                 <button type="submit" class="btn btn-success mt-2">E-Sewa Dakshina</button>
                 <a href="{{-- route('donations.donate_get',['stripe']) --}}" type="submit" class="btn-sm btn btn-primary mt-2 disabled">Other Payment (Coming Soon)</a>
             </form>
             @endif
         </div>

         <hr />
         <h5 class="text-center">
             Your Donation History
             <br />
             <small>[<a href="" class="refresh-donation">Refresh list</a>]</small>
         </h5>
         <div id="dontaionTable" class="table-responsive">
             <div class="progress mt-5" style="height:25px">
                 <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 100%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
             </div>
         </div>
     </div>
 </div>
 <!--/ Expense Overview -->