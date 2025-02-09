@vite(['resources/css/app.css', 'resources/js/app.js'])
@if (session('success'))
<div class="alert alert-success  fade show position-absolute top-0 end-0 m-3 z-3 w-auto font-paragraph text-uppercase" role="alert">
    <strong>{{ session('success') }}</strong>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').classList.remove('show');
        }, 5000);
    </script>
</div>
@endif
