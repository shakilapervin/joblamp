@extends('frontend.layouts.master')
@section('title')
    {{ __('Edit Profile') }}
@endsection

@section('content')
    <!-- Dashboard Container -->
    <div class="dashboard-container">
    @include('frontend.layouts.dashboard-sidebar')

    <!-- Dashboard Content
        ================================================== -->
        <div class="dashboard-content-container" data-simplebar>
            <div class="dashboard-content-inner">

                <!-- Dashboard Headline -->
                <div class="dashboard-headline">
                    <h3>Edit Profile</h3>

                    <!-- Breadcrumbs -->
                    <nav id="breadcrumbs" class="dark">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li>{{ __('Edit Profile') }}</li>
                        </ul>
                    </nav>
                </div>
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                         style="width: 100%;">
                        {{ Session::get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                         style="width: 100%;">
                        {{ Session::get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('update.profile') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Row -->
                    <div class="row">

                        <!-- Dashboard Box -->
                        <div class="col-xl-12">
                            <div class="dashboard-box margin-top-0">


                                <!-- Headline -->
                                <div class="headline">
                                    <h3>
                                        <i class="icon-material-outline-account-circle"></i> {{ __('General Information') }}
                                    </h3>
                                </div>

                                <div class="content with-padding padding-bottom-0">

                                    <div class="row">

                                        <div class="col-auto">
                                            <div class="avatar-wrapper" data-tippy-placement="bottom"
                                                 title="Change Avatar">
                                                @if(!empty($user->profile_pic))
                                                    <img class="profile-pic"
                                                         src="{{ asset('public/profile') }}/{{ $user->profile_pic }}" alt=""/>
                                                @else
                                                    <img class="profile-pic"
                                                         src="{{ asset('public/assets/frontend') }}/images/user-avatar-placeholder.png"
                                                         alt=""/>
                                                @endif
                                                <div class="upload-button"></div>
                                                <input class="file-upload" type="file" accept="image/*"
                                                       name="profile_pic"/>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('First Name') }}</h5>
                                                        <input name="first_name" type="text"
                                                               class="with-border @error('first_name') is-invalid @enderror"
                                                               value="{{ $user->first_name }}">
                                                        @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('Last Name') }}</h5>
                                                        <input name="last_name" type="text"
                                                               class="with-border @error('last_name') is-invalid @enderror"
                                                               value="{{ $user->last_name }}">
                                                        @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('Email Address') }}</h5>
                                                        <input name="email" type="text"
                                                               class="with-border @error('email') is-invalid @enderror"
                                                               value="{{ $user->email }}">
                                                        @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('Pin Code') }}</h5>
                                                        <input name="pincode" type="text"
                                                               class="with-border @error('pincode') is-invalid @enderror"
                                                               value="{{ $user->pincode }}">
                                                        @error('pincode')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('Mobile Number') }}</h5>
                                                        <input name="mobile_number" type="text"
                                                               class="with-border @error('mobile_number') is-invalid @enderror"
                                                               value="{{ $user->mobile_number }}">
                                                        @error('mobile_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Dashboard Box -->
                        <div class="col-xl-12">
                            <div class="dashboard-box">

                                <!-- Headline -->
                                <div class="headline">
                                    <h3><i class="icon-line-awesome-map"></i> Address</h3>
                                </div>

                                <div class="content">
                                    <ul class="fields-ul">
                                        <li>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('Address Line 1') }}</h5>
                                                        <input name="address_line_1" type="text"
                                                               class="with-border @error('address_line_1') is-invalid @enderror"
                                                               value="{{ $user->address_line_1 }}">
                                                        @error('address_line_1')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('Address Line 2') }}</h5>
                                                        <input name="address_line_2" type="text"
                                                               class="with-border @error('address_line_2') is-invalid @enderror"
                                                               value="{{ $user->address_line_2 }}">
                                                        @error('address_line_2')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="submit-field">
                                                        <h5>{{ __('Country') }}</h5>
                                                        <select id="country"
                                                            class="selectpicker with-border @error('country') is-invalid @enderror"
                                                            data-size="7" title="Select Country" data-live-search="true"
                                                            name="country" onchange="getStates();">
                                                            @foreach($countries as $country)
                                                                <option value="{{ $country->id }}"
                                                                        @if($country->id == $user->country) selected @endif>{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 state">
                                                    <div class="submit-field">
                                                        <h5>{{ __('State') }}</h5>
                                                        <select
                                                                class="selectpicker with-border @error('state') is-invalid @enderror"
                                                                data-size="7" title="Select State"
                                                                data-live-search="true" name="state" onchange="getCities()">
                                                            @foreach($states as $state)
                                                                <option value="{{ $state->id }}"
                                                                        @if($state->id == $user->state) selected @endif>{{ $state->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 city">
                                                    <div class="submit-field">
                                                        <h5>{{ __('City') }}</h5>
                                                        <select id="city"
                                                            class="selectpicker with-border @error('city') is-invalid @enderror"
                                                            data-size="7" title="Select City" data-live-search="true"
                                                            name="city">
                                                            @foreach($cities as $city)
                                                                <option value="{{ $city->id }}"
                                                                        @if($city->id == $user->city) selected @endif>{{ $city->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @auth
                            @if(\Illuminate\Support\Facades\Auth::user()->user_type == 'service_provider')
                                <div class="col-xl-12">
                                    <div class="dashboard-box">

                                        <!-- Headline -->
                                        <div class="headline">
                                            <h3><i class="icon-line-awesome-bookmark"></i> Skills</h3>
                                        </div>

                                        <div class="content">
                                            <ul class="fields-ul">
                                                <li>
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="submit-field">
                                                                <h5>{{ __('Choose Your Skills') }}</h5>
                                                                <select id="city"
                                                                        class="selectpicker with-border @error('city') is-invalid @enderror" data-size="10" title="Select Your Skills" data-live-search="true" name="skills[]" multiple>
                                                                    @foreach($skills as $skill)
                                                                        <option value="{{ $skill->id }}"
                                                                        <?php if ( $user->skill != null and in_array($skill->id, json_decode($user->skill))) echo 'selected'?>>{{ $skill->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Dashboard Box -->
                                <div class="col-xl-12">
                                    <div class="dashboard-box">

                                        <!-- Headline -->
                                        <div class="headline">
                                            <h3><i class="icon-line-awesome-book"></i> Documents</h3>
                                        </div>

                                        <div class="content">
                                            <ul class="fields-ul">
                                                <li>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <div class="submit-field">
                                                                    <h5>{{ __('Document 1') }}</h5>
                                                                    @if(!empty($user->doc_1))
                                                                    <!-- Attachments -->
                                                                    <div class="attachments-container margin-top-0 margin-bottom-0">
                                                                        <div class="attachment-box ripple-effect">
                                                                            <span>{{ __('Document 1') }}</span>
                                                                            <button type="button" class="remove-attachment" data-tippy-placement="top" data-tippy="" data-original-title="Remove" onclick="removeDoc({{ $user->id }},1);"></button>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    <div class="clearfix"></div>
                                                                    <!-- Upload Button -->
                                                                    <div class="uploadButton margin-top-0">
                                                                        <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" name="doc_1">
                                                                        <label class="uploadButton-button ripple-effect" for="upload">
                                                                            {{ __('Upload Files') }}
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <div class="submit-field">
                                                                    <h5>{{ __('Document 2') }}</h5>
                                                                    @if(!empty($user->doc_2))
                                                                    <!-- Attachments -->
                                                                    <div class="attachments-container margin-top-0 margin-bottom-0">
                                                                        <div class="attachment-box ripple-effect">
                                                                            <span>{{ __('Document 2') }}</span>
                                                                            <button type="button" class="remove-attachment" data-tippy-placement="top" data-tippy="" data-original-title="Remove" onclick="removeDoc({{ $user->id }},2);"></button>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    <div class="clearfix"></div>
                                                                    <!-- Upload Button -->
                                                                    <div class="uploadButton margin-top-0">
                                                                        <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" name="doc_2">
                                                                        <label class="uploadButton-button ripple-effect" for="upload">
                                                                            {{ __('Upload Files') }}
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="submit-field">
                                                                <div class="submit-field">
                                                                    <h5>{{ __('Document 3') }}</h5>
                                                                @if(!empty($user->doc_3))
                                                                    <!-- Attachments -->
                                                                        <div class="attachments-container margin-top-0 margin-bottom-0">
                                                                            <div class="attachment-box ripple-effect">
                                                                                <span>{{ __('Document 3') }}</span>
                                                                                <button type="button" class="remove-attachment" data-tippy-placement="top" data-tippy="" data-original-title="Remove" onclick="removeDoc({{ $user->id }},3);"></button>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    <div class="clearfix"></div>
                                                                    <!-- Upload Button -->
                                                                    <div class="uploadButton margin-top-0">
                                                                        <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" name="doc_3">
                                                                        <label class="uploadButton-button ripple-effect" for="upload">
                                                                            {{ __('Upload Files') }}
                                                                        </label>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth
                        <!-- Button -->
                        <div class="col-xl-12">
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" class="button ripple-effect big margin-top-30">Save Changes</button>
                        </div>

                    </div>
                    <!-- Row / End -->
                </form>
                <!-- Footer -->
                <div class="dashboard-footer-spacer"></div>

            </div>
        </div>
        <!-- Dashboard Content / End -->

    </div>
    <!-- Dashboard Container / End -->
@endsection
@section('script')
    <script>
        function getStates() {
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('get.states') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    country: country
                },
                success: function (data) {
                    console.log(data);
                    $('.state').html(null);
                    $('.state').html(data);
                    getCities();
                }
            });
        }

        function getCities() {
            var state = $('select#state').val();
            var country = $('select#country').val();
            $.ajax({
                type: "POST",
                url: '{{ route('get.cities') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    state: state,
                    country: country,
                },
                success: function (data) {
                    console.log(data);
                    $('.city').html(null);
                    $('.city').html(data);
                }
            });
        }
        function removeDoc(user_id,doc) {
            $.ajax({
                type: "POST",
                url: '{{ route('remove.doc') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id,
                    doc: doc,
                },
                success: function (data) {
                    location.reload();
                }
            });
        }

    </script>
@endsection
