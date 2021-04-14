@if ($for == 'signup')
    <select
        class="statepicker with-border @error('state') is-invalid @enderror"
        data-size="7" title="Select State"
        data-live-search="true" name="state" onchange="getCities()" id="state">
        @foreach($states as $state)
            <option value="{{ $state->id }}">{{ $state->name }}</option>
        @endforeach
    </select>
@else
    <div class="submit-field">
        <h5>{{ __('State') }}</h5>
        <select class="statepicker with-border @error('state') is-invalid @enderror" data-size="7" title="Select State"
                data-live-search="true" name="state" onchange="getCities()" id="state">
            @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
            @endforeach
        </select>
    </div>
@endif
<script>
    $(document).ready(function () {
        $('.statepicker').selectpicker();
    });
</script>
