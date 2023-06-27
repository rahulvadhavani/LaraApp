<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- cdn jqdatatable -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<!-- cdn jqdatatable end -->
<!-- <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script> -->
<!-- <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script> -->
<script type="text/javascript" src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('plugins/jquery-validation/additional-methods.min.js')}}"></script>
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('js/custom.js') }}"></script>
@stack('script')