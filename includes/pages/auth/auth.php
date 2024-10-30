<div class="leadoma leadoma-font lm-welcome-auth welcome-step">
  <!-- welcome-step, auth-step, verify-step -->

  <section class="container-fluid auth-header">
    <div class="auth-steps mx-auto d-flex flex-row justify-content-between">
      <div class="fill-bg cursor-pointer welcome-tab active" onclick="changeStepTo('welcome')">
        <span class="d-flex flex-column align-items-center mx-auto">
          <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M21.7499 9.63531C21.74 7.09945 20.4096 4.71464 17.7866 3.86966C15.9855 3.28845 14.0236 3.61167 12.5 5.79914C10.9764 3.61167 9.01447 3.28845 7.21339 3.86966C4.59014 4.71474 3.25971 7.09999 3.25008 9.63618C3.22582 14.6799 8.33662 18.5394 12.4987 20.3842L12.5 20.3836L12.5013 20.3842C16.6636 18.5393 21.7748 14.6794 21.7499 9.63531Z"
              stroke="var(--auth-header-color)" stroke-width="1.5" stroke-linecap="square" />
            <path
              d="M16.2432 11.29C15.473 12.6129 14.1033 13.683 12.5196 13.6556C10.9358 13.683 9.5661 12.6129 8.7959 11.29"
              stroke="var(--auth-header-color)" stroke-width="1.5" stroke-linecap="square" />
          </svg>
          <span>
            Welcome
          </span>
        </span>
      </div>

      <div class="fill-bg cursor-pointer auth-tab" onclick="changeStepTo('auth')">
        <span class="d-flex flex-column align-items-center mx-auto">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.043 8.66895V12.6789" stroke="var(--auth-header-color)" stroke-width="1.5"
              stroke-linecap="square" stroke-linejoin="round" />
            <path d="M21.088 10.6738H16.998" stroke="var(--auth-header-color)" stroke-width="1.5"
              stroke-linecap="square" stroke-linejoin="round" />
            <path
              d="M13.5908 7.16973C13.5908 9.19686 11.9471 10.8395 9.92104 10.8395V12.3395C12.7753 12.3395 15.0908 10.0256 15.0908 7.16973H13.5908ZM9.92104 10.8395C7.89347 10.8395 6.25 9.19672 6.25 7.16973H4.75C4.75 10.0257 7.06562 12.3395 9.92104 12.3395V10.8395ZM6.25 7.16973C6.25 5.14275 7.89347 3.5 9.92104 3.5V2C7.06562 2 4.75 4.31374 4.75 7.16973H6.25ZM9.92104 3.5C11.9471 3.5 13.5908 5.1426 13.5908 7.16973H15.0908C15.0908 4.31389 12.7753 2 9.92104 2V3.5Z"
              fill="var(--auth-header-color)" />
            <path
              d="M9.955 14.8189C13.2114 14.8106 15.9802 16.3057 16.9979 19.5242C14.9465 20.7748 12.5319 21.2564 9.955 21.2501C7.37812 21.2564 4.96348 20.7748 2.91211 19.5242C3.93101 16.3022 6.69514 14.8105 9.955 14.8189Z"
              stroke="var(--auth-header-color)" stroke-width="1.5" stroke-linecap="square" />
          </svg>
          <span>
            Login or Sign Up
          </span>
        </span>
      </div>
    </div>
  </section>

  <section class="container-fluid auth-body position-relative">
    <!-- welcome -->
    <div class="leadoma-welcome show-on-welcome mx-auto text-center">
      <div class="d-flex justify-content-center welcome-image-container">
        <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/auth/welcome.svg" alt="">
      </div>
      <h1 class="font-24 font-sm-32 font-md-40 fw-500">Welcome to Leadoma!</h1>
      <p class="font-16 fw-500">Step into a realm where data transforms into growth. Leadoma CRM is your trusted
        companion for navigating the world of WooCommerce like never before. Just as each word in this passage holds
        meaning, each interaction in your WooCommerce store holds potential. We're here to help you unravel the
        insights, make sense of the patterns, and convert possibilities into prosperity.
        As you embark on this journey with Leadoma CRM, remember that your WooCommerce store is more than a platform –
        it's an evolving narrative. Let Leadoma be your pen, crafting each chapter with strategic insights, personalized
        touches, and a roadmap to triumph.</p>
      <button class="btn btn-primary btn-icon-text" onclick="changeStepTo('auth')">Start Jouerny <i
          class="bi bi-arrow-right-circle"></i></button>
    </div>

    <!-- login - signup - reset password -->
    <section class="show-on-auth">
      <?php include LEADOMA_DIR . 'includes/pages/auth/login-signup.php'?>
    </section>

    <!-- verify email -->
    <section class="">
      <div class="leadoma-welcome show-on-verify mx-auto text-center">
        <div class="d-flex justify-content-center welcome-image-container">
          <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/auth/email-verify.svg" alt="">
        </div>
        <h1 class="font-24 font-sm-32 font-md-40 fw-500">Welcome to Leadoma!</h1>
        <p class="font-24 fw-300" style="color: #000">Check your Email Inbox & confirm your Email Address</p>
        <a class="lm-open-gmail-button" style="color: var(--bs-gray-600)" href="https://mail.google.com/"
          target="_blank"><img src="<?php echo LEADOMA_DIR_URL ?>/admin/images/icons/gmail.svg" alt=""> Open Gmail</a>
      </div>
    </section>


  </section>
</div>
<?php
wp_enqueue_script('leadoma-auth');
wp_enqueue_style('leadoma-auth');
wp_enqueue_style('leadoma-disable-admin-notices');
?>