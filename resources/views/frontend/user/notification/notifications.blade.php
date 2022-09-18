@extends("frontend.theme.portal")

@section("content")
<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Notifications</h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.account.list') }}"><i class="bx bx-user me-1"></i> Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.account.notifications') }}"><i class="bx bx-bell me-1"></i> Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.account.connections') }}"><i class="bx bx-link-alt me-1"></i> Connections</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Notifications</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 bg-footer-theme d-none d-md-block">
                            <div class="row pb-4">
                                <div class="accordion mt-3 accordion-without-arrow" id="accordionExample">
                                    @forelse ($notifications as $notification)
                                    <div class="card accordion-item">
                                        <h2 class="accordion-header">
                                            <button type="button" class="accordion-button border-bottom watchLession" data-href="{{ route('user.account.notification-body',$notification->id) }}">
                                                @if( ! $notification->seen)
                                                <strong>
                                                    @endif
                                                    {{ $notification->title }} @if( ! $notification->seen)</strong>@endif
                                            </button>
                                        </h2>
                                    </div>
                                    @empty
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <div class="button-wrapper">
                                            <p class="text-muted mb-0">You don't have any notifications.</p>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 border-end border-bottom border-top">
                            <div class="progress mt-5 d-none" style="height:25px">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 100%;height:25px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div id="notificationContent">
                            </div>
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
    $(document).ajaxStart(function() {
        $('.progress').fadeIn('fast', function() {
            $(this).removeClass('d-none');
        });

    }).ajaxStop(function() {
        $(".progress").fadeOut('medium', function() {
            $(this).addClass("d-none");
        })
    });
    <?php
    if ($notifications->count()) :
    ?>
        $(document).ready(function() {
            $.ajax({
                type: "post",
                url: "{{ route('user.account.notification-body',[$notifications->first()->id]) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    $("#notificationContent").html(response);
                }
            })
        })
    <?php endif ?>

    $(".watchLession").click(function(event) {
        event.preventDefault();
        let elem = $(this);
        $("ul.lms-list li").removeClass("text-success")
        $.ajax({
            type: "post",
            url: $(this).data("href"),
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                $("#notificationContent").html(response);
            }
        })
    })
</script>
@endpush