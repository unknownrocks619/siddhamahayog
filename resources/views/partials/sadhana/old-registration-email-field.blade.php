    
    <div class='bs-callout @error("email_address") bs-callout-danger @else bs-callout-primary @enderror'>
        <h4 class=' mt-4 pt-4'>{{ __('sadhak_registration_front.email_address') }}</h4>
        <p>
            {{ __('sadhak_registration_front.email_address_detail') }}
        </p>
        <input type="email" require name='email_address' class='form-control' value="" />
    </div>
    <div class='card card-footer'>
        <input type="submit" class='btn btn-primary' value="{{ __('sadhak_registration_front.verify_information') }}" />
    </div>
