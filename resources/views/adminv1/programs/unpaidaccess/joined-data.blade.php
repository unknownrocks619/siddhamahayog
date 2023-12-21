<div class="modal-header">
    <h4>
        Meta Information
    </h4>
</div>

<div class="modal-body">

    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>
                    Meeting ID
                </th>
                <th>
                    Total In / Out
                </th>
                <th>
                    Meta Information
                </th>
                <th>
                    Date
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $attendance)
            <tr>
                <td>
                    {{ $attendance->meeting_id }}
                </td>
                <td>
                    <?php
                    $allMeta = (array) $attendance->meta;
                    $meta = count($allMeta) - 3;
                    echo $meta;
                    ?>
                </td>
                <td>
                    IP Address: {{ $attendance->meta->ip }}
                    <br />
                    Browser : {{ $attendance->meta->browser }}
                </td>
                <td>
                    {{ $attendance->created_at }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>