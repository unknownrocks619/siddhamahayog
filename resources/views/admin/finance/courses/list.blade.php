@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
  <div class="row">
    <div class="col-12">
        <x-alert></x-alert>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Available Classes</h4>
        </div>
        <div class="card-body card-dashboard">
          <p class="card-text text-right">
            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
            <a href='{{ route("courses.admin_course_add") }}' class='btn btn-info'>Create New Course</a>

           
          </p>
          <div class="table-responsive">
            <table class="table table-striped table-bordered complex-headers">
              <thead>
                <tr>
                  <th class="align-center">Course Name </th>
                  <th  class="text-center bg-dark text-white">Fee</th>
                  <th>Total Enrolled</th>
                  <th class='bg-success'>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($courses as $course)
                      <tr>
                          <td> {{ $course->course_title }} </td>
                          <td>
                              Admission: {{ $course->admission_fee }}<br />
                              Course: {{ $course->course_fee }}<br />
                              Total: {{ $course->total_amount }}
                              
                          </td>
                          <td>
                              {{ $course->total_enrolled->count() }}
                          </td>
                          <td>
                              <a href="{{ route('courses.admin_course_report',[$course->id]) }}">View Report</a>
                          </td>
                      </tr> 
                  @endforeach
              </tbody>
            </table>
          </div>
        
      </div>
    </div>
  </div>
  
</section>
<!--/ Complex headers table -->
@endsection

@section("footer_js")
@endsection