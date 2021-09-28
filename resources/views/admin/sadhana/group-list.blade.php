@extends("layouts.admin")

@section("content")
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Famliy / Group Request
                    </h4>
                </div>
                <form id="group_filter" action="{{ route('users.sadhak.admin_user_group_list_filter') }}" method="post">
                    @csrf
                    <div class='card-body'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <label class='label-control'>Select Sibir</label>
                                <select class='form-control' name='sibir'>
                                    @foreach ($sibirs as $sibir)
                                        <option value="{{ $sibir->id }}"> {{ $sibir->sibir_title }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='col-md-4'>
                                <label class='label-control'>Filter Type</label>
                                <select class='form-control' name='filter'>
                                    <option value="1">Verified</option>
                                    <option value="0">Unverified</option>
                                </select>
                            </div>
                            <div class='col-md-4'>
                                <label class='label-control'>Select Year</label>
                                <select class='form-control' name='year'>
                                    <option value="2021">2021 / 2078</option>
                                </select>
                            </div>

                        </div>
                        <div class='row mt-2'>
                            <div class='col-md-12'>
                                <button type="submit" class='btn-block btn btn-sm btn-primary'>Search Record</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class='card-body' id="group_data"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_js")
    <script>
        $("form#group_filter").submit(function(event){
            event.preventDefault();
            $.ajax({
                type : $(this).attr("method"),
                url : $(this).attr("action"),
                data: $(this).serializeArray(),
                success : function( response ) {
                    $("#group_data").html(response);
                }
            })
        });
    </script>
@endsection