@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
    <div class="row">
        <div class="col-12">
            <x-alert></x-alert>
            <form method="post" action="{{ route('courses.admin_course_store') }}">
                @csrf
                <div class="card">
                    <div class="card-body card-dashboard">
                        <p class="card-text text-right">
                            <!-- <a href='' class='btn btn-info'>Export To Excel</a> -->
                            <a href='{{ route("courses.admin_course_list") }}' class='btn btn-info'>Go Back</a>
                        </p>
                    </div>
                    <div class='card-body'>
                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class="label-control">Select Sibir</label>
                                    <select name="sibir_record" class='form-control'>
                                        @foreach ($sibirs as $sibir)
                                            <option value="{{$sibir->id}}">
                                                {{ $sibir->sibir_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Course Fee</label>
                                    <input type="text" value="{{ old('full_course_fee') }}" name="full_course_fee" class='form-control' />
                                </div>
                            </div>
                        </div>

                        <div class='form-group'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <label class='label-control'>
                                        Admission Fee
                                    </label>
                                    <input type="text" class='form-control' value="{{ old('admission_fee') }}" name="admission_fee" />
                                </div>
                                <div class='col-md-6'>
                                    <label class='label-control'>
                                        Course Status
                                    </label>
                                    <select name="course_status" class='form-control'>
                                        <option value="1">Open</option>
                                        <option value="0">Closed</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class='row'>
                                <div class="col-md-6">
                                    <label class="label-control">Couser Start From</label>
                                    <input type="date" value="{{ old('course_start_from') }}" class='form-control' name="course_start_from" />
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Couser End From</label>
                                    <input type="date" class='form-control' value="{{ old('course_end_from') }}" name="course_end_from" />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class='row'>
                                <div class='col-md-12'>
                                    <label class='label-control'>Course Description / Remark</label>
                                    <textarea class='form-control' name="course_description">{{ old('course_description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='card-footer'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <button type="submit" class='btn btn-primary'>Save Course Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>  
</section>
<!--/ Complex headers table -->
@endsection

@section("footer_js")
@endsection