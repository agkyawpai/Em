@extends('layout/app')
@section('title')
    Employee List
@endsection
@section('header')
    <style>
        th {
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="container rounded col-lg-11 mt-5 mb-3 pt-3 shadow-lg shadow-intensity-xl" style="border: 10px;">
            <h2 class="mb-4"><a href="{{ route('employees.index') }}" style="color:white">{{ __('messages.list') }}</a></h2>
            <!-- check if success messages exists, and if so show them -->
            @if ($success_del = Session::get('success_del'))
                <div class="alert alert-success alert-block mt-4 col-lg-6">
                    <strong>{{ $success_del }}</strong>
                </div>
            @endif
            @if ($success_update = Session::get('success_update'))
                <div class="alert alert-success alert-block mt-4 col-lg-6">
                    <strong>{{ $success_update }}</strong>
                </div>
            @endif
            @if ($error = Session::get('error'))
                <div class="alert alert-danger alert-block mt-4 col-lg-6">
                    <strong>{{ $error }}</strong>
                </div>
            @endif
            @if ($error_register = Session::get('error_register'))
                <div class="alert alert-danger alert-block mt-4 col-lg-6">
                    <strong>{{ $error_register }}</strong>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-7">
                        <form action="{{ route('employees.index') }}" method="GET" class="mb-3" >
                            <div class="input-group">
                                <input type="text" class="form-control" name="search"
                                    placeholder="{{ __('messages.employee_id') }}" value="{{ request('search') }}"
                                    {{ $active_employees == 0 ? ' disabled' : '' }}>
                                <select class="form-control" name="search_career_path"
                                    {{ $active_employees == 0 ? 'disabled' : '' }}>
                                    <option value=0>{{ __('messages.career_path') }}</option>
                                    @foreach ($careerPaths as $pathId => $pathName)
                                        @if ($emp_not_paginated->where('career_path', $pathId)->isNotEmpty())
                                            <option value="{{ $pathId }}"
                                                {{ request('search_career_path') == $pathId ? 'selected' : '' }}>
                                                {{ $pathName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select class="form-control" name="search_level"
                                    {{ $active_employees == 0 ? 'disabled' : '' }}>
                                    <option value=0>{{ __('messages.level') }}</option>
                                    @foreach ($levels as $levelId => $levelName)
                                        @if ($emp_not_paginated->where('level', $levelId)->isNotEmpty())
                                            <option value="{{ $levelId }}"
                                                {{ request('search_level') == $levelId ? 'selected' : '' }}>
                                                {{ $levelName }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                &nbsp;
                                <div class="input-group-append">
                                    <button class="btn btn-outline-light{{ $active_employees == 0 ? ' disabled' : '' }}"
                                        type="submit"><i
                                            class="fa-sharp fa-solid fa-magnifying-glass"></i>{{ __('messages.search') }}</button>
                                    <a href="{{ route('employees.index') }}"
                                        class="btn btn-outline-light{{ $active_employees == 0 ? ' disabled' : '' }}">{{ __('messages.all') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-5 text-end">
                        <a href="{{ route('employees.download-pdf', request()->query()) }}"
                            class="btn btn-light{{ $employees->isEmpty() ? ' disabled' : '' }}"><i class="fa fa-download"
                                aria-hidden="true"></i> PDF</a>
                        <a href="{{ route('employees.export-excel', request()->query()) }}"
                            class="btn btn-light{{ $employees->isEmpty() ? ' disabled' : '' }}"><i class="fa fa-download"
                                aria-hidden="true"></i> Excel</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <table class="table table-bordered custom-table table-hover">
                    <caption style="color:white">{{ __('messages.count') }} : {{ $employees->total() }} </caption>
                    <thead>
                        <tr>
                            <th>{{ __('messages.no') }}</th>
                            <th>{{ __('messages.employee_id') }}</th>
                            <th>{{ __('messages.employee_name') }}</th>
                            <th>{{ __('messages.email') }}</th>
                            <th>{{ __('messages.career_path') }}</th>
                            <th>{{ __('messages.level') }}</th>
                            <th>{{ __('messages.phone') }}</th>
                            <th width=15%>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = ($employees->currentPage() - 1) * $employees->perPage() + 1; //logic to continue counting after pagination
                        @endphp
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $employee['employee_id'] }}</td>
                                <td>{{ $employee['name'] }}</td>
                                <td>{{ $employee['email'] }}</td>
                                <td>
                                    @if (isset($careerPaths[$employee['career_path']]))
                                        {{ $careerPaths[$employee['career_path']] }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($levels[$employee['level']]))
                                        {{ $levels[$employee['level']] }}
                                    @endif
                                </td>
                                <td>{{ $employee['phone'] }}</td>
                                <td>
                                    <div style="text-align: center">
                                        {{-- detail --}}
                                        <a href="{{ route('employees.detail', ['id' => $employee->id, 'page' => $currentPage]) }}" class="detail-link"> <i
                                                data-toggle="tooltip" data-placement="top"
                                                title="{{ __('messages.detail') }}" class="fa-solid fa-circle-info fa-xl"
                                                style="color:darkslategrey"></i></a>
                                        {{-- edit --}}
                                        <a href="{{ route('employees.edit', ['id' => $employee->id, 'page' => $currentPage]) }}" class="edit-link"><i
                                                data-toggle="tooltip" data-placement="top"
                                                title="{{ __('messages.edit') }}"
                                                class="fa-sharp fa-solid fa-pen fa-xl ms-3" style="color:goldenrod"></i></a>
                                        {{-- delete --}}
                                        <i href="#" class="fa-solid fa-trash fa-xl ms-3" data-toggle="tooltip"
                                            data-placement="top" title="{{ __('messages.delete') }}"
                                            style="color:red; cursor:pointer" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $employee->id }}"></i>
                                    </div>
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $employee->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h4 style="color:black">{{ __('messages.delete_comfirm') }}
                                                        {{ $employee->name }}?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <form
                                                        action="{{ route('employees.destroy', ['id' => $employee->id, 'page' => $currentPage]+ request()->query()) }}"
                                                        method="POST" style="display: inline" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger">{{ __('messages.delete') }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if ($employees->isEmpty())
                            <tr>
                                <td colspan="8" class="text-center">{{ __('messages.no_data') }} <a
                                        href="{{ route('employee.register_form') }}">{{ __('messages.register_link') }}</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
