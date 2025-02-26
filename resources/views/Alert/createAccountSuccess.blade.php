@vite(['resources/css/app.css', 'resources/js/app.js'])
@if (session('AccountCreatedsuccess'))
<div class="alert alert-success  fade show position-absolute top-0 start-0 m-3 z-3 w-auto font-paragraph " role="alert">
    <strong>{{ session('AccountCreatedsuccess') }}</strong>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').classList.remove('show');
        }, 5000);
    </script>
</div>
@endif
