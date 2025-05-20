<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <title>Damage Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
@include('Alert.loginSucess')
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="container-fluid min-vh-100 d-flex p-0">
    @include('Navbar.sidenavbar')
     <!-- Main Content -->
     <div class="col-md-9 col-lg-10 py-4 px-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <form class="d-flex w-50 ms-5" role="search">
                <div class="input-group">
                </div>
            </form>
            <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill me-3">
        </div>

        <hr class="border-5">

        <div class="d-flex justify-content-between align-items-center">
            <h1 class="fw-semibold text-capitalize mt-4" style="font-size: 50px; letter-spacing: 1px; color: #0b573d; margin-top: -30px; font-family: 'Anton', sans-serif; letter-spacing: .1em;">Damage Report</h1>
        </div>

        <!-- Damage Reports Table -->
        <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="color-background5 text-white">
                        <tr>
                            <th>Image</th>
                            <th>Room/Area</th>
                            <th>Damage Description</th>
                            <th>Date Reported</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($damageReports as $report)
                        <tr>
                            <td>
                                @if($report->damage_photos)
                                    <img src="{{ asset('storage/' . $report->damage_photos) }}" alt="Damage Photo" style="width: 100px; height: 100px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $report->notes }}</td>
                            <td>{{ $report->damage_description }}</td>
                            <td>{{ $report->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                <span class="badge text-capitalize {{ $report->status == 'pending' ? 'bg-warning' : ($report->status == 'in progress' ? 'bg-info' : 'bg-success') }}">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm color-background5 text-white rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#editReportModal{{ $report->id }}" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background-color: #0b573d;">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger rounded-3 shadow-sm" onclick="deleteReport({{ $report->id }})" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        @foreach($damageReports as $report)
        <!-- Edit Damage Report Modal -->
        <div class="modal fade" id="editReportModal{{ $report->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4" style="border: 2px solid #0b573d;">
                    <div class="modal-header color-background5 text-white rounded-top-4" style="background-color: #0b573d;">
                        <h5 class="modal-title fw-bold" style="font-family: 'Poppins', sans-serif;">Edit Damage Report</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #f8f9fa;">
                        <form action="{{ route('editDamageReport', $report->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Room/Area</label>
                                <input type="text" class="form-control" name="notes" value="{{ $report->notes }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Damage Description</label>
                                <textarea class="form-control" name="damage_description" required>{{ $report->damage_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select rounded-3 border-2" name="status" style="border-color: #0b573d;">
                                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in-progress" {{ $report->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Update Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4" style="border: 2px solid #dc3545;">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold" style="font-family: 'Poppins', sans-serif;">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                <p class="mb-1 fw-semibold">Are you sure you want to delete this damage report?</p>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
let reportIdToDelete = null;

function deleteReport(id) {
    reportIdToDelete = id;
    const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    modal.show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (reportIdToDelete) {
        fetch(`/damage-report/delete/${reportIdToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Hindi matagumpay ang pagtanggal ng report');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('May naganap na error sa pagtanggal ng report');
        });
    }
    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteConfirmationModal'));
    modal.hide();
});
</script>
</body>
</html>