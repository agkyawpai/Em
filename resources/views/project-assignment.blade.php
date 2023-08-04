@extends('layout.app')
@section('title')
    Project Assignment
@endsection
@section('content')
    @php
        use App\Logics\FreeEmpLogic;
        $freeEmpLogic = new FreeEmpLogic();
    @endphp
    <form action="{{ route('assigns.save') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container rounded col-lg-10 mt-2 mb-2 pt-2 pb-3" style="border: 10px;">
            <h1>{{ __('messages.add_assign') }}</h1>
            {{-- success error messages --}}
            @if ($success_msg = Session::get('success'))
                <div class="alert alert-success alert-block mt-4 col-lg-6">
                    <strong>{{ $success_msg }}</strong>
                </div>
            @endif
            @if ($success_msg_pj = Session::get('success-pj'))
                <div class="alert alert-success alert-block mt-4 col-lg-6">
                    <strong>{{ $success_msg_pj }}</strong>
                </div>
            @endif
            @if ($success_pj_remove = Session::get('success-pj-remove'))
                <div class="alert alert-success alert-block mt-4 col-lg-6">
                    <strong>{{ $success_pj_remove }}</strong>
                </div>
            @endif
            @if ($error = Session::get('error'))
                <div class="alert alert-danger alert-block mt-4 col-lg-6">
                    <strong>{{ $error }}</strong>
                </div>
            @endif
            @if ($error = Session::get('error_assign'))
                <div class="alert alert-danger alert-block mt-4 col-lg-6">
                    <strong>{{ $error }}</strong>
                </div>
            @endif
            <!-- Employee ID -->
            <div class="form-group col-lg-6 mt-2 mb-2 pt-2">
                <label for="employee_id" class="required-field">{{ __('messages.employee_id') }}</label>
                <select name="employee_id" id="employee_id" class="form-control">
                    {{-- to show all employee_ids in option --}}
                    <option value="">{{ __('messages.select_emp') }}</option>
                    @isset($employees)
                        @foreach ($employees as $employee)
                            @php
                                $today = date('Y-m-d');
                                $styleClass = $freeEmpLogic->empFreeTdy($employee['id']) ? 'free-employee' : 'assigned-employee';
                                $projectDetails = $freeEmpLogic->empFreeTdy($employee['id']) ? FreeEmpLogic::getProjectDetails($employee['id'], $today) : FreeEmpLogic::getProjectDetails($employee['id'], $today);
                            @endphp
                            {
                            <option value="{{ $employee['id'] }}" {{ old('employee_id') == $employee['id'] ? 'selected' : '' }}
                                class="{{ $styleClass }}" title="{{ $projectDetails }}">
                                {{ $employee['employee_id'] }}
                            </option>
                            }
                        @endforeach
                    @endisset
                </select>
                @error('employee_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Employee Name -->
            <div class="form-group col-lg-6 mt-2 mb-2 pt-2">
                <label for="employee_name" class="required-field">{{ __('messages.employee_name') }}</label>
                <input type="text" name="employee_name" id="employee_name" class="form-control"
                    value="{{ old('employee_name') }}" readonly>
            </div>
            <!-- Project Name -->
            <div class="form-group col-lg-6 mt-2 mb-2 pt-2">
                <label for="project_name" class="required-field">{{ __('messages.project_name') }}</label>
                <div class="d-flex">
                    <select name="project_name" id="project_name" class="form-control">

                        <option value="">{{ __('messages.select_project') }}</option>
                        {{-- to show all projects in option --}}
                        @foreach ($projects as $project)
                            {
                            <option value="{{ $project['name'] }}"
                                {{ old('project_name') == $project['name'] ? 'selected' : '' }}>{{ $project['name'] }}
                            </option>
                            }
                        @endforeach
                    </select>
                    <div class="ml-2">
                        <a style="cursor: pointer"><i class="fa-solid fa-plus fa-xl" style="color: #ffffff"
                                data-bs-toggle="modal" data-bs-target="#projectRegistrationModal"></i></a>
                    </div>
                    &nbsp;
                    <div class="ml-2">
                        <a style="cursor: pointer"><i class="fa-solid fa-minus fa-xl" style="color: #ffffff"
                                data-bs-toggle="modal" data-bs-target="#projectRemoveModal"></i></a>
                    </div>
                </div>
                @error('project_name')
                    <span class="text-danger">
                        {{ $errors->first('project_name') }}
                    </span>
                @enderror


            </div>
            <!-- Start Date -->
            <div class="form-group col-lg-6 mt-2 mb-2 pt-2">
                <label for="start_date" class="required-field">{{ __('messages.start_date') }}</label>
                <input type="date" name="start_date" class="form-control"
                    value="{{ old('start_date') ? old('start_date') : date('Y-m-d') }}">
                @error('start_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- End Date -->
            <div class="form-group col-lg-6 mt-2 mb-2 pt-2">
                <label for="end_date" class="required-field">{{ __('messages.end_date') }}</label>
                <input type="date" name="end_date" class="form-control"
                    value="{{ old('end_date') ? old('end_date') : date('Y-m-d') }}">
                @error('end_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Documentation -->
            <div class="form-group col-lg-6 mt-2 mb-2 pt-2">
                <label for="documentation" class="required-field">{{ __('messages.documentation') }}</label>
                <div class="input-group">
                    <input type="file" name="documentation[]" class="form-control" id="documentation" multiple>
                    <div class="input-group-append">
                        <button class="btn btn-danger" type="button"
                            id="documentation-clear-btn">{{ __('messages.clear_file') }}</button>
                    </div>
                </div>
                @error('documentation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('documentation.*')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Save Button -->
            <div class="form-group col-lg-6 mt-2 mb-2">
                <button type="submit" class="btn btn-success btn-save mt-2">{{ __('messages.save') }}</button>
                <!-- Reset Button -->
                <button type="reset" class="btn btn-danger btn-save mt-2">{{ __('messages.reset') }}</button>
            </div>
        </div>
    </form>

    <!-- Project Registration Modal -->
    <div class="modal fade" id="projectRegistrationModal" tabindex="-1" role="dialog"
        aria-labelledby="projectRegistrationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectRegistrationModalLabel">{{ __('messages.project_register') }}</h5>
                    <button class="btn-close" id="closeModalBtn" data-bs-dismiss="modal"
                        onclick="clearErrorMessage()"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('projects.save') }}">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="name" style="color:black"
                                class="required-field">{{ __('messages.project_name') }}</label>
                            <input type="text" maxlength="50" name="project_name_modal" id="project_name_modal"
                                value="" class="form-control">
                        </div>
                        @error('project_name_modal')
                            <span id="projectNameError" class="text-danger">
                                {{ $errors->first('project_name_modal') }}
                            </span>
                        @enderror

                        <div class="modal-footer">
                            <button type="submit" id="saveProjectButton"
                                class="btn btn-success">{{ __('messages.save') }}</button>
                            <button type="reset" id="removeBtn"
                                class="btn btn-danger">{{ __('messages.reset') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Project Remove Modal -->
    <div class="modal fade" id="projectRemoveModal" tabindex="-1" role="dialog"
        aria-labelledby="projectRemoveModalLabel" aria-hidden="true" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="projectRemoveModalLabel">{{ __('messages.select_project_remove') }}</h5>
                    <button type="button" id="closeModalBtn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('projects.remove') }}" class="loaging_form">
                        @csrf
                        <div class="form-group mb-2">
                            <select name="project_id" id="project_remove_select" class="form-control">
                                <option value="" disabled selected>{{ __('messages.select_project') }}</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project['id'] }}"
                                        {{ old('project_id') == $project['id'] ? 'selected' : '' }}>
                                        {{ $project['name'] }}</option>
                                @endforeach
                            </select>
                            <span id="projectNameError" class="text-danger">
                                @if ($error_pj_remove = Session::get('error-pj-remove'))
                                    {{ $error_pj_remove }}
                                @endif
                            </span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">{{ __('messages.delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            var selectedEmployeeId = "{{ old('employee_id') }}";

            function clearModalFields() {
                $('#project_name_modal').val('');
                $('#project_remove_select').val('');
                $('#projectNameError').text('');
            }

            function clearErrorMessage() { //function to remove error message in modal form after close btn is clicked
                $('#projectNameError').text('');
            }

            $(document).ready(function() { //use function in close btn
                $('#closeModalBtn, #removeBtn').on('click', function() {
                    $('#project_name_modal').val('');
                    $('#project_remove_select').val('');
                    clearErrorMessage();
                });
            });



            $(document).ready(function() { //show error message again after error occurs
                @error('project_name_modal')
                    $('#projectRegistrationModal').modal('show');
                @enderror
                @if ($error_pj_remove = Session::get('error-pj-remove'))
                    $('#projectRemoveModal').modal('show', );
                @endif
            });

            $(document).ready(function() {
                // clear modal fields and error messages when clicking outside the modal
                $('.modal').on('click', function(e) {
                    if ($(e.target).hasClass('modal')) {
                        clearModalFields();
                    }
                });
            });

            // update employee name and selected employee ID in the assignment form after employee ID is changed
            $('#employee_id').on('change', function() {
                var employeeId = $(this).val();
                var employeeName = ""; // set default employee name

                // find the corresponding employee name based on the selected employee ID
                @isset($employees)
                    @foreach ($employees as $employee)
                        if (employeeId == "{{ $employee['id'] }}") {
                            employeeName = "{{ $employee['name'] }}";
                        }
                    @endforeach
                @endisset

                // update the employee name input value and selected employee ID input value
                $('#employee_name').val(employeeName);
            });

            // for clearing multiple input files
            document.getElementById('documentation-clear-btn').addEventListener('click', function() {
                var fileInput = document.getElementById('documentation');
                fileInput.value = ''; // clear the selected files
            });


            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    @endsection
