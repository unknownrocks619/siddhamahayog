@if ( ! $access )
    <h5 class='text-danger'>Permission Denied: <br /> You are not authorized to perform this action.</h5>
@else
    <div class="row">
        <div class='col-md-12'>
            <table class='table table-bordered table-hover'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Program Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($offline_videos as $video)
                        <tr>
                            <td>
                                {{ $video->index+1 }}
                            </td>
                            <td>
                                {{ $video->event_source->sibir_title }}
                                <br />
                                {{ $video->video_title }}
                            </td>
                            <td><a href="">Watch</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif