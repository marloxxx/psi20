<!-- Common scripts -->
<script src="{{ asset('frontend/js/jquery-3.6.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/common_scripts_min.js') }}"></script>
<script src="{{ asset('frontend/js/functions.js') }}"></script>
<script src="{{ asset('js/method.js') }}"></script>
<script src="{{ asset('js/toastr.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/notif.js') }}"></script>
<script>
    localStorage.setItem("route_counter_notif", "{{ route('counter_notif') }}");
</script>
