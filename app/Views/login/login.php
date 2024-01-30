<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="/assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Login | CBT - POLINELA</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/assets/images/logo.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="/assets/vendor/fonts/materialdesignicons.css" />
  <link rel="stylesheet" href="/assets/vendor/fonts/fontawesome.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="/assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="/assets/vendor/libs/typeahead-js/typeahead.css" />
  <!-- Vendor -->
  <link rel="stylesheet" href="/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="/assets/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="/assets/vendor/js/template-customizer.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="/assets/js/config.js"></script>
</head>

<body>
  <!-- Content -->

  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Login -->
        <div class="card p-2">
          <!-- Logo -->
          <div class="app-brand justify-content-center mt-5 mb-2">
            <a href="/login" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="/assets/images/logo.png" width="100" alt="" srcset="">
              </span>
            </a>
          </div>
          <span class="app-brand-text demo text-center text-heading fw-bold">Computer Based Test</span>
          <span class="app-brand-text demo text-center text-heading fw-bold">Politeknik Negeri Lampung</span>

          <!-- /Logo -->

          <div class="card-body mt-2">

            <form class="mb-3" action="<?= base_url('login/authenticate') ?>" method="POST">
              <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" name="username" placeholder="Enter your username" autofocus required/>
                <label for="email">Email or Username</label>
              </div>
              <div class="mb-3">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required/>
                      <label for="password">Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>

          </div>
        </div>
      </div>
      <!-- /Login -->
      <img alt="mask" src="/assets/img/illustrations/auth-basic-login-mask-light.png" class="authentication-image d-none d-lg-block" data-app-light-img="illustrations/auth-basic-login-mask-light.png" data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
    </div>
  </div>
  </div>

  <!-- / Content -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="/assets/vendor/libs/popper/popper.js"></script>
  <script src="/assets/vendor/js/bootstrap.js"></script>
  <script src="/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="/assets/vendor/libs/node-waves/node-waves.js"></script>

  <script src="/assets/vendor/libs/hammer/hammer.js"></script>
  <script src="/assets/vendor/libs/i18n/i18n.js"></script>
  <script src="/assets/vendor/libs/typeahead-js/typeahead.js"></script>

  <script src="/assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
  <script src="/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
  <script src="/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

  <!-- Main JS -->
  <script src="/assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="/assets/js/pages-auth.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php if (session()->getFlashdata('success')) : ?>
    <script>
      Swal.fire({
        title: "Informasi",
        text: "<?= session()->getFlashdata('success') ?>",
        icon: "success",
        showCancelButton: false,
        confirmButtonText: "OK",
      });
    </script>
  <?php elseif (session()->getFlashdata('error')) : ?>
    <script>
      Swal.fire({
        title: "Error",
        text: "<?= session()->getFlashdata('error') ?>",
        icon: "error",
        showCancelButton: false,
        confirmButtonText: "OK",
      });
    </script>
  <?php endif; ?>

</body>

</html>