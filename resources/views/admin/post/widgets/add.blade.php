<form id='add_widget_form' action="{{ route('admin.posts.widgets.store',$post->id) }}" method="post">
    @csrf

    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                Drag & Drop Widget
            </h5>
        </div>
        <div class="modal-body">
            <p class="text-muted">
                Drag Widget and drop anywhere in yellow zone. Widget order will managed first come first drag order.
            </p>
            <div class="row">
                <div class="col-md-4 mr-3 border border-info">
                    <ul class="sortlist">
                        @foreach ($widgets as $widget)
                        <li class="draggable" data-id='{{ $widget->id }}'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-move">
                                <polyline points="5 9 2 12 5 15"></polyline>
                                <polyline points="9 5 12 2 15 5"></polyline>
                                <polyline points="15 19 12 22 9 19"></polyline>
                                <polyline points="19 9 22 12 19 15"></polyline>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <line x1="12" y1="2" x2="12" y2="22"></line>
                            </svg>
                            {{ $widget->widget_name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4 ml-3 border border-warning droppable">
                    <p id="message"></p>

                </div>
            </div>
        </div>

        <div class="modal-footer">
            <div class="row">
                <div class="col-md-8 text-right">
                    Close once you are done adding widgets.
                </div>
                <div class="col-md-4">
                    <a href="" class='btn btn-secondary'>
                        Close
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(".draggable").draggable()
    $(".droppable").droppable({
        drop: function(event, ui) {
            ui.draggable.draggable({
                disabled: true
            })
            console.log("Dropped ID: " + ui.draggable.data("id"));
            $("#message").html("Please..wait...").removeAttr('class').addClass("text-info");
            $(this).removeClass(".draggable");
            $('.draggable .droppable').sortable({
                connectWith: ".sortlist"
            })
            $.post($("form#add_widget_form").attr("action"), {
                _token: "{{ csrf_token() }}",
                widget: ui.draggable.data('id')
            }).done(function(response) {
                console.log(response);
                $("#message").html(response).addClass("text-success");
            })
        }


    })
</script>