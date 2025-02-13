<!DOCTYPE html>

<html
  lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-no-customizer"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sistem Informasi Seminar Menara Syariah</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/libs/animate-css/animate.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('Template/master/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('Template/master/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('Template/master/js/config.js') }}"></script>
  </head>

  <body>
    @yield('content')

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('Template/master/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="{{ asset('Template/master/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('Template/master/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('Template/master/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('Template/master/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('Template/master/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('Template/master/js/ui-toasts.js') }}"></script>
    <script src="{{ asset('Template/master/js/pages-auth.js') }}"></script>

    {!! Toastr::message() !!}

    @yield('script')
  </body>
</html>
