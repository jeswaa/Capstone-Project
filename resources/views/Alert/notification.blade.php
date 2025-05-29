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
        let currentNotificationIndex = 0;
        let allNotifications = [];

        function loadNotifications() {
            $.ajax({
                url: '/staff/notifications',
                method: 'GET',
                success: function(response) {
                    allNotifications = response.filter(n => n.is_read == 0);
                    showNextNotification();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading notifications:', error);
                }
            });
        }

        function showNextNotification() {
            // I-clear muna ang container
            $('.toast-container').empty();
            
            if (currentNotificationIndex < allNotifications.length) {
                const notification = allNotifications[currentNotificationIndex];
                
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
                
                setTimeout(() => {
                    $toast.addClass('show');
                }, 100);

                // After 5 seconds, mark as read and show next
                setTimeout(() => {
                    markAsReadHandler(notification.id).then(() => {
                        currentNotificationIndex++;
                        showNextNotification();
                    });
                }, 5000);
            } else {
                // Reset index kung wala nang notifications
                currentNotificationIndex = 0;
            }
        }

        function markAsReadHandler(id) {
            return new Promise((resolve, reject) => {
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
                            resolve();
                        }, 300);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error marking notification as read:', error);
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                        reject(error);
                    }
                });
            });
        }

        loadNotifications();
        setInterval(loadNotifications, 30000);
    });
    </script>
</body>
</html>