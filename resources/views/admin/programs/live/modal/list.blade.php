<div class="modal-header">
    <h4>
        Ram Das List
    </h4>
</div>
<div class="modal-body">
    <table class="table table-hover table-boreder">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>
                    Reference Number
                </th>
                <th>
                    Complet Zoom Name
                </th>
                <th>
                    Role
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ramdas as $ramda)
            <tr>
                <td>
                    {{ $ramda->full_name }}
                </td>
                <td>
                    {{ $ramda->reference_number }}
                </td>
                <td>
                    Ram Das ({{ $ramda->reference_number }})
                </td>
                <td>
                    @if(array_key_exists($ramda->role_id ,\App\Models\Role::$roles))
                    {{ \App\Models\Role::$roles[$ramda->role_id] }}
                    @else
                    Not Defined
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>