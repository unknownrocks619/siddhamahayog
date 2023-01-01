@extends('layouts.portal.app')

@section("page_title")
::Program
@endsection

@section("content")
<!-- Main Content -->
<section class="content">
    <div class="container-fluid">

        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Program `{{$program->program_name}}`</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>
                                Questions
                            </strong>
                        </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <button type="button" onclick="window.location.href='{{route('admin.program.admin_program_detail',$program->id)}}'" class="btn btn-danger btn-sm boxs-close">
                                    <i class="zmdi zmdi-close"></i> Close</button>
                            </li>
                            <li class="remove">
                                <a type="button" data-target="#addExam" data-toggle="modal" class=" btn btn-info btn-sm boxs-close">
                                    <i class="zmdi zmdi-plus"></i> Add New Question</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <table class="table table-border table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        S.No
                                    </th>
                                    <th>
                                        Exam Title
                                    </th>
                                    <th>
                                        Total Question
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
    $(document).on('submit', 'form.ajax-form', function(event) {
        event.preventDefault();
        return formSubmit(this);
    });

    $('form#guestListForm').submit(function(event) {
        event.preventDefault();
        return formSubmit(this);
    })

    function formSubmit(formElement) {
        $.ajax({
            method: $(formElement).attr('method'),
            url: $(formElement).attr('action'),
            data: $(formElement).serializeArray(),
            beforeSend: function() {
                removeErrorFields(formElement);
                propStatus(formElement, true);
            },
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content")
            },
            success: function(response) {
                propStatus(formElement, false);
                console.log('response: ', response);
            },
            error: function(response) {
                propStatus(formElement, false)

                if (response.status == 419) {
                    window.location.reload();
                }

                if (response.status == 422) {
                    return errorFields(response.responseJSON.errors, formElement);
                }

                if (response.status == 302) {
                    window.location.href = response.responseJSON.url;
                }

                if (response.status == 406 || response.status == 403) {
                    $(formElement).find('div.messageBox').prepend(`<div class='alert alert-danger'>${response.responseJSON.message}</div>`)
                }
            }
        })
    }


    function errorFields(errors, elem) {
        var noMessagebox = false;
        $.each(errors, function(index, error) {
            let inputElement = $(elem).find(`[name="${index}"]`);
            if ($(inputElement).length) {
                $(inputElement).addClass('border border-danger');
                // also create new element.
                let errorElement = `<div class='text-danger formError' data-id="${index}">${error}</div>`
                $(inputElement).closest('div.form-group').append(errorElement);
                return;
            }

        })

        if (noMessagebox) {
            $("#errorMessage").html("Oops ! something went wrong please try again.");
        }

    }

    function removeErrorFields(elem) {
        $(".messageBox").empty();
        $("#errorMessage").empty().addClass('d-none');
        $(elem).find('input').removeClass('border border-danger');
        $(elem).find('textarea').removeClass('border border-danger');
        $(elem).find('select').removeClass('border border-danger');
        $(elem).find('div.formError').remove();
    }

    function propStatus(elem, value) {
        $(elem).find('input').prop('disabled', value);
        $(elem).find('select').prop('disabled', value);
        $(elem).find('button').prop('disabled', value);
        $(elem).find('textarea').prop('disabled', value);
    }
</script>
@endsection