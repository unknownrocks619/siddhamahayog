@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Connection</h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.account.list') }}"><i class="bx bx-user me-1"></i> Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.account.notifications') }}"><i class="bx bx-bell me-1"></i> Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.account.connections') }}"><i class="bx bx-link-alt me-1"></i> Connections</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Connections / Referral</h5>
                <!-- Account -->
                <div class="card-body">
                    <x-alert></x-alert>

                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div class="button-wrapper">
                            <p class="text-muted mb-0">
                                <?php
                                    if (! user()->sharing_code ) {
                                        $ref_code = mt_rand(00000, 999999);
                                        $user = user();
                                        $user->sharing_code = $ref_code;
                                        $user->save();
                                    }

                                    $ref_code = user()->sharing_code;
                                ?>
                                Reference Code : <a href="{{ route('vedanta.create',['ref'=>$ref_code]) }}" class="copyLink"><?php echo $ref_code ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div class="button-wrapper">
                            <p class="text-muted mb-0">Total Refered: <?php echo user()->refered->count() ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="" data-bs-target="#newreferForm" data-bs-toggle="collapse" class="btn btn-primary">Add New Referal</a>
                        </div>
                        <div class="collapse" id="newreferForm">
                            <form action="" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="full_name">Full Name
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="full_name" id="full_name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="relation">Country</label>
                                            <select name="country" id="country" class="form-control">
                                                @foreach(\App\Models\Country::get() as $country)
                                                    <option value="{{$country->name}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">
                                                Phone Number
                                                <sup class="text-danger">*</sup>
                                            </label>
                                            <input type="text" name="phone_number" id="phone_number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                <div class="col-md-12 text-end">
                                    <button class="btn btn-primary">
                                        Submit Reference
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Phone Number</th>
                                        <th>Country</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\MemberRefers::where('member_id',auth()->id())->get() as $ref_member)
                                        <tr>
                                            <td>
                                                {{$ref_member->full_name}}
                                            </td>
                                            <td>
                                                {{$ref_member->phone_number}}
                                            </td>
                                            <td>
                                                {{$ref_member->country}}
                                            </td>
                                            <td>
                                                @if($ref_member->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($ref_member->status == 'follow-ups')
                                                    <span class="badge bg-primary">Follow Up</span>
                                                @elseif($ref_member->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @elseif($ref_member->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{route('user.account.connection.delete',['connection' => $ref_member])}}" onsubmit="return confirm('You are about to remove your referer information ? This action cannot be undone.')" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-icon">
                                                        <i class="bx bxs-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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

    $(".copyLink").click(function(event) {
        event.preventDefault();
        let copyLink = $(this).attr("href");
        copyToClipboard(copyLink)
    })

    function copyToClipboard(text) {
        var inputc = document.body.appendChild(document.createElement("input"));
        inputc.value = text;
        inputc.focus();
        inputc.select();
        document.execCommand('copy');
        inputc.parentNode.removeChild(inputc);
        alert("URL Copied.");
    }
</script>
@endpush
