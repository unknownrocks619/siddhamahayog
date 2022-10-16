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
                <h5 class="card-header">Connections</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div class="button-wrapper">
                            <p class="text-muted mb-0">
                                <?php
                                $ref_code = (user()->sharing_code) ? user()->sharing_code : mt_rand(00000, 999999);
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


                </div>
                <hr class="my-0" />
                <!-- /Account -->
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