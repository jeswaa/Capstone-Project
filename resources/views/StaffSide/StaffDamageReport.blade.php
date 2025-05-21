<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Anton&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <title>Damage Report</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="margin: 0; padding: 0; height: 100vh; background: linear-gradient(rgba(255, 255, 255, 0.76), rgba(255, 255, 255, 0.76)), url('{{ asset('images/DSCF2777.JPG') }}') no-repeat center center fixed; background-size: cover;">
    @include('Alert.loginSucess')
    @include('Alert.notification')
    <div class="container-fluid min-vh-100 d-flex p-0">
        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 color-background8 text-white position-sticky" id="sidebar" style="top: 0; height: 100vh; background-color: #0b573d background-color: #0b573d ">
            <div class="d-flex flex-column h-100">
            @include('Navbar.sidenavbarStaff')
            </div>
        </div>

        <!-- Main Content -->
         <div class="col-md-10 col-lg-10 py-4 px-4">
            <!-- Heading and Logo -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="ms-auto">
                    <img src="{{ asset('images/appicon.png') }}" alt="Lelo's Resort Logo" width="100" class="rounded-pill">
                </div>
            </div>
            
            <hr class="border-5">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-semibold text-capitalize mt-4" style="font-size: 50px; letter-spacing: 1px; color: #0b573d; margin-top: -30px; font-family: 'Anton', sans-serif; letter-spacing: .1em;">Damage Report</h1>
            </div>
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addDamageReportModal" style="background-color: #0b573d; border: none; padding: 8px 16px; border-radius: 8px; transition: all 0.3s ease;">
                    <i class="fas fa-plus"></i>
                    <span>Add Report</span>
                </button>
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
                                    <span class="badge {{ $report->status == 'pending' ? 'bg-warning' : ($report->status == 'in progress' ? 'bg-info' : 'bg-success') }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-primary rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#editReportModal{{ $report->id }}" style="background-color: #0b573d; border: none; transition: background 0.2s;">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger rounded-3 shadow-sm" onclick="deleteReport({{ $report->id }})" style="background-color: #d9534f; border: none; transition: background 0.2s;">
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
            
            <!-- Add Damage Report Modal -->
            <div class="modal fade" id="addDamageReportModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4" style="border: 2px solid #0b573d;">
                        <div class="modal-header color-background5 text-white rounded-top-4" style="background-color: #0b573d;">
                            <h5 class="modal-title fw-bold" style="font-family: 'Poppins', sans-serif;">Add Damage Report</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" style="background: #f8f9fa;">
                            <form action="{{ route('staff.storeDamageReport') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Room/Area</label>
                                    <input type="text" class="form-control rounded-3 border-2" name="notes" required style="border-color: #0b573d;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Damage Description</label>
                                    <textarea class="form-control rounded-3 border-2" name="damage_description" rows="3" required style="border-color: #0b573d;"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Status</label>
                                    <select class="form-select rounded-3 border-2" name="status" style="border-color: #0b573d;">
                                        <option value="Pending">Pending</option>
                                        <option value="In Progress">In Progress</option>
                                        <option value="Resolved">Resolved</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" style="color: #0b573d; font-family: 'Poppins', sans-serif;">Upload Image</label>
                                    <input type="file" class="form-control rounded-3 border-2" name="damage_photos" accept="image/*" style="border-color: #0b573d;">
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success rounded-3 fw-semibold" style="background-color: #0b573d; border: none; padding: 10px; font-family: 'Poppins', sans-serif; letter-spacing: 1px; transition: all 0.3s;">
                                        Submit Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
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
                        <form action="{{ route('staff.editDamageReport', $report->id) }}" method="POST">
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
    </div>
    </div>
    
    
</body>
</html>
