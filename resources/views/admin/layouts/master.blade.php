<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->sitename($pageTitle ?? '') }}</title>
    <!-- site favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap">
    <!-- bootstrap 4  -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/grid.min.css') }}">
    <!-- bootstrap toggle css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap-toggle.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/font-awesome.css') }}">
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.css') }}">

    @stack('style-lib')

    <!-- custom select box css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/nice-select.css') }}">
    <!-- code preview css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/prism.css') }}">
    <!-- select 2 css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/select2.min.css') }}">
    <!-- jvectormap css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/jquery-jvectormap-2.0.5.css') }}">
    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/datepicker.min.css') }}">
    <!-- timepicky for time picker css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/jquery-timepicky.css') }}">
    <!-- bootstrap-clockpicker css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap-clockpicker.min.css') }}">
    <!-- bootstrap-pincode css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap-pincode-input.css') }}">
    <!-- dashdoard main css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/app.css') }}">

    <style>
        ::-webkit-scrollbar {
            width: 2px;
        }

        ::-webkit-scrollbar-track {
            background-color: #ebebeb;
            -webkit-border-radius: 10px;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            -webkit-border-radius: 10px;
            border-radius: 10px;
            background: #515151;
        }

        button.close.btn.btn--danger {
            margin: 0px;
        }

        .sidebar__menu .sidebar-menu-item .side-menu--open,
        .sidebar__menu .sidebar-menu-item.active>a {
            background: none;
            border-radius: 1px;
        }

        .sidebar__menu .menu-title {
            font-size: 14px;
            color: #B7BCC1;
            font-weight: 400;
            letter-spacing: 0.5px;

        }

        li.sidebar-menu-item.active {
            border-left: 3px solid #a7e458;
            background: linear-gradient(88deg, #4a4a4a, #000000);
        }

        .sidebar__menu .menu-icon {
            color: #B7BCC1;
            font-size: 1.125rem;
            margin-right: 15px;
            transition: all 0.5s;
            text-shadow: 1px 2px 5px rgba(0, 0, 0, 0.15);
        }

        .navbar__expand::before {
            position: absolute;
            content: none;
            top: 4px;
            left: 4px;
            width: 7px;
            height: 7px;
            background-color: #5b6e88;
            border-radius: 50px;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            -ms-border-radius: 50px;
            -o-border-radius: 50px;
            opacity: 1;
            -webkit-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
        }

        .navbar__expand::after {
            position: absolute;
            content: none;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 1.5px solid #ffffff;
            border-radius: 50%;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
        }

        .sidebar__menu .active .menu-title {
            font-size: 14px;
            color: #a7e458;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        body {
            font-family: "Montserrat", sans-serif;
            font-size: 1rem;
            padding: 0;
            margin: 0;
            font-weight: 400;
            position: relative;
            background-color: #f9f9f9;
            word-break: break-word;
        }

        .navbar-wrapper {
            position: relative;
            background: none;
            padding: 15px 30px;
            margin-left: 250px;
            border-bottom: 1px solid #dee4ec;
            box-shadow: none;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            transition: all 0.5s cubic-bezier(0.4, -0.25, 0.25, 1.1);
        }

        .navbar-wrapper {
            position: relative;
            background: none;
            padding: 15px 30px;
            margin-left: 0px;
            border-bottom: 1px solid #dee4ec;
            box-shadow: none;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            transition: all 0.5s cubic-bezier(0.4, -0.25, 0.25, 1.1);
        }

        .dashboard-w1 .details .status,
        .dashboard-w1 .details .amount,
        .dashboard-w1 .details .currency-sign {
            color: #000000;
            font-size: 24px;
            font-weight: 500;
            line-height: 1;
        }

        .dashboard-w1 .details .desciption span {
            color: #000000;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            margin-top: 5px;
        }

        .dashboard-w1 .icon {
            position: absolute;
            bottom: 40px;
            left: 25px;
        }

        .dashboard-w1 .icon i {
            font-size: 30px;
            color: #4c4c4c;
            margin-left: 0px;
            margin-bottom: -4px;
        }

        .dashboard-w1 .icon {
            background: linear-gradient(153deg, #c3c3c3, white);
            position: absolute;
            bottom: 57px;
            left: 25px;
            padding: 6px;
        }

        /* .navbar-wrapper {
        margin-left: 232px;
        }    */
        @media only screen and (max-width: 480px) {
            .navbar__left h4 {
                position: absolute !important;
                left: 17px !important;
            }
        }

        .navbar__right {
            margin-left: inherit;
        }

        .navbar__left h4 {
            position: absolute;
            left: 260px;
        }

        .icon-btn {
            padding: 3px 8px;
            background: none;
            color: #000000;
            border-radius: 3px;
            font-size: 13px;
        }

        li.list-group-item.d-flex.justify-content-between.align-items-center {
            border: none;
        }

        .dash-card__body>h6 {
            position: relative;
            top: 40px;
        }

        .dash-card__title {
            position: absolute;
            left: 23px;
            top: 92px;
        }

        a.dash-card__btn {
            position: absolute;
            right: 8px;
            top: 94px;
        }

        .sidebar__menu .sidebar-submenu::before {
            content: none;
        }

        .sidebar__menu .sidebar-submenu .sidebar-menu-item a {
            padding: 10px 20px 10px 68px;
            transition: all 0.3s;
        }

        .sidebar__menu .sidebar-submenu .sidebar-menu-item a .menu-title {
            font-size: 0.82em;
        }

        .icon-button__badge {
            position: absolute;
            /* right: 14px; */
            /* top: 6px; */
            left: 33px;
            width: 25px;
            height: 25px;
            background: red;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            margin-top: 5px;
        }

        .sidebar__menu .sidebar-dropdown>a::before {
            position: absolute;
            top: 15px;
            right: 20px;
            font-family: "Font Awesome 5 Free";
            font-weight: 700;
            content: "\f107";
            font-size: 13px;
            color: #0e0e0e;
            transition: all 0.3s;
        }
    </style>
    @stack('style')
</head>

<body>

    @yield('content')



    <!-- jQuery library -->
    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('assets/admin/js/vendor/grid.bundle.min.js') }}"></script>
    <!-- bootstrap-toggle js -->
    <script src="{{ asset('assets/admin/js/vendor/bootstrap-toggle.min.js') }}"></script>

    <!-- slimscroll js for custom scrollbar -->
    <script src="{{ asset('assets/admin/js/vendor/jquery.slimscroll.min.js') }}"></script>
    <!-- custom select box js -->
    <script src="{{ asset('assets/admin/js/vendor/jquery.nice-select.min.js') }}"></script>


    @include('partials.notify')
    @stack('script-lib')

    <script src="{{ asset('assets/admin/js/nicEdit.js') }}"></script>

    <!-- code preview js -->
    <script src="{{ asset('assets/admin/js/vendor/prism.js') }}"></script>
    <!-- seldct 2 js -->
    <script src="{{ asset('assets/admin/js/vendor/select2.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <!-- Include CKEditor library -->
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
    {{-- LOAD NIC EDIT --}}
    <script>
        "use strict";
        bkLib.onDomLoaded(function() {
            $(".nicEdit").each(function(index) {
                $(this).attr("id", "nicEditor" + index);
                new nicEditor({
                    fullPanel: true
                }).panelInstance('nicEditor' + index, {
                    hasPanel: true
                });
            });
        });
        (function($) {
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });
        })(jQuery);
    </script>
    <script>
        $('.nicEdit').addClass('ck_edt').removeClass('nicEdit');
        $('.edt').addClass('ck_edt').removeClass('nicEdit');
        ClassicEditor
            .create(document.querySelector('.ck_edt'))
            .then(editor => {
                //   // Set the contents of the editor to a string with class name
                //   editor.setData('<p class="my-class-name">This is some text with a class name</p>');
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    @stack('script')


</body>

</html>
