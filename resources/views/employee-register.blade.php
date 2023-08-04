@extends('layout/app')
@section('title')
    Register
@endsection
@section('header')
    <style>
        th {
            text-align: center;
        }

        .error-input {
            border-color: red !important;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('employee.register') }}" method="POST" enctype="multipart/form-data">
        <div class="container rounded shadow-lg shadow-intensity-xl col-lg-10 mt-2 mb-3 pt-3" style="border: 10px;">
            <h1>{{ __('messages.employee_register') }}</h1>
            @csrf
            <!-- check if success messages exists, and if so show them -->
            @if ($success_msg = Session::get('success'))
                <div class="alert alert-success alert-block mt-4">
                    <strong>{{ $success_msg }}</strong>
                </div>
            @endif
            @if ($error_msg = Session::get('error'))
                <div class="alert alert-success alert-block mt-4">
                    s alert-block mt-4">
                    {{ $error_msg }}</strong>
                </div>
            @endif
            <div class="row">
                <!-- Image -->
                <div class="form-group col-lg-6">
                    <div id="photo-container" class="blank-circle"
                        style="display: flex; align-items: center; justify-content: center; width: 150px; height: 150px; border-radius: 50%; margin-top: 10px; overflow: hidden;">
                        <div id="image-wrapper"
                            style="width: 100%; height: 100%; background-size: cover; background-position: center; background-repeat: no-repeat;">
                        </div>
                    </div>
                    <div class="input-group mt-3">
                        <label for="image" class="required-field">{{ __('messages.choose_photo') }} <i
                                class="fa-solid fa-image fa-xl" style="color: darkslategrey; cursor:pointer"></i></label>
                        <input class="form-control form-control-sm" id="image" style="visibility: hidden" type="file"
                            name="image" accept="image/*" onchange="previewPhoto(event)">
                    </div>
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-6"></div>
                <!-- Employee ID -->
                <div class="form-group col-lg-6 mt-3">
                    <label for="employee_id" class="required-field">{{ __('messages.employee_id') }}</label>
                    <input type="text" name="employee_id" class="form-control"
                        value="{{ str_pad($employee_id + 1, 5, '0', STR_PAD_LEFT) }}" readonly>
                    @error('employee_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Employee Name -->
                <div class="form-group col-lg-6 mt-3">
                    <label for="name" class="required-field">{{ __('messages.employee_name') }}</label>
                    <input type="text" name="name" maxlength="50"
                        class="form-control {{ $errors->has('name') ? ' error-input' : '' }}" value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- NRC -->
                <div class="form-group col-lg-6 mt-3">
                    <label for="nrc" class="required-field">{{ __('messages.nrc') }}</label>
                    <input type="text" name="nrc" maxlength="50"
                        class="form-control {{ $errors->has('nrc') ? ' error-input' : '' }}" value="{{ old('nrc') }}">
                    @error('nrc')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Phone Number -->
                <div class="form-group col-lg-6 mt-3">
                    <label for="phone" class="required-field">{{ __('messages.phone') }}</label>
                    <input type="text" name="phone" id="phone" maxlength="11"
                        class="form-control {{ $errors->has('phone') ? ' error-input' : '' }}"
                        value="{{ old('phone') }}">
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-lg-6 mt-3">
                    <!-- Email -->
                    <label for="email" class="required-field">{{ __('messages.email') }}</label>
                    <input type="text" name="email" maxlength="50"
                        class="form-control {{ $errors->has('email') ? ' error-input' : '' }}"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <!-- Date of Birth -->
                    <label for="dob" class="required-field mt-1">{{ __('messages.date_of_birth') }}</label>
                    <input type="date" name="dob" maxlength="50"
                        class="form-control {{ $errors->has('dob') ? ' error-input' : '' }}"
                        value="{{ old('dob')? old('dob'): \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}">
                    @error('dob')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Address -->
                <div class="form-group col-lg-6 mt-3">
                    <label for="address" class="required-field">{{ __('messages.address') }}</label>
                    <textarea name="address" class="form-control {{ $errors->has('address') ? ' error-input' : '' }}" rows="4">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Gender -->
                <div class="form-group col-lg-6 mt-3">
                    <label class="required-field">{{ __('messages.gender') }}</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="1"
                            {{ old('gender') == 1 ? 'checked' : 'checked' }}>
                        <label class="form-check-label text-black" for="male">
                            {{ __('messages.male') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="2"
                            {{ old('gender') == 2 ? 'checked' : '' }}>
                        <label class="form-check-label text-black" for="female">
                            {{ __('messages.female') }}
                        </label>
                    </div>
                    @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Language -->
                <div class="form-group col-lg-6 mt-3">
                    <label class="required-field">{{ __('messages.language') }}</label>
                    <div class="checkbox-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="language[]" id="english"
                                value="1" {{ in_array(1, old('language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="english">
                                {{ __('messages.english') }}
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="language[]" id="japanese"
                                value="2" {{ in_array(2, old('language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="japanese">
                                {{ __('messages.japanese') }}
                            </label>
                        </div>
                    </div>
                    @error('language')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Programming Language -->
                <div class="form-group col-lg-6 mt-3">
                    <label class="required-field">{{ __('messages.programming_language') }}</label>
                    <div class="checkbox-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="programming_language[]" id="cpp"
                                value="1" {{ in_array(1, old('programming_language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="cpp">
                                C++
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="programming_language[]" id="java"
                                value="2" {{ in_array(2, old('programming_language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="java">
                                Java
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="programming_language[]" id="php"
                                value="3" {{ in_array(3, old('programming_language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="php">
                                PHP
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="programming_language[]" id="react"
                                value="4" {{ in_array(4, old('programming_language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="react">
                                React
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="programming_language[]" id="android"
                                value="5" {{ in_array(5, old('programming_language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="android">
                                Android
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="programming_language[]" id="laravel"
                                value="6" {{ in_array(6, old('programming_language', [])) ? 'checked' : '' }}>
                            <label class="form-check-label text-black" for="laravel">
                                Laravel
                            </label>
                        </div>
                    </div>
                    @error('programming_language')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-6"></div>
                <!-- Career Path -->
                <div class="form-group col-lg-6 mt-3">
                    <label for="career_path" class="required-field">{{ __('messages.career_path') }}</label>
                    <select name="career_path" class="form-control" value="{{ old('title') }}"">
                        <option value="1" {{ old('career_path') == 1 ? 'selected' : '' }}>Front End</option>
                        <option value="2" {{ old('career_path') == 2 ? 'selected' : '' }}>Back End</option>
                        <option value="3" {{ old('career_path') == 3 ? 'selected' : '' }}>Full Stack</option>
                        <option value="4" {{ old('career_path') == 4 ? 'selected' : '' }}>Mobile</option>
                    </select>
                    @error('career_path')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                <!-- Level -->
                <div class="form-group col-lg-6 mt-3">
                    <label for="level" class="required-field">{{ __('messages.level') }}</label>
                    <select name="level" class="form-control" value="{{ old('level') }}"">
                        <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>Beginner</option>
                        <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Junior Engineer</option>
                        <option value="3" {{ old('level') == 3 ? 'selected' : '' }}>Engineer</option>
                        <option value="4" {{ old('level') == 4 ? 'selected' : '' }}>Senior Engineer</option>
                    </select>
                    @error('level')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                {{-- Loading Spinner
                <div id="loading-spinner" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div> --}}
                <!-- Buttons -->
                <div class="form-group col-lg-6">
                    <button type="submit" class="btn btn-success btn-save mt-3">{{ __('messages.save') }}</button>
                    <a href="{{ route('employee.register_form') }}"
                        class="btn btn-danger btn-reset mt-3">{{ __('messages.reset') }}</a>
                </div>
            </div>
            <hr>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        // Function to preview the uploaded photo
        function previewPhoto(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var imageWrapper = document.getElementById('image-wrapper');
                imageWrapper.style.backgroundImage = 'url(' + reader.result + ')';
                imageWrapper.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
