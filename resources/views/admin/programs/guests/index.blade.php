@extends("layouts.portal.app")

@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-12">
                <x-alert></x-alert>
                <div class="card">
                    <div class="header">
                        <h2><strong>Quick</strong> Navigation</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <button type="button" onclick="window.location.href='{{route('admin.program.admin_program_detail',[$program->id])}}'" class="btn btn-danger btn-sm boxs-close">
                                    <i class="zmdi zmdi-close"></i> Close</button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <?php
                        $response = '
                            {"zoom":
                                {
                                    "registrant_id":"m1RI_Q3QR665GLaYMwuZWA",
                                    "id":81372308736,
                                    "topic":"Vedanta Darshan",
                                    "start_time":"2022-12-26T22:44:13Z",
                                    "join_url":"https:\/\/us02web.zoom.us\/w\/81372308736?tk=dHT0lhfIrJD4gMJztn6jImSmq6UztV5pGD8kke3YL2g.DQMAAAAS8irlABZtMVJJX1EzUVI2NjVHTGFZTXd1WldBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"
                                },
                                "ip":"113.199.248.6",
                                "browser":"Mozilla\/5.0 (Linux; Android 11; M2004J19C) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/108.0.0.0 Mobile Safari\/537.36",
                                "additional_info":[
                                    {"status":"ok","113.199.248.6":
                                        {
                                            "asn":"AS23752",
                                            "provider":"Nepal Telecommunications Corporation",
                                            "organisation":"Nepal Telecommunications Corporation",
                                            "continent":"Asia",
                                            "country":"Nepal",
                                            "isocode":"NP",
                                            "region":"Lumbini Province",
                                            "regioncode":"P5",
                                            "timezone":"Asia\/Kathmandu",
                                            "city":"Taulihawa",
                                            "latitude":27.530100000000000903810359886847436428070068359375,
                                            "longitude":83.04730000000000700310920365154743194580078125,
                                            "proxy":"no",
                                            "type":"Residential"
                                        }
                                    }
                                ],
                                "2022-12-27 06:08:40": "Re-joined",
                                "2022-12-27 06:11:28":"Re-joined",
                                "2022-12-27 06:13:05":"Re-joined",
                                "2022-12-27 06:17:35":"Re-joined",
                                "2022-12-27 06:51:46":"Re-joined",
                                "2022-12-27 07:00:21":"Re-joined"
                        }';
                        ?>
                        <table id="datatable" class="table table-border table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        S.No
                                    </th>
                                    <th>
                                        Full Name
                                    </th>
                                    <th>
                                        Access Code
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Detail
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guestLists as $list)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $list->first_name }} {{ $list->last_name }}
                                    </td>
                                    <td class="bg-primary text-white">
                                        <span class="access_code">{{ $list->access_code }}</span>
                                    </td>
                                    <td>
                                        @if(! $list->liveProgram || ! $list->liveProgram->live)
                                        <span class="badge badge-primary">
                                            Not Available
                                        </span>
                                        @elseif ($list->used)
                                        <span class="badge badge-info">
                                            Used
                                        </span>
                                        @else
                                        <span class="badge badge-danger">
                                            Not Used
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($list->used)
                                        <?php
                                        $detail = (array) $list->access_detail;
                                        ?>
                                        IP: {{ $detail[0]->ip }}
                                        <br />
                                        Browser : {{ $detail[0]->browser }}
                                        @else
                                        Not Used
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.program.guest.delete',[$program->getKey(),$list->getKey()]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete Record
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
</section>
<x-modal modal="userDetail">
    <div class="body" id="modal-content">
    </div>

</x-modal>
@endsection

@section("page_script")
<script src="{{ asset ('assets/plugins/momentjs/moment.js') }}"></script> <!-- Moment Plugin Js -->

<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $("#userDetail").on("shown.bs.modal", function(event) {
        $("#modal-content").empty();
        $.ajax({
            method: "get",
            url: event.relatedTarget.href,
            success: function(response) {
                $("#modal-content").html(response);
            }
        })
    });
    $(document).ready(function() {
        $("#datatable").DataTable()
    });
</script>
@endsection


@section("page_title")
::Program :: Unpaid Access :: List
@endsection

@section("page_css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />

@endsection