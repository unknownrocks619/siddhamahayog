@extends("frontend.theme.portal")

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            Members
        </span>
        List
    </h4>
    <div class="row">
        <div class="col-md-12">
            <x-alert></x-alert>
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-hover table-border datatable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    @if($member->address && isset($member->address->street_address))
                                    {{ $member->address->street_address }}
                                    @endif
                                    @if($member->countries)
                                    {{ $member->countries->country_name }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('center.admin.member.edit',$member->id) }}" class="btn btn-sm btn-outline-primary clickable">
                                        <x-pencil>
                                            Edit
                                        </x-pencil>
                                    </a>
                                    <a href="{{ route('center.admin.member.show',$member->id) }}" class="btn btn-sm btn-outline-info">
                                        <x-eye-open>
                                            Detail
                                        </x-eye-open>
                                    </a>
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
@endsection


@push("custom_css")
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endpush

@push("custom_script")
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable();
    });
</script>
@endpush