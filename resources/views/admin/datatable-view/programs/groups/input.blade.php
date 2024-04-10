<input 
        @if($people->verified) checked @endif 
        onchange="window.programGroup.userVerification(this)" 
        type="checkbox" 
        name="verify[]" 
        value="{{$people->getKey()}}" />
