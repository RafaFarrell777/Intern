<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="InternConnect - Connecting students with internship opportunities">
    <meta name="author" content="InternConnect">

    <title>InternConnect | @yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor')}}/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css')}}/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(99, 102, 241, 0.8), rgba(233, 30, 99, 0.8)), url('/api/placeholder/1200/400');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 40px;
        }
        
        .services-section, .about-section, .team-section, .contact-section {
            padding: 60px 0;
        }
        
        .service-card, .team-card {
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .service-card:hover, .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .team-img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 15px;
        }
        
        .section-heading {
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .section-heading:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background-color: #6366f1;
        }
        
        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
        }
        
        .btn-primary:hover {
            background-color: #e91e63;
            border-color: #e91e63;
        }
        
        .auth-buttons .btn {
            margin-left: 10px;
        }
        
        /* Modal styles */
        .modal-header {
            background-color: #6366f1;
            color: white;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white static-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">InternConnect</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auth.register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container text-center">
            <h1 class="display-4 font-weight-bold mb-4">Connect With The Best Internship Opportunities</h1>
            <p class="lead mb-5">InternConnect helps students find the perfect match for internship positions</p>
            @guest
                <a href="{{ route('auth.register') }}" class="btn btn-light btn-lg mr-3">Register</a>
                <a href="{{ route('auth.login') }}" class="btn btn-primary btn-lg">Login</a>
            @else
                @if(auth()->user()->role === 'magang')
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#applyModal">
                        Apply Internship Programs
                    </button>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
                @endif
            @endguest
        </div>
    </section>

    <!-- Application Modal -->
    <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Apply for Internship Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('internship-programs.apply') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="program_id" class="form-label">Select Program</label>
                            <select class="form-select" id="program_id" name="program_id" required>
                                <option value="">Choose a program...</option>
                                @foreach($programs as $program)
                                    @if($program->status === 'active' && !$program->hasApplied(auth()->id()))
                                        <option value="{{ $program->id }}">{{ $program->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="resume" class="form-label">Upload Resume (PDF only, max 2MB)</label>
                            <input type="file" class="form-control" id="resume" name="resume" accept=".pdf" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading">About InternConnect</h2>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <img src="/api/placeholder/600/400" alt="About InternConnect" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <h3 class="mb-4">Our Mission</h3>
                    <p>Founded in 2020, InternConnect aims to bridge the gap between educational institutions and industry by providing students with quality internship opportunities that enhance their skills and prepare them for future careers.</p>
                    <p>We partner with leading companies across multiple sectors to ensure diverse and valuable experiences for students while helping businesses identify and nurture fresh talent.</p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                <h4>5,000+</h4>
                                <p>Students Placed</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mb-4">
                                <i class="fas fa-building fa-3x text-primary mb-3"></i>
                                <h4>750+</h4>
                                <p>Partner Companies</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section bg-light" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading">Our Services</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-search fa-3x text-primary mb-3"></i>
                            <h4 class="card-title">Internship Matching</h4>
                            <p class="card-text">Our advanced algorithm matches students with internships based on skills, interests, and company needs for optimal placement.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                            <h4 class="card-title">Resume Building</h4>
                            <p class="card-text">Professional guidance on creating impactful resumes that highlight your strengths and catch employers' attention.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-laptop-code fa-3x text-primary mb-3"></i>
                            <h4 class="card-title">Skill Assessment</h4>
                            <p class="card-text">Comprehensive assessment tools to identify your strengths and areas for improvement before applying.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-comments fa-3x text-primary mb-3"></i>
                            <h4 class="card-title">Interview Preparation</h4>
                            <p class="card-text">Mock interviews and feedback sessions to help you perform confidently during company interviews.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                            <h4 class="card-title">Progress Tracking</h4>
                            <p class="card-text">Monitor your internship application progress and performance with detailed analytics and feedback.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <i class="fas fa-certificate fa-3x text-primary mb-3"></i>
                            <h4 class="card-title">Certification</h4>
                            <p class="card-text">Earn verified certificates upon successful completion of internships to boost your professional profile.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section" id="team">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading">Our Leadership Team</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card team-card text-center">
                        <div class="card-body">
                            <img src="/api/placeholder/150/150" alt="Team Member" class="team-img">
                            <h4>Sarah Johnson</h4>
                            <p class="text-muted">CEO & Founder</p>
                            <div class="social-icons">
                                <a href="#" class="text-primary mx-1"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="far fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card team-card text-center">
                        <div class="card-body">
                            <img src="/api/placeholder/150/150" alt="Team Member" class="team-img">
                            <h4>Michael Chen</h4>
                            <p class="text-muted">CTO</p>
                            <div class="social-icons">
                                <a href="#" class="text-primary mx-1"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="far fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card team-card text-center">
                        <div class="card-body">
                            <img src="/api/placeholder/150/150" alt="Team Member" class="team-img">
                            <h4>Amelia Rodriguez</h4>
                            <p class="text-muted">Director of Operations</p>
                            <div class="social-icons">
                                <a href="#" class="text-primary mx-1"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="far fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card team-card text-center">
                        <div class="card-body">
                            <img src="/api/placeholder/150/150" alt="Team Member" class="team-img">
                            <h4>David Patel</h4>
                            <p class="text-muted">Head of Partnerships</p>
                            <div class="social-icons">
                                <a href="#" class="text-primary mx-1"><i class="fab fa-linkedin"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-primary mx-1"><i class="far fa-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section bg-light" id="contact">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading">Contact Us</h2>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <h4 class="mb-4">Get In Touch</h4>
                    <p class="mb-4">Have questions or suggestions? We'd love to hear from you! Fill out the form or use our contact information to reach us.</p>
                    <div class="contact-info mb-4">
                        <div class="d-flex mb-3">
                            <i class="fas fa-map-marker-alt mr-3 text-primary mt-1"></i>
                            <div>
                                <h5 class="mb-1">Address</h5>
                                <p>123 Tech Park, Business District<br>Jakarta, Indonesia 12345</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="fas fa-phone mr-3 text-primary mt-1"></i>
                            <div>
                                <h5 class="mb-1">Phone</h5>
                                <p>+62 123 456 7890</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <i class="fas fa-envelope mr-3 text-primary mt-1"></i>
                            <div>
                                <h5 class="mb-1">Email</h5>
                                <p>info@internconnect.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="#" class="btn btn-outline-primary mr-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-primary mr-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="btn btn-outline-primary mr-2"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="btn btn-outline-primary"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" id="subject" placeholder="Enter subject">
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="Enter your message"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="sticky-footer bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h4>InternConnect</h4>
                    <p>Bridging the gap between education and industry through quality internship opportunities.</p>
                    <p class="mb-0">© InternConnect 2025. All Rights Reserved.</p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-white">Home</a></li>
                        <li><a href="#about" class="text-white">About</a></li>
                        <li><a href="#services" class="text-white">Services</a></li>
                        <li><a href="#team" class="text-white">Team</a></li>
                        <li><a href="#contact" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
                    <h5>Services</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Internship Matching</a></li>
                        <li><a href="#" class="text-white">Resume Building</a></li>
                        <li><a href="#" class="text-white">Skill Assessment</a></li>
                        <li><a href="#" class="text-white">Interview Preparation</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to get updates on new opportunities.</p>
                    <form>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email Address">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor')}}/jquery/jquery.min.js"></script>
    <script src="{{asset('vendor')}}/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor')}}/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js')}}/sb-admin-2.min.js"></script>
    
    <!-- Smooth scrolling script -->
    <script>
        // Smooth scrolling for nav links
        $(document).ready(function() {
            $('a[href*="#"]').not('[href="#"]').not('[href="#0"]').not('[data-toggle="modal"]').click(function(event) {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && 
                    location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top - 72
                        }, 1000);
                    }
                }
            });
            
            // Close navbar when clicking on nav item on mobile
            $('.navbar-nav>li>a').on('click', function(){
                $('.navbar-collapse').collapse('hide');
            });
        });
    </script>

    <!-- Bootstrap scripts for alerts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Enable Bootstrap alerts
        $(document).ready(function() {
            $('.alert').alert();
        });
    </script>
</body>

</html>