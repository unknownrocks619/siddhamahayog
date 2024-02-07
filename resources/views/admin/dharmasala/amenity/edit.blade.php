@extends('layouts.admin.master')
@push('page_title') Update Amenity @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Dharmasala / Rooms / Amenity /</span> {{$amenity->amenity_name}}
    </h4>
    <!-- Responsive Datatable -->

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="row my-1">
                <div class="col-md-12 text-end">
                    <a href="{{route('admin.dharmasala.amenities.list')}}" class="btn btn-icon btn-danger"><i class="fas fa-arrow-left"></i> </a>
                </div>
            </div>
            <form action="{{route('admin.dharmasala.amenities.edit',['amenity' => $amenity])}}" class="ajax-form" method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amenity_name">Amenity Name
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="name" value="{{$amenity->amenity_name}}" id="amenity_name" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="icon">Icon</label>
                                    <input type="text" name="icon" value="{{$amenity->icon}}" id="icon" placeholder="fas fa-bedroom" class="form-control" />
                                    <small class="text-info">Icon Reference: <a href="https://fontawesome.com/v6/search?q=bed&amp;o=r&amp;m=free" target="_blank">https://fontawesome.com/v6/search?q=bed&amp;o=r&amp;m=free</a></small>
                                </div>
                                @if($amenity->icon)
                                    <span>Current Icon: <i class="{{$amenity->icon}}"></i></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary">Update Changes</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
</div>
    
@endsection