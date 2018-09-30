<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Star Admin Free Bootstrap Admin Dashboard Template</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.addons.css') }}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form role="form" id="frm_login" method="POST">
                <div class="form-group">
                  <label class="label">Username</label>
                  <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Username" id="username" required>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" placeholder="*********" id="password" required>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary submit-btn btn-block" id="btnLogin">Login</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked> Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                </div>
                <div class="text-block text-center my-3">
                  <span class="text-small font-weight-semibold">Not a member ?</span>
                  <a href="{{ route('daftar') }}" class="text-black text-small">Create new account</a>
                </div>
              </form>
            </div>
            <ul class="auth-footer">
              <li>
                <a href="#">Conditions</a>
              </li>
              <li>
                <a href="#">Help</a>
              </li>
              <li>
                <a href="#">Terms</a>
              </li>
            </ul>
            <p class="footer-text text-center">copyright © 2018 Bootstrapdash. All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/misc.js') }}"></script>
  <!-- endinject -->
   <!-- jQuery 3 -->
   <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
</body>

</html>
<script type="text/javascript">

  $(document).ready(function() {
    $('#frm_login').on('submit', function (e) {
      //alert($("input[name='_token']").val());

      var username = $("#username").val();
      var password = $("#password").val();

      if(password.length < 6){
        alert("Password Harus 6 karakter");
      }else{
        e.preventDefault();
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $("input[name='_token']").val()
          }
        });
        $.ajax({
          type: "POST",
          url: "{{ route ('postLogin') }}",
          data: {
            'username':username,
            'password':password
          },
          success: function(response) {
            console.log(response);
            if (response.status == 200){
                window.location.href = '{{url("/toko")}}';
            }else{
              alert(response.message);
            }
          }
        });
        return true;
      }
    });
  });
</script>