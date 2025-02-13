@vite(['resources/css/app.css', 'resources/js/app.js'])
@if (session('errorlogin'))
<div class="alert alert-danger  fade show position-absolute top-0 end-0 m-3 z-3 w-auto font-paragraph " role="alert">
    <strong>{{ session('errorlogin') }}</strong>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').classList.remove('show');
        }, 5000);
    </script>
</div>
@endif
