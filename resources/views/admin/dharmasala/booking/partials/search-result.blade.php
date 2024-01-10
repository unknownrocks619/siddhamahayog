<div class="row my-2">
    <div class="col-md-12 text-end">
        <button class="btn btn-icon btn-warning close-search-option">
            <i class="fas fa-close"></i>
        </button>
    </div>
</div>
@forelse ($members as $member)
    <div class="row @if($loop->even) bg-light @endif mt-2 px-2 py-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-primary select-member" data-member-modal="{{$member}}" data-member="{{$member->getKey()}}" type="button">Select User</button>
                </div>
                <div class="col-md-8">
                    <h3 class="my-0 py-0 border-bottom text-info">
                        {{ $member->full_name }}
                    </h3>
                    <p class="py-0 my-0">
                        Email : {{ $member->email }}
                    </p>
                    <p>
                        Phone: {{ $member->phone_number }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="row mt-2">
        <div class="col-md-12">
            <h4 class="text-danger">
                Member record not found.
            </h4>
        </div>
    </div>
@endforelse

<script type="text/javascript">
    $('.select-member').on('click', function(event) {
        event.preventDefault();
        let _memberData = $(this).data('member-modal');
        let _selectedDiv = `<div class='col-md-12 pb-2 selected-user border-bottom border-1 d-flex justify-content-between align-items-center'>
                                <div>
                                    <h4 class="mb-0 pb-0">${_memberData.full_name}</h4>
                                    <p class="text-muted mb-0 pb-0">${_memberData.email}</p>
                            `
            if (_memberData.phone_number && _memberData.phone_number != 'null') {
                _selectedDiv += `<p class="text-muted">${_memberData.phone_number}</p>`
            }
        _selectedDiv += ` </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="check-in">Check In</label>
                                            <input type="date" name="check_in[]" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="check-out">Check Out</label>
                                            <input type="date" name="check_out[]" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <button type="button" data-member="${_memberData.id}" class="btn btn-danger btn-icon btn-remove-user"><i class="fas fa-trash"></i></button>
                            `;

        $('#selectedUser').append(_selectedDiv);
        $('#selected-result-input').append(`<input type='hidden' class="form-control d-none selected_member_${_memberData.id}" name='members[]' value='${_memberData.id}' />`)
    })

    $('.close-search-option').click(function(){
        $('#search_result').empty();
    })
</script>
