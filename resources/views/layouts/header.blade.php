<link rel="dns-prefetch" href="//fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<!-- Scripts -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/toastr/toastr.css') }}">
<style>
    .btn-circle {
        width: 33px;
        height: 33px;
        border-radius: 50%;
        padding: 7px;
        display: inline-block;
        align-items: center;
        justify-content: center;
    }

    .error {
        color: red;
    }

    .image_preview {
        width: 150px !important;
        height: 150px !important;
        margin-top: 17px;
        margin-left: 16px;
    }
</style>
@stack('style')