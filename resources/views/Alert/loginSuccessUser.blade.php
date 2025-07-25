@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Success Message Toast -->
@if (session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-bold">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap toast and auto-hide after 3 seconds
    const toastEl = document.querySelector('.toast');
    const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
    
    setTimeout(() => {
        toast.hide();
    }, 3000);
    
    // Also hide when clicked
    toastEl.addEventListener('click', () => toast.hide());
});
</script>
@endif