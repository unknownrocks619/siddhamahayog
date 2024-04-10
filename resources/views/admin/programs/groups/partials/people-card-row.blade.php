<div class="row">
    <div class="col-md-12 my-2 text-start">
        {!! $groups->links() !!}
    </div>
</div>
<div class="row">
    @foreach ($groups as $people)
        {!! view('admin.programs.groups.tabs.people-card',['people' => $people]) !!}
    @endforeach
</div>

<div class="row">
    <div class="col-md-12 my-3">
        {!! $groups->links() !!}
    </div>
</div>