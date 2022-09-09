@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.account.notifications') }}"><i class="bx bx-bell me-1"></i> Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.account.connections') }}"><i class="bx bx-link-alt me-1"></i> Connections</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profile Details</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ profile() }}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                        <div class="button-wrapper">
                            <form action="{{ route('user.account.store.profile') }}" enctype="multipart/form-data" id="profileForm" method="post">
                                @csrf
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" name="profileMedia" id="upload" class="account-file-input" hidden accept="image/*" />
                                </label>
                                @error("profileMedia")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </form>
                            <!-- <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button> -->

                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="{{ route('user.account.store.personal') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <x-alert></x-alert>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="first_name" class="form-label">First Name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input class="form-control @error('first_name') border border-danger @enderror" type="text" id="first_name" name="first_name" value="{{ old('first_name',user()->first_name) }}" autofocus />
                                @error("first_name")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input class="form-control @error('middle_name') border border-danger @enderror" type="text" name="middle_name" id="middle_name" value="{{ old('middle_name',user()->middle_name) }}" />
                                @error("middle_name")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input class="form-control @error('last_name') border border-danger @enderror" type="text" name="last_name" id="last_name" value="{{ old('last_name',user()->last_name) }}" />
                                @error("last_name")
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" readonly type="text" id="email" name="email" value="{{ user()->email }}" placeholder="john.doe@example.com" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="male" @if(old('gender',user()->gender) == "male") selected @endif> Male </option>
                                    <option value="female" @if(old('gender',user()->gender) == "female") selected @endif> Female </option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="phone_number">Phone Number
                                    <sup class="text-danger">*</sup>
                                </label>
                                <div class="input-group input-group-merge">
                                    <!-- <span class="input-group-text">US (+1)</span> -->
                                    <input value="{{ old('phone_number',user()->phone_number) }}" type="text" id="phone_number" name="phone_number" class="form-control @error('phone_number') border border-danger @enderror" placeholder="985XXXXXXX" />
                                    @error('phone_number')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') border border-danger @enderror" id="address" name="address" placeholder="Address">{{ old('address',(user()->address && user()->address->street_address) ? user()->address->street_address : null) }}</textarea>
                                @error("address")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="state" class="form-label">State</label>
                                <input class="form-control @error('state') border border-danger @enderror" type="text" id="state" value="{{ old('state',user()->city) }}" name="state" placeholder="California" />
                                @error("state")
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="country">Country</label>
                                <select id="country" name="country" class="select2 form-select ">
                                    <?php
                                    $countries = \App\Models\Country::get();

                                    foreach ($countries as $country) {
                                        echo "<option value='{$country->id}'";
                                        if ($country->id == user()->country) {
                                            echo " selected ";
                                        }
                                        echo ">";
                                        echo $country->name;
                                        echo "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Update </button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header">Delete Account</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                    </div>
                    <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
                            <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection

@push("custom_script")
<script type="text/javascript">
    $("#upload").change(function() {
        var file = document.getElementById("upload");
        if (file.files.length != 0) {
            $("#profileForm").submit();
        }
    })
</script>
@endpush