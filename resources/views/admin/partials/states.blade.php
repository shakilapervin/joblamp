<label for="colFormLabelSm"
       class="col-sm-12 col-form-label">{{ __('States') }}</label>
<div class="col-sm-12">
    <select id="state" name="state" class="form-control @error('state') is-invalid @enderror select2" required onchange="getCities();">
        <option value="">{{ __('Select State') }}</option>
        @foreach($states as $state)
            <option value="{{ $state->id }}">{{ $state->name }}</option>
        @endforeach
    </select>
    @error('state')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<script>
    $( document ).ready(function() {
        $('.select2').select2();
    });
</script>
