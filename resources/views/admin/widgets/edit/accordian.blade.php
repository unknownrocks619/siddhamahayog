@extends("layouts.portal.app")

@section("title")
Edit :: {{ $widget->widget_name }}
@endsection

@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="block-header"></div>
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>
                                Edit ::
                            </strong>
                            {{ $widget->widget_name }}
                        </h2>
                    </div>
                    <div class="body">
                        <a class="btn btn-sm btn-primary mb-3" href="{{ route('admin.widget.widget_by_type',['type'=>$widget->widget_type]) }}">
                            <x-arrow-left>Go back</x-arrow-left>
                        </a>
                        @include("admin.widgets.create.edit",compact('widget'))
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
    $(".add_widget_row").click(function(event) {
        event.preventDefault();
        let content = $("#sample_form").clone();
        let tetId = Math.floor(Math.random() * 57);
        $(content).find('text-area').replaceWith("<textarea id='accord_" + tetId + "' class='form-control' name='widget_content[]'>");
        $(content).insertBefore("#submit_button").fadeIn().removeAttr("id");

        // tinymce.init({
        //     selector: 'textarea#accord_' + tetId,
        //     plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
        //     toolbar_mode: 'floating',
        // });
    })
    // $(".remove_section").click(function(event) {
    //     event.preventDefault();
    //     console.log("clicked on remove section");
    //     $(this).closest('.row').remove();
    // })
</script>
@endsection