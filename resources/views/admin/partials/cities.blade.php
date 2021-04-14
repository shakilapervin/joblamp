<label for="colFormLabelSm"
       class="col-sm-12 col-form-label">{{ __('City') }}</label>
<div class="col-sm-12">
    <select id="city" name="city" class="form-control @error('city') is-invalid @enderror select2" required>
        <option value="">{{ __('Select City') }}</option>
        @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
        @endforeach
    </select>
    @error('city')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<script>
    $( document ).ready(function() {
        $('.select2').select2();
    });
</script>
