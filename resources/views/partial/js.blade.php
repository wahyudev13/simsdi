<!-- Bootstrap core JavaScript-->
<script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

@stack('custom-scripts')
