 <form action="{{ route('user.my-member') }}" method="post" class="ajax-form">
     <div class="modal-header">
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <div class="modal-body mt-0 pt-0">
         <div class="card alert alert-danger">
             <div class="card-header mb-0 pb-0 alert-title">
                 <h4>Creating New Training Session ?</h4>
             </div>
             <div class="card-body alert-body">
                 When creating new session please make sure your previous session is completed, or if you want to
                 run multiple session make sure you make all session as active.
             </div>
         </div>
         <div class="row">
             <div class="col-md-6">
                 <div class="form-group">
                     <label for="session_name">Session name</label>
                     <input type="text" name="session_name" id="session_name"
                         value="Sadhana Training Session {{ $sessions->count() + 1 }}" class="form-control">
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="form-group">
                     <label for="training_type">Training Type</label>
                     <input type="text" name="training_type" id="training_type" disabled value="Sadhana"
                         class="form-control">
                 </div>
             </div>
         </div>
         <div class="row mt-3">
             <div class="col-md-6">
                 <div class="form-group">
                     <label for="trainign_location">Training Location</label>
                     <textarea name="training_location" id="training_location" class="form-control"></textarea>
                 </div>
             </div>

             <div class="col-md-6">
                 <div class="form-group">
                     <label for="session_status">Session Status</label>
                     <select name="session_status" id="session_status" class="form-control no-select-2">
                         <option value="1">Active</option>
                         <option value="0">Inactive</option>
                     </select>
                 </div>
             </div>
         </div>
     </div>

     <div class="modal-footer">
         <div class="row">
             <div class="col-md-12 text-end">
                 <button class="btn btn-primary">
                     Save Session
                 </button>
             </div>
         </div>
     </div>
 </form>
