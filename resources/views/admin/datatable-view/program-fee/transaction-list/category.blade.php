@if($program->getKey() == 5)
    {{$row->voucher_number}}
@else
    @php
        $seperate_category = explode("_", $row->amount_category);
        $category_text = "";
        foreach ($seperate_category as $value) {
        $category_text .= ucwords(strtolower($value)) . " ";
        }
    @endphp
    {{$category_text}};
@endif
