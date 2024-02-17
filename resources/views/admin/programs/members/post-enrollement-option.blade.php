<form action="" method="post" class="ajax-form">
    <div class="card">
        <div class="card-body">
            @php  /** @todo Remove Registration Code After Hanumand Yagya **/ @endphp
            
            @if(isset($member) && isset($program) && $program->getKey() == 5)
                <div class="row my-4">
                    <div class="col-md-12 alert alert-danger fs-2">
                        <h4>Registration Code: {{$member->getKey()}}</h4>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <a href="{{route('admin.admin_dashboard')}}" class="btn btn-primary btn-lg">
                    Dashboard
                </a>

                <a href="{{route('admin.members.create')}}" class="btn btn-primary btn-lg">
                    Add Another Member
                </a>
            </div>
        </div>
    </div>
</form>

<script>
    $('.step_one_search_option').remove();
</script>