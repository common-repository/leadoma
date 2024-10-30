<?php $accepted = leadomaGetOption("cloud_notice");?>

<div class="leadoma-login mx-auto">
  <div class="d-flex justify-content-center login-image-container">
    <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/logo.svg" alt="">
  </div>
  <div class="alert alert-primary alert-dismissible fade show" role="alert">
    <i class="bi bi-info-circle-fill md me-2" style="color:var(--bs-primary-700);"></i> Login or Signup <strong>to
      leadoma CRM</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <div id="auth-forms" class="auth-forms login-state">

    <div class="auth-vav">
      <span class="auth-nav-item cursor-pointer login-tab active" onclick="changeStateTo('login')">Login</span>
      <span class="auth-nav-item cursor-pointer signup-tab" onclick="changeStateTo('signup')">Signup</span>
    </div>

    <form action="" class="lm-login-form show-on-login" novalidate>

      <div class="mt-4">
        <label for="login_email_address" class="form-label">Email Address</label>
        <input type="email" class="form-control primary" id="login_email_address" placeholder="example@email.com"
          required>
        <span class="form-helper-text invalid-feedback">Email Address is not valid</span>
      </div>

      <div class="mt-4">
        <label for="login_password" class="form-label">Password</label>
        <div class="password-wrapper">
          <input type="password" class="form-control primary toggle-password" id="login_password" placeholder="Password"
            required>
          <i class="bi bi-eye" onclick="leadoma_password_show_hide(this)"></i>
          <span class="form-helper-text invalid-feedback">Password is not valid</span>
        </div>
      </div>

      <div class="mt-2 d-flex justify-content-between align-items-center">
        <div>
          <input class="lm-checkbox me-1 support-enter" id="wp-comment-cookies-consent"
            name="wp-comment-cookies-consent" type="checkbox" value="yes">
          <label class="user-select-none" for="wp-comment-cookies-consent">Remember Password</label>
        </div>
        <a class="font-10 cursor-pointer" onclick="changeStateTo('reset')">Forgot Your Password?</a>
      </div>

      <button type="submit" class="btn btn-primary d-block w-100 mt-4"
        <?php echo $accepted ? '' : 'disabled' ?>>Login</button>

    </form>

    <form action="" class="lm-signup-form show-on-signup" novalidate>

      <div class="mt-3">
        <label for="signup_fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control primary" id="signup_fullname" placeholder="Full Name" required>
        <span class="form-helper-text invalid-feedback">Full Name is not valid</span>
      </div>

      <div class="mt-3">
        <label for="signup_email_address" class="form-label">Email Address</label>
        <input type="email" class="form-control primary" id="signup_email_address" placeholder="example@email.com"
          required>
        <span class="form-helper-text invalid-feedback">Email Address is not valid</span>
      </div>

      <div class="mt-3">
        <label for="signup_password" class="form-label">Password</label>
        <div class="password-wrapper">
          <input type="password" class="form-control primary toggle-password" id="signup_password"
            placeholder="Password" required>
          <i class="bi bi-eye" onclick="leadoma_password_show_hide(this)"></i>
          <span class="form-helper-text invalid-feedback">Password Email Address</span>
        </div>
      </div>

      <button type="submit" class="btn btn-primary d-block w-100 mt-4"
        <?php echo $accepted ? '' : 'disabled' ?>>Signup</button>

    </form>

    <form action="" class="lm-reset-form show-on-reset">

      <div class="mt-3">
        <label for="login_email_address" class="form-label">Email Address</label>
        <input type="text" class="form-control primary" name="login_email_address" id="login_email_address"
          placeholder="example@email.com">
        <span class="form-helper-text invalid-feedback">Helper text</span>
      </div>


      <button type="submit" class="btn btn-primary d-block w-100 mt-4">Reset Password</button>

    </form>

    <form action="" class="lm-reset2-form show-on-reset-2 d-none">

      <div class="mt-3">
        <label for="login_password" class="form-label">New Password</label>
        <div class="password-wrapper">
          <input type="password" class="form-control primary toggle-password" id="login_password"
            placeholder="Password">
          <i class="bi bi-eye" onclick="leadoma_password_show_hide(this)"></i>
          <span class="form-helper-text invalid-feedback">Helper text</span>
        </div>
      </div>

      <div class="mt-3">
        <label for="login_password" class="form-label">Re-enter Your Password</label>
        <div class="password-wrapper">
          <input type="password" class="form-control primary toggle-password" id="login_password"
            placeholder="Password">
          <i class="bi bi-eye" onclick="leadoma_password_show_hide(this)"></i>
          <span class="form-helper-text invalid-feedback">Helper text</span>
        </div>
      </div>

      <button type="submit" class="btn btn-primary d-block w-100 mt-4">Change Password</button>
      <button type="button" class="btn btn-secondary d-block w-100 mt-4">Login</button>

    </form>

    <div class="font-14 text-center mt-4 mb-2 show-on-login" style="color:var(--bs-gray-400)">Don’t Have an account? <a
        class="a-dark cursor-pointer" onclick="changeStateTo('signup')"><strong>Sign Up</strong></a></div>
    <div class="font-14 text-center mt-4 mb-2 show-on-signup" style="color:var(--bs-gray-400)">Have an account? <a
        class="a-dark cursor-pointer" onclick="changeStateTo('login')"><strong>Login</strong></a></div>

  </div>
</div>

<?php
if (!$accepted) {?>
<div class="leadoma-cloud-notice">
  <p>Please be informed that our plugin securely stores user data on a cloud-based platform to enhance your experience.
    Your privacy and security are of utmost importance to us. For more details, you can review our privacy policy.</p>
  <div class="d-flex justify-content-around gap-3">
    <button type="button" class="btn btn-secondary d-block w-100 mt-3"
      onClick='leadomaRedirectTo("leadoma-login")'>Reject</button>
    <button type="button" class="btn btn-primary d-block w-100 mt-3"
      onClick="leadomaHandleAcceptCloudNotice()">Accept</button>
  </div>
</div>
<?php }?>