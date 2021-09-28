@extends('layouts.admin')

@section('page_css')
  <link rel="stylesheet" type="text/css" href="{{ asset ('admin/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
  <link ref='stylesheet' href='{{ asset("admin/app-assets/css/jquery.fancybox.min.css") }}' />
@endSection()

@section('content')
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Available Center</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("centers.new_center_form") }}' class='btn btn-info'>Add New Center</a>

           
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th rowspan="2" class="align-center">Center Name</th>
                  <th colspan="2" class="text-center bg-dark text-white">Center Information</th>
                  <th colspan="2" class='text-center  bg-dark text-white'>Person Information</th>
                  <th rowspan="2" class='bg-success'>Action</th>
                </tr>
                <tr class=''>
                  <th>Location</th>
                  <th>Contact No</th>
                  <th>Name</th>
                  <th>Mobile Number</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($centers as $center)
                  <tr>
                    <td>
                      <a href=''>
                        {{ $center->name }}
                      </a>
                    </td>
                    <td>{{ $center->location }}</td>
                    <td>{{ $center->landline }}</td>
                    <td>{{ $center->contact_person }}</td>
                    <td>{{ $center->person_phone }}</td>
                    <td>
                      <a data-fancybox data-src="#map_{{ $center->id }}" href='javascript:;'>
                        View Map 
                      </a>
                      <!--Basic Modal -->
           <div class="modal fade text-left show w-100" style="display:none" id="map_{{ $center->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="padding-right: 17px; display: block;" aria-modal="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
              <div class="modal-content bg-dark">
                <div class="modal-header">
                  <h3 class="modal-title text-white" id="myModalLabel1">{{ $center->name }} Map</h3>
                  <button type="button" onclick="javascript:parent.jQuery.fancybox.close();" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="mb-0 text-center">
                    @php
                      echo $center->iframe_location;
                    @endphp
                  </p>
                </div>
              </div>
            </div>
          </div>
                      |
                     
                      <a href=''>
                        Delete
                      </a>
                    </td>
                </tr>
                    
                  @endforeach
            </tbody>
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Salary</th>
                  <th>Office</th>
                  <th>Extn.</th>
                  <th>E-mail</th>
                </tr>
              </tfoot>
            </table>
          </div>
        
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endSection()

@section('page_js')
<script src="{{ asset ('admin/app-assets/js/scripts/modal/components-modal.min.js') }}"></script>
<script src="{{ asset ('admin/app-assets/js/scripts/jquery.fancybox.min.js') }}"></script>
<script>
  $(document).on('keydown.fb', function (e) {

var keycode = e.keyCode || e.which;

if (keycode === 27) {

  e.preventDefault();

  parent.jQuery.fancybox.getInstance().close();

  return;
}

});
  </script>
@endSection()