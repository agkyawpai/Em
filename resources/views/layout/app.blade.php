<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <title>
        @yield('title')
    </title>
    <style>
        @media (max-width: 480px) {
            .title {
                font-size: 16px;
                font-weight: bold;
                padding-top: 10px;
                padding-left: 30px;
            }
        }

        .container {
            border: 1px solid;
            background-color: #888eb7;
        }

        body {
            background-color: #bdc0d6;
            font-family: 'Roboto Medium', sans-serif;
        }

        .navbar {
            background-color: #888eb7;
            padding: 10px;
        }

        .nav-links {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links li {
            display: inline-block;
            margin-right: 10px;
        }

        .nav-links li a {
            text-decoration: none;
            color: #fff;
            padding: 5px;
            border-radius: 5px;
        }

        .nav-links li a:hover {
            background-color: #fff;
            color: #333;
            transition: background-color 0.3s ease-in-out;
        }

        .nav-links li a:hover::after {
            content: "";
            display: block;
            height: 2px;
            background-color: #333;
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }

        .nav-links li a:hover::after {
            transform: scaleX(1);
        }

        .nav-links .ml-auto {
            margin-left: auto;
        }

        a:link {
            text-decoration: none;
            color: black;
        }

        a:hover {
            color: rgb(34, 104, 255);
        }

        h1,
        h2,
        h3,
        label,
        p {
            color: white;
        }

        .table-container {
            background-color: #f8f9fa;
            /* Light gray background color */
            padding: 20px;
        }


        th {
            text-align: center;
        }

        .custom-table {
            background-color: #f8f9fa;
            color: #212529;
        }

        .custom-table thead th {
            text-decoration-color: #212529 color: #fff;
        }

        .custom-table tbody td {
            background-color: #ffffff;
        }

        .checkbox-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-save,
        .btn-reset {
            padding: 10px 20px;
            font-size: 16px;
        }

        .required-field::after {
            content: '*';
            color: red;
        }

        .text-black::after {
            color: #212529;
        }

        .blank-circle {
            background-color: lightgray;
        }

        .logout {
            float: right;
        }

        .p-style9 p {
            color: white;
            display: inline-block;
            margin-right: 20px;
        }

        .rounded {
            border-radius: .70rem !important
        }

        .free-employee {
            background-color: lightblue;
            color: black;
        }

        .assigned-employee {
            background-color: lightcoral;
            color: black;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: max-content;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        #loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.75) url("../../../upload/abc.gif") no-repeat center center;
            z-index: 99999;
        }
    </style>
    @yield('header')
</head>

<body>
    <!-- show nav bar except login page -->
    @if (request()->route()->getName() !== 'employees.login')
        <nav class="navbar navbar-expand-lg navbar-custom">
            <a class="navbar-brand ms-3" style="color: white;">Employee Assigns</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto nav-links">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route()->getName() === 'employees.index'? 'active': '' }}"
                            href="{{ route('employees.index') }}">{{ __('messages.list') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route()->getName() === 'employee.register_form'? 'active': '' }}"
                            href="{{ route('employee.register_form') }}">{{ __('messages.employee_register') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route()->getName() === 'employees.assign-form'? 'active': '' }}"
                            href="{{ route('employees.assign-form') }}">{{ __('messages.add_assign') }}</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav nav-links ms-auto mb-2 mb-lg-0">
                    <li>
                        <div style="display: flex;">
                            <a class="nav-link"
                                href="{{ route('set.language', 'en') }}"><span>&#x1F1FA;&#x1F1F8;</span></a>
                            <a class="nav-link"
                                href="{{ route('set.language', 'mm') }}"><span>&#x1F1F2;&#x1F1F2;</span></a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('employees.logout') }}">{{ __('messages.logout') }}</a>
                    </li>
                </ul>

            </div>
        </nav>
    @endif
    <div id='loader'></div>
    @yield('content')
    <script>
        $(document).ready(function() {
            $("form").submit(function() {
                $('#loader').show();
            });

            $(".delete-form").submit(function() {
                $('#loader').show();
            });

            $('.detail-link, .edit-link, .nav-link, .back-link').click(function() {
                $('#loader').show();
            });
        });
    </script>
    @yield('scripts')
    @yield('footer')
</body>

</html>
