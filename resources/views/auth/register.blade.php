<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-md-8 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="/" class="logo d-flex align-items-center w-auto">
                        <img src="{{ asset('images/parks.png') }}" alt="">
                        <span class="d-none d-lg-block">Wildlife Management System</span>
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3">
                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Create Your Account</h5>
                            <p class="text-center small">Enter your personal details.</p>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                {{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form class="row g-3 needs-validation" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="col-md-6">
                                <label for="yourEmail" class="form-label">Firstname</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="firstname" class="form-control" id="yourEmail" required>
                                    <div class="invalid-feedback">Please enter your firstname.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="yourEmail" class="form-label">Lastname</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="lastname" class="form-control" id="yourEmail" required>
                                    <div class="invalid-feedback">Please enter your lastname.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="yourEmail" class="form-label">National ID</label>
                                <div class="input-group has-validation">
                                    <input type="text" name="natid" class="form-control" id="yourEmail" required>
                                    <div class="invalid-feedback">Please enter your national id.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="yourEmail" class="form-label">Gender</label>
                                <div class="input-group has-validation">
                                    <select name="sex" class="form-control" id="yourEmail" required>
                                        <option selected disabled>Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div class="invalid-feedback">Please enter your Gender.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="yourPassword" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Please enter your phone number!</div>
                            </div>
                            <div class="col-md-6">
                                <label for="yourPassword" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Please enter your email address!</div>
                            </div>
                            <div class="col-md-6">
                                <label for="yourPassword" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Please enter your address!</div>
                            </div>

                            <div class="col-md-6">
                                <label for="yourPassword" class="form-label">Account</label>
                                <select name="role" class="form-control" id="yourPassword" required>
                                    <option value="user">Hunter</option>
                                    <option value="officer">Park Officer</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <div class="invalid-feedback">Please enter your role!</div>
                            </div>

                            <div class="col-md-6">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Please enter your password!</div>
                            </div>
                            <div class="col-md-6">
                                <label for="yourPassword" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Please enter your password confirmation!</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Register</button>
                            </div>
                            <div class="col-12">
                                <p class="small mb-0">Already have account? <a href="{{route('login')}}">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js')}}"></script>

</body>

</html>
