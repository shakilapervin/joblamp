@if ($for == 'signup')
    <select id="city"
            class="citypicker with-border @error('city') is-invalid @enderror"
            data-size="7" title="Select City" data-live-search="true"
            name="city">
        @foreach($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
        @endforeach
    </select>
@else
    <div class="submit-field">
        <h5>{{ __('City') }}</h5>
        <select id="city"
                class="citypicker with-border @error('city') is-invalid @enderror"
                data-size="7" title="{{ __('Select City') }}" data-live-search="true"
                name="city">
            @foreach($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
    </div>
@endif
<script>
    $( document ).ready(function() {
        $('.citypicker').selectpicker();
    });
</script>
