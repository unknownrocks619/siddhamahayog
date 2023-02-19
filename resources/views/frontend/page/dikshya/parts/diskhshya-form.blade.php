<div class="row">
    <div class="col-md-12 mt-2">
        <h4 class="theme-text">
            Rashi Name (न्वारनको नाम)
        </h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="rashi_name">
                    Rashi Name (न्वारनको नाम)
                </label>
                <input value="{{ old('rashi_name') }}" type="text" name="rashi_name" id="rashi_name"
                    class="form-control @error('rashi_name') border border-danger @enderror">
                @error('rashi_name')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="dikshya_type">
                    Diksha Type(दिक्षा प्रकार)
                </label>
                <select name="dikshya_type" id="dikshya_type"
                    class="form-control  @error('dikshya_type') border border-danger @enderror">
                    <option value="tulasi" @if (old('dikshya_type') == 'tulasi') selected @endif>Tulsi</option>
                    <option value="rudrakshya" @if (old('dikshya_type') == 'rudrakshya') selected @endif>Rudrakshya</option>
                </select>
                @error('dikshya_type')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>
