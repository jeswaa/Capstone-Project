@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Toast Notifications Container -->
<div class="position-fixed top-0 end-0 mt-3 me-3" style="z-index: 9999;">
    @if (session('info'))
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('info') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
    
    @if (session('show_otp_modal'))
        <!-- OTP Modal will be shown automatically via JavaScript -->
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide toasts after 5 seconds
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        setTimeout(() => {
            bsToast.hide();
        }, 5000);
    });
    
    // Auto-show OTP modal if needed
    @if(session('show_otp_modal'))
        const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
        otpModal.show();
    @endif
});
</script>