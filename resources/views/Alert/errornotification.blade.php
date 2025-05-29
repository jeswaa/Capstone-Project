@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Success Message Toast -->
@if (session('error'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div class="toast show align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-bold">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap toast and auto-hide after 5 seconds
    const toastEl = document.querySelector('.toast');
    const toast = bootstrap.Toast.getOrCreateInstance(toastEl);
    
    setTimeout(() => {
        toast.hide();
    }, 5000);
    
    // Also hide when clicked
    toastEl.addEventListener('click', () => toast.hide());
});
</script>
@endif