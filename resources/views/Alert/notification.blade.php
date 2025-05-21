<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .toast-container {
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10002; /* Mas mataas na z-index */
    }
    
    .custom-toast {
        background-color: #0b573d;
        color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
        max-width: 350px;
        position: relative;
        z-index: 10001; /* Mas mataas na z-index */
        overflow: hidden;
    }
    .custom-toast.show {
        opacity: 1;
        transform: translateX(0);
    }
    .mark-as-read-btn {
        background-color: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .mark-as-read-btn:hover {
        transform: scale(1.1);
        color: #0d6e4c !important;
    }
    .timer {
        height: 4px;
        background-color: #fff;
        width: 100%;
        animation: timer 5s linear forwards;
    }

    @keyframes timer {
        from { width: 100%; }
        to { width: 0%; }
    }
</style>
<body>
    <div class="toast-container"></div>
    <script>
    $(document).ready(function() {
        function loadNotifications() {
            // I-clear ang existing notifications
            $('.toast-container').empty();
            
            $.ajax({
                url: '/staff/notifications',
                method: 'GET',
                success: function(response) {
                    showToastNotifications(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading notifications:', error);
                }
            });
        }

        function showToastNotifications(notifications) {
            if (notifications && notifications.length > 0) {
                notifications.forEach(notification => {
                    // I-check kung ang notification ay hindi pa nababasa at wala pang existing toast
                    if (notification.is_read == 0 && !$(`.custom-toast[data-notification-id="${notification.id}"]`).length) {
                        const toastHtml = `
                            <div class="custom-toast" data-notification-id="${notification.id}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1">${notification.message}</p>
                                        <small class="text-white-50">${moment(notification.created_at).fromNow()}</small>
                                    </div>
                                </div>
                                <div class="timer"></div>
                            </div>
                        `;
                        const $toast = $(toastHtml);
                        $('.toast-container').append($toast);
                        console.log("Notifications loaded:", notifications);

                        // Show animation
                        setTimeout(() => {
                            $toast.addClass('show');
                        }, 100);

                        // Add 5-second timer
                        setTimeout(() => {
                            markAsReadHandler(notification.id);
                        }, 5000);
                    }
                });
            }
        }

        function markAsReadHandler(id) {
            const $toast = $(`.custom-toast[data-notification-id="${id}"]`);
            
            $.ajax({
                url: `/staff/notifications/${id}/mark-as-read`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    is_read: true
                },
                success: function(response) {
                    console.log('Mark as read successful:', response);
                    $toast.removeClass('show');
                    setTimeout(() => {
                        $toast.remove();
                    }, 300);
                },
                error: function(xhr, status, error) {
                    console.error('Error marking notification as read:', error);
                    console.log('Response:', xhr.responseText);
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            });
        }

        loadNotifications();
        setInterval(loadNotifications, 30000);
    });
</script>
</body>
</html>