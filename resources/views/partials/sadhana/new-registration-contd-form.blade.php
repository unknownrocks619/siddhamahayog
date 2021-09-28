
<div class='bs-callout @error("gender") bs-callout-danger @else bs-callout-primary @enderror'>
    
    <h4 class=' mt-4 pt-4'>{{ __('sadhak_registration_front.select_your_gender') }}</h4>
    <p>
        {{ __('sadhak_registration_front.select_your_gender_description') }}
    </p>
    <div class='row'>
        <div class='col-md-6'>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input checked type="radio" @if(old('gender') && old('gender') =="male") checked @endif name="gender" value="male" id="male" />
                    <label for="male">{{ __('sadhak_registration_front.male') }}</label>
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class="funkyradio">
                <div class="funkyradio-success">
                    <input type="radio" name="gender" @if(old('gender') && old('gender') == "female")  checked @endif value="female" id="female" />
                    <label for="female">{{ __('sadhak_registration_front.female') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bs-callout @error('country') bs-callout-danger @else bs-callout-primary @enderror">
    <h4 class=''>{{ __('sadhak_registration_front.your_complete_address') }}</h4>
    <p>{{ __('sadhak_registration_front.your_complete_address_description') }}</p>
    <div class='row'>
        <div class='col-md-4'>
            <label class='control-label'>
                {{ __('sadhak_registration_front.select_country') }}
                    <span class='text-danger'>*</span>
                @if(old('country'))
                
                    @php
                        $country = \App\Models\Countries::find(old('country'));
                    @endphp
                    <input type="hidden" name="country" value="{{ old('country') }}" class='form-control' />
                    <input type="text" value="{{  $country->name }}" class='form-control' />
                @else
                    <select class='form-control countries' name='country'> 
                    <option selected></option>
                    @if(old("country") &&  ! old('country') )
                        @php
                                $currentCountry = \App\Models\Countries::find(old('country'));
                                echo "<option value='{$currentCountry->id}'>";
                                    echo $currentCountry->name;
                                echo "</option>";
                        @endphp
                    @endif
                    @php
                        $countries = \App\Models\Countries::get();
                        foreach ($countries as $country) {
                            echo "<option value='{$country->id}'>";
                                echo $country->name;
                            echo "</option>";
                        }

                    @endphp
                </select>
                @endif
                
            </label>
        </div>
        <div class='col-md-4'>
            <label class='control-label @error("city") text-dange @enderror'>
                {{ __('sadhak_registration_front.select_city') }}
                                <span class='text-danger'>*</span>
        
            </label>
            @if( old('country') && old('city'))
            
                @php
                    $city = \App\Models\City::find(old('city'));
                @endphp
                <input type='hidden' name='city' value="{{old('city')}}" />
                <input type="text" class='form-control' value="{{  $city->name }}">
            @else
                 <!--<input type="text" class='form-control' name='city' required />-->
                <select class='form-control cities' name='city'>

                    <option selected>{{ __('sadhak_registration_front.select_city') }}</option>
                </select>
            @endif
               
        </div>
        <div class='col-md-4'>
            <label class='control-label @error("address") text-danger @enderror'>
                {{ __('sadhak_registration_front.address') }}
                                <span class='text-danger'>*</span>

            </label>
                <textarea class='form-control' name='address'>{{ old('address') }}</textarea>
        </div>
    </div>
    
    <h4 class='mt-4 pt-4'>{{ __('sadhak_registration_front.contact_information') }}</h4>
    <p>{{ __('sadhak_registration_front.contact_information_description') }}</p>
    <div class='row'>
        <div class='col-md-6'>
            <label class='control-label @error("contact_number") text-danger @enderror'>{{ __('sadhak_registration_front.contact_number') }}
                            <span class='text-danger'>*</span>

            </label>
            <input type='text' value="{{ old('contact_number') }}" name='contact_number' class='form-control' />
        </div>
        <div class='col-md-6'>
            <div class='row'>
                <div class='col-md-12'>
                    <label class='control-label @error("emeregency_contact_number") text-danger @enderror'>{{ __('sadhak_registration_front.emergency_contact_no') }}
                                    <span class='text-danger'>*</span>

                    </label>
                    <input type="text" value="{{ old('emeregency_contact_number') }}" name='emeregency_contact_number' class='form-control' />
                </div>
            </div>
            <div class='row mt-2'>
                <div class='col-md-12'>
                    <label class='control-label @error("emeregency_full_name") text-danger @enderror'>{{ __('sadhak_registration_front.full_name_emergency') }}
                <span class='text-danger'>*</span>
                    
                    </label>
                    <input type="text" value="{{ old('emeregency_full_name') }}" name='emeregency_full_name' class='form-control' />
                </div>
            </div>
            <div class='row mt-2'>
                <div class='col-md-12'>
                    <label class='control-label @error("emeregency_relation") text-danger @enderror'>
                        @if(App::currentLocale() == "np")
                        {{ __('sadhak_registration.relation') }}
                        @else
                        {{ __('sadhak_registration_front.emergency_relation') }}
                        @endif
                        <span class='text-danger'>*</span>
                    
                    </label>
                    <input type="text" value="{{ old('emeregency_relation') }}" name='emeregency_relation' class='form-control' />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bs-callout @error('center') bs-callout-danger @else bs-callout-primary @enderror">
    <h4 class=''>{{ __('sadhak_registration_front.your_nearest_center') }}</h4>
    <p>{{ __('sadhak_registration_front.please_select_your_nearest_or_your_most_convenient_center_for_sadhana') }}</p>
    <div class='row'>
        <div class='col-md-8'>
            <select class='form-control' name='center'>
                @php
                    $all_centeres = App\Models\Center::get();
                    foreach ($all_centeres as $center){
                        echo "<option ";
                            if($center->id == old('center') ) {
                                echo " selected ";
                            }
                        echo " value='{$center->id}'>{$center->name}</option>";
                    }
                @endphp
                <option value='0'>Sewa Pit (Chatara)</option>
            </select>
        </div>
    </div>
    
</div>

<div class="bs-callout @error('first_name') bs-callout-danger @else bs-callout-primary @enderror">
    <h4 class=''>{{ __('sadhak_registration_front.full_name') }}</h4>
    <p>{{ __('sadhak_registration_front.full_name_description') }}</p>
    <div class='row'>
        <div class='col-md-4'>
            <label class='control-label @error("first_name") text-danger @enderror'>{{ __('sadhak_registration_front.first_name') }}<span class='text-danger'>*</span></label>
            <input type='text' name='first_name' required value="{{ old('first_name') }}" class='form-control' />
        </div>
        <div class='col-md-4'>
            <label class='control-label @error("middle_name") text-danger @enderror'>{{ __('sadhak_registration_front.middle_name') }}</label>
            <input type='text' name='middle_name' value="{{ old('middle_name') }}" class='form-control' />
        </div>
        <div class='col-md-4'>
            <label class='control-label @error("last_name") text-danger @enderror'>{{ __('sadhak_registration_front.last_name') }}
                <span class='text-danger'>*</span>
            </label>
            <input type='text' name='last_name' value="{{ old('last_name') }}" class='form-control' />
        </div>
    </div>
    
    <h4 class=' mt-4 pt-4'>{{ __('sadhak_registration_front.education_and_profession') }}</h4>
    <p>
        {{ __('sadhak_registration_front.education_and_profession_description') }}
    </p>
    <div class='row'>
        <div class='col-md-6'>
            <label class='control-label @error("education_background") text-danger @enderror'>{{ __('sadhak_registration_front.your_highest_qualification') }}
                                <span class='text-danger'>*</span>

            </label>
            <input type="text" required name='education_background' value="{{ old('education_background') }}" class='form-control' />
        </div>
        <div class='col-md-6'>
            <label class='control-label @error("profession") text-danger @enderror'>{{ __('sadhak_registration_front.your_profession') }}
                <span class='text-danger'>*</span>

            </label>
            <input type="text" required name='profession' value="{{ old('profession') }}" class='form-control' />
 
        </div>
    </div>

    <h4 class='mt-4 pt-4'>{{ __('sadhak_registration_front.date_of_birth') }}</h4>
    <p>{{ __('sadhak_registration_front.date_of_birth_description') }}
    </p>
    <div class="row">
        <div class='col-md-6'>
            <label class='control-label @error("date_of_birth") text-danger @enderror'>{{ __('sadhak_registration_front.date_of_birth') }}
                <span class='text-danger'>*</span>
                @if(App::currentLocale() == "np")
                    <span style="font-size:13px" class='text-info'>FORMAT: YYYY-MM-DD</span>
                @endif
            </label>
            <input id='date_of_birth' @if(App::currentLocale()=="np") type="text" placeholder="YYYY-MM-DD" @else type="date" @endif name='date_of_birth' value="{{ old('date_of_birth') }}" class='form-control date_of_birth' />
        </div>
        <div class='col-md-6'>
            <label class='control-label @error("place_of_birth") text-danger @enderror'>{{ __('sadhak_registration_front.place_of_birth') }}
                <span class='text-danger'>*</span>
            </label>
            <input type='text' name='place_of_birth' value="{{ old('place_of_birth') }}" class='form-control' />
        </div>
    </div>
</div>

<div class='bs-callout @error("email_address") bs-callout-danger @else bs-callout-primary @enderror'>
    <h4>{{ __('sadhak_registration_front.email_address') }}
                <span class='text-danger'>*</span>
    </h4>
    <p>{{ __('sadhak_registration_front.email_address_detail') }}</p>
    <input type="email" name='email_address' value="{{ old('email_address') }}" class='form-control' />
</div>
<div class='card card-footer'>
    <input type="submit" class='btn btn-primary' value="{{ __('sadhak_registration.save_and_continue') }}" />
</div>

@if( old("first_name") == null)
    <script type="text/javascript">
        $(document).ready(function(){
            $(".countries").select2({
                placeholder: "{{ __('sadhak_registration_front.select_country') }}"
            });

            $('.countries').change(function(){
                var country_id = this.value;
                $(".cities").empty();
                $(".cities").select2({
                    placeholder : "{{ __('sadhak_registration_front.select_city') }}",
                    ajax: {
                        url :'{{ route("cities-list") }}/?country='+this.value,
                        dataType :'json',
                    }
                })
            })
        })

    </script>
@endif

@if(App::currentLocale() == "np")
<script>
    $('#date_of_birth').nepaliDatePicker();    
  
</script>

@endif