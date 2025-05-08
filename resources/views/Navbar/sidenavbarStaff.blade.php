<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    .nav-link {
        position: relative;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        background: #ffffff;
        left: 0;
        bottom: 0;
        transition: width 0.3s ease-in-out;
    }
    
    .nav-link:hover::after {
        width: 100%;
    }
</style>

<body>
    <!-- SIDEBAR -->
    <div class="position-fixed h-100" id="sidebar" style="width: 260px; background-color: #0b573d !important; transition: all 0.3s ease;">
        <div class="d-flex flex-column h-100">
            <!-- Logo Section -->
            <div class="d-flex flex-column align-items-center mt-5">
                <img src="{{ asset('images/default-profile.jpg') }}" alt="Profile Picture" class="rounded-circle w-50 mb-3 border border-5 border-white">
                <p class="font-heading sidebar-text text-white" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="cursor: pointer;">Edit Profile</p>
            </div>
            
            <div class="d-flex flex-column gap-3 px-2 mt-4">
                <a href="{{ route('staff.dashboard') }}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.dashboard') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                    <i class="fas fa-tachometer-alt fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Dashboard</span>
                </a>
            
                <div class="dropdown w-100">
                    <a href="#" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link" data-bs-toggle="dropdown">
                        <i class="fas fa-calendar-alt fs-5 icon-center"></i>
                        <span class="nav-text ms-3 font-paragraph">Reservations</span>
                        <i class="fas fa-chevron-down nav-text ms-auto"></i>
                    </a>
                    <ul class="dropdown-menu w-100 border-0 shadow" style="background-color: #0d6e4c !important;">
                        <li><a class="nav-link text-white p-2 font-paragraph" href="{{ route('staff.reservation') }}">Reservations</a></li>
                        <li><a class="nav-link text-white p-2 font-paragraph" href="{{ route('staff.accomodations')}}">Room Availability</a></li>
                    </ul>
                </div>
            
                <a href="{{ route ('staff.guests')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 {{ Request::routeIs('staff.guests') ? 'bg-white bg-opacity-10' : '' }} nav-link">
                    <i class="fas fa-users fs-5 icon-center"></i>
                    <span class="nav-text ms-3 font-paragraph">Guests</span>
                </a>
            </div>
        
            <div class="mt-auto mb-4 px-2">
                <a href="{{ route('staff.logout')}}" class="text-white text-decoration-none d-flex align-items-center p-2 rounded-2 nav-link justify-content-end">
                    <span class="nav-text me-3 font-paragraph">Log Out</span>
                    <i class="fas fa-sign-out-alt fs-5 icon-center"></i>
                </a>
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const sidebar = document.getElementById('sidebar');
                    const toggleBtn = document.getElementById('toggleSidebar');
                    const navTexts = document.getElementsByClassName('nav-text');
                    const fullTitle = document.querySelector('.full-title');
                    const shortTitle = document.querySelector('.short-title');
                    const navLinks = document.querySelectorAll('.nav-link');
                    const logoSection = document.getElementById('logoSection');
                    let isExpanded = true;
            
                    toggleBtn.addEventListener('click', function() {
                        if (isExpanded) {
                            sidebar.style.width = '70px';
                            toggleBtn.style.width = '100%';
                            toggleBtn.style.justifyContent = 'center';
                            toggleBtn.style.display = 'flex';
                            fullTitle.style.display = 'none';
                            shortTitle.style.display = 'inline-block';  // Changed to inline-block
                            logoSection.style.justifyContent = 'center';
                            for (let text of navTexts) {
                                text.style.display = 'none';
                            }
                            navLinks.forEach(link => {
                                link.style.justifyContent = 'center';
                            });
                            const logoutLink = document.querySelector('.nav-link.justify-content-end');
                            logoutLink.classList.remove('justify-content-end');
                            logoutLink.classList.add('justify-content-center');
                            document.querySelector('.fa-sign-out-alt').classList.remove('ms-3');
                        } else {
                            sidebar.style.width = '280px';
                            toggleBtn.style.width = 'fit-content';
                            toggleBtn.style.justifyContent = 'flex-start';
                            fullTitle.style.display = 'inline';
                            shortTitle.style.display = 'none';
                            logoSection.style.justifyContent = 'flex-start';
                            navLinks.forEach(link => {
                                link.style.justifyContent = 'flex-start';
                            });
                            const logoutLink = document.querySelector('.nav-link.justify-content-center');
                            logoutLink.classList.remove('justify-content-center');
                            logoutLink.classList.add('justify-content-end');
                            document.querySelector('.fa-sign-out-alt').classList.add('ms-3');
                        }
                        isExpanded = !isExpanded;
                    });
                });
            </script>
        </div>
    </div>
</body>
</html>
