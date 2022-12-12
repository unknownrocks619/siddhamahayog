@extends("frontend.theme.portal")

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            Member /
        </span>
        {{ $member->full_name }}
    </h4>
    <div class="row">
        <form action="{{ route('center.admin.member.update',$member->id) }}" method="post">
            @csrf
            @method("PUT")
            <div class="col-md-12">
                <x-alert></x-alert>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between bg-light py-4">
                        <h4>Update Member Info</h4>
                        <button type="button" class="btn btn-danger clickable" data-href='{{ route("center.admin.dashboard") }}'>
                            <i class="bx bx-window-close"></i>
                            Close
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First name
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="first_name" value="{{ old('first_name',$member->first_name) }}" id="first_name" class="form-control @error('first_name') border border-danger @enderror" />
                                    @error('first_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" name="middle_name" value="{{ old('middle_name',$member->middle_name) }}" id="middle_name" class="form-control @error('middle_name') border border-danger @enderror" />
                                    @error('middle_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">Last Name
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" id="last_name" class="form-control @error('last_name') border border-danger @enderror" />
                                    @error('last_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email',$member->email) }}" class="form-control disabled" disabled />
                                    @error('email')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Phone Number
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number',$member->phone_number) }}" class="form-control" />
                                    @error('phone_number')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Country
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <select name="country" id="country" class="form-control">
                                        <?php
                                        $countries = \App\Models\Country::get();
                                        ?>
                                        @foreach ($countries as $country)
                                        <option value='{{ $country->id }}' @if($country->id == $member->country)
                                            selected
                                            @endif
                                            >
                                            {{ $country->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">
                                        City / State
                                        <sup class="text-danger">
                                            *
                                        </sup>
                                    </label>
                                    <input value="{{ old('state',$member->city) }}" type="text" name="state" id="state" class="form-control @error('state') border border-danger @enderror" />
                                    @error('state')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea name="address" class="form-control @error('address') border border-danger @enderror" id="address">@if($member->address && isset($member->address->street_address)){{ old('street_address',$member->address->street_address) }}@endif</textarea>
                                    @error('address')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-4">
                        <div class="row">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                    Update Member Information
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection