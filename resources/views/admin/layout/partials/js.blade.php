<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('administrator/lib/chart/chart.min.js')}}"></script>
<script src="{{asset('administrator/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('administrator/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('administrator/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('administrator/lib/tempusdominus/js/moment.min.js')}}"></script>
<script src="{{asset('administrator/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
<script src="{{asset('administrator/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('administrator/js/main.js')}}"></script>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#description',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        height: 300
    });
</script>