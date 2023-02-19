<div class="row">
    @guest()
        <div class="col-md-12 mt-3">
            <h4 class="teheme-text">
                Login Detail
            </h4>
            <p class="text-danger">
                <em>
                    Remember this information !
                    This is the login (email) and password for your portal
                    - where class zoom link will be
                </em>
            </p>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    <label for="email">Email Address
                        <sup class="text-danger">*</sup>
                    </label>
                    <input value="{{ old('email') }}" type="email" name="email" id="email"
                        class="form-control @error('email') border border-danger @enderror" />
                    @error('email')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="form-group">
                    <label for="email">Password
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') border border-danger @enderror" />
                    @error('password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control @error('password_confirmation') border border-danger @enderror" />
                    @error('password_confirmation')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    @endguest

    <div class="col-md-12 mt-3 d-flex justify-content-end">
        <button type="submit" class="btn btn-danger px-5 w-100 fs-3">
            Next
        </button>
    </div>

</div>
