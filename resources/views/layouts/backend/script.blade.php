<script src="{{ asset('backend/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('backend/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('js/method.js') }}"></script>
<script src="{{ asset('js/plugin.js') }}"></script>
<script src="{{ asset('backend/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('backend/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
<script src="{{ asset('js/notif.js') }}"></script>
<script>
    localStorage.setItem("route_counter_notif", "{{ route('backend.counter_notif') }}");
</script>
<script>
    counter_notif(localStorage.getItem("route_counter_notif"));
</script>


@stack('custom-scripts')
