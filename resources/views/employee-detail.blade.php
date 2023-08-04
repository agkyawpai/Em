@extends('layout.app')

@section('title')
    {{ __('messages.employee_details') }}
@endsection

@section('content')
    <div class="container rounded shadow-lg shadow-intensity-xl col-lg-10 mt-2 mb-3 pt-3 pb-1" style="border: 10px;">
        <div class="row">
            <div class="col-lg-6">
                <h1>{{ __('messages.employee_details') }}</h1>
            </div>
            <div class="col-lg-6 text-right mb-3">
                <a href="{{ route('employees.index', ['page' => $currentPage]) }}" class="btn btn-secondary back-link">Back</a>
            </div>
        </div>
        <div class="margin-40px-tb">
            <!-- Image -->
            <div class="form-group col-lg-6 mb-4">
                <div id="photo-container" class="blank-circle"
                    style="display: flex; align-items: center; justify-content: center; width: 150px; height: 150px; border-radius: 50%;margin-left: 30px; margin-top: 20px; overflow: hidden;">
                    <div id="image-wrapper"
                        style="width: 100%; height: 100%; background-size: cover; background-position: center; background-repeat: no-repeat; background-image: url('{{ asset('employee_photo/' . $employee->image) }}')">
                    </div>
                </div>
            </div>
            <ul class="no-margin" style="list-style: none">
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-key" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.employee_id') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->employee_id }}</p>
                        </div>
                    </div>

                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fa fa-user" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.employee_name') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->name }}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-id-card" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.nrc') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->nrc }}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-mobile-alt" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.phone') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->phone }}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-envelope" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.email') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->email }}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-birthday-cake" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.date_of_birth') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->date_of_birth }}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-map-marker-alt" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.address') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->address }}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-male" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.gender') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p>{{ $employee->gender == '1' ? 'Male' : 'Female' }}</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-language" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.language') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p class="p-style9" no-margin">
                                @foreach (explode(',', $employee->language) as $index => $language)
                                    @if ($language == '1')
                                        English
                                    @elseif ($language == '2')
                                        Japanese
                                    @endif
                                    @if ($index < count(explode(',', $employee->language)) - 1)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-laptop" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.programming_language') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p class="p-style9" no-margin">
                                @foreach ($programmingLanguages as $index => $programmingLanguage)
                                    @if ($programmingLanguage == '1')
                                        C++
                                    @elseif ($programmingLanguage == '2')
                                        Java
                                    @elseif ($programmingLanguage == '3')
                                        PHP
                                    @elseif ($programmingLanguage == '4')
                                        React
                                    @elseif ($programmingLanguage == '5')
                                        Android
                                    @elseif ($programmingLanguage == '6')
                                        Laravel
                                    @endif
                                    @if ($index < count($programmingLanguages) - 1)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-tasks" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.career_path') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p class="p-style9" no-margin">
                                @if ($employee->career_path == 1)
                                    Front End
                                @elseif ($employee->career_path == 2)
                                    Back End
                                @elseif ($employee->career_path == 3)
                                    Full Stack
                                @elseif ($employee->career_path == 4)
                                    Mobile
                                @endif
                            </p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-md-5 col-5">
                            <i class="fas fa-square" style="color:white"></i>
                            <label class="margin-10px-left">{{ __('messages.level') }} :</label>
                        </div>
                        <div class="col-md-7 col-7">
                            <p class="p-style9" no-margin">
                                @if ($employee->level == 1)
                                    Beginner
                                @elseif ($employee->level == 2)
                                    Junior Engineer
                                @elseif ($employee->level == 3)
                                    Engineer
                                @elseif ($employee->level == 4)
                                    Senior Engineer
                                @endif
                            </p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <hr>
        @if (count($projects) > 0)
            <h2>Projects</h2>
            <ul class="no-margin" style="list-style: none">
                @foreach ($projects as $project)
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-5">
                                <i class="fas fa-project-diagram" style="color:white"></i>
                                <label class="margin-10px-left">{{ __('messages.project_name') }} :</label>
                            </div>
                            <div class="col-md-3 col-3">
                                <p>{{ $project->name }}</p>
                            </div>
                        </div>
                    </li>
                    @php
                        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $project->start_date);
                        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $project->end_date);
                        $now = \Carbon\Carbon::now();
                    @endphp

                    <li>
                        <div class="row">
                            <div class="col-md-5 col-5">
                                <i class="fas fa-calendar" style="color:white"></i>
                                <label class="margin-10px-left">{{ __('messages.start_date') }} :</label>
                            </div>
                            <div class="col-md-2 col-2">
                                <p
                                    style="color: {{ $now->between($startDate, $endDate) || $now->isSameDay($startDate) || $now->isSameDay($endDate) || $now < $startDate ? 'blue' : 'red' }}">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $project->start_date)->format('d-m-Y') }}
                                </p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row">
                            <div class="col-md-5 col-5">
                                <i class="fas fa-calendar" style="color:white"></i>
                                <label class="margin-10px-left">{{ __('messages.end_date') }} :</label>
                            </div>
                            <div class="col-md-2 col-2">
                                <p
                                    style="color: {{ $now->between($startDate, $endDate) || $now->isSameDay($startDate) || $now->isSameDay($endDate) || $now < $startDate ? 'blue' : 'red' }}">
                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $project->end_date)->format('d-m-Y') }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="row">
                            <div class="col-md-5 col-5">
                                <i class="fas fa-file-alt" style="color:white"></i>
                                <label class="margin-10px-left">{{ __('messages.documentation') }} :</label>
                            </div>
                            <div class="col-md-7 col-7">
                                @foreach ($documentations as $documentation)
                                    @if ($project->employee_project_id == $documentation->employee_project_id)
                                        <p>
                                            <a style="text-decoration: underline"
                                                href="{{ route('documentations.download', ['file' => $documentation->filename]) }}">{{ $documentation->filename }}</a>
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </li>
                    <hr>
                @endforeach
            </ul>
        @else
            <p>{{ __('messages.emp_no_project') }}</p>
        @endif
    </div>
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
