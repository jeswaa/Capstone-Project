@vite(['resources/css/app.css', 'resources/js/app.js'])
@if (session('errorEmail'))
<div class="alert alert-danger position-absolute top-0 start-0 m-3 z-3 w-auto font-paragraph " role="alert">
    <strong>{{ session('errorEmail') }}</strong>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').classList.remove('show');
        }, 5000);
    </script>
</div>
@endif
