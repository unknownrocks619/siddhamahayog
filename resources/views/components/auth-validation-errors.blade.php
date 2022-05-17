@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <!-- <div class="font-medium text-red-600"> -->
            {{-- __('Whoops!Somethingwentwrong.') --}}
        <!-- </div> -->

        <ul class="mt-3 list-inside text-sm list-unstyled alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
