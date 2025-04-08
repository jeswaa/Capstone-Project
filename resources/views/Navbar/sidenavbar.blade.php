

<!-- SIDEBAR -->
<div class="container-fluid">
    <div class="row min-vh-100">
        <!-- Sidebar -->
        <div class="col-md-3 col-12 bg-dark text-white py-5">
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('images/default-profile.jpg') }}" alt="Profile Picture" class="rounded-circle w-50 mb-3">
                <p class="font-heading sidebar-text text-decoration-underline" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer;">Edit Profile</p>
            </div>

            <div class="d-flex flex-column px-4 mt-4">
                <a href="{{ route('dashboard') }}" class="text-white text-decoration-none py-2 d-flex align-items-center">
                    <i class="fas fa-tachometer-alt me-2 fs-5"></i> Dashboard
                </a>
                <a href="{{ route('reservations') }}" class="text-white text-decoration-none py-2 d-flex align-items-center">
                    <i class="fas fa-calendar-alt me-2 fs-5"></i> Reservations
                </a>
                <a href="{{ route('guests') }}" class="text-white text-decoration-none py-2 d-flex align-items-center">
                    <i class="fas fa-users me-2 fs-5"></i> Guests
                </a>
                <a href="{{ route('transactions') }}" class="text-white text-decoration-none py-2 d-flex align-items-center">
                    <i class="fas fa-credit-card me-2 fs-5"></i> Transactions
                </a>

                <div class="dropdown py-2">
                    <a class="text-white text-decoration-none d-flex align-items-center dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-chart-line me-2 fs-5"></i> Reports
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                        <li><a class="dropdown-item" href="{{ route('reports') }}">Summary Report</a></li>
                        <li><a class="dropdown-item" href="#">Activity Logs</a></li>
                    </ul>
                </div>

                <a href="{{ route('logout') }}" class="text-white text-decoration-none py-2 d-flex align-items-center">
                    <i class="fas fa-sign-out-alt me-2 fs-5"></i> Logout
                </a>
            </div>
        </div>

        <!-- Main Content Placeholder -->
        <div class="col-md-9 col-12 d-flex justify-content-center align-items-center">
            <h1 class="text-center">Main Content Area</h1>
        </div>
    </div>
</div>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="profile-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="profile-name" aria-describedby="profile-name-help">
                    </div>
                    <div class="mb-3">
                        <label for="profile-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="profile-email" aria-describedby="profile-email-help">
                    </div>
                    <div class="mb-3">
                        <label for="profile-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="profile-password" aria-describedby="profile-password-help">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editProfileBtn = document.querySelector('.edit-profile');
        if (editProfileBtn) {
            editProfileBtn.addEventListener('click', function () {
                var myModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
                myModal.show();
            });
        }
    });
</script>

