
<!-- todo: make cards columns responsive -->
<div class="leadoma leadoma-font leadoma-overlay-off lm-bg-light text-color lm-loading" style="--lm-text-color:var(--bs-gray-500)"> <!-- toggle leadoma-overlay-off to show or hide overlay  -->
<div class="lm-overlay cursor-pointer" lm-overlay style="background-color: #0005; position:absolute; left:00%; top:0%; z-index:1; width:100%; height: 100%"></div>
<div class="lm-page-loader d-flex justify-content-center align-items-center" style="background-color: #fff5; position:absolute; left:0%; top:0%; z-index:1; width:100%; height: 100vh">
  <div class="spinner-border text-primary text-center" role="status"></div>
</div>

<section class="container-fluid">
  <div class="row">
    <div class="col-12 page-title">
      <span lm-customer-name></span> / Last Activities
    </div>
  </div>
  <div class="row mt-5 px-4">
    <div class="col-12">
      <div class="card lm-card font-14 lm-profile-card pt-3 pb-5 px-2 px-md-3">
        <div class="ms-3 ms-md-5 d-flex align-items-center justify-content-between mb-3">
          <div class="d-flex align-items-center">
            <div class="lm-profile-image lm-profile-image--small" style='background-image: url(""), linear-gradient(to bottom,var(--bs-gray-200),var(--bs-gray-200))'>
              <span lm-bi-level>0</span>
            </div>
            <div class="ps-2 ms-2 ps-md-3 ms-md-3 font-16 fw-500">
              <img style="vertical-align:bottom" src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/activities.svg"> Last Activities
            </div>
          </div>
          
          <button onClick="leadomaRedirectTo('leadoma-customer-profile', {id:leadomaGetParam('id')})" class="btn btn-primary btn-icon-text m-2 px-3">Back to profile 
            <svg style="height:16px; margin-left:8px" width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19.2876 10.2497H6.50978M16.7476 6.9751L20.0371 10.2501L16.7476 13.5261M11.5239 14.875V19.5H1L1 1L11.5239 1V5.625" stroke="white" stroke-width="1.5" stroke-linecap="square"/>
            </svg>
          </button>

        </div>
        <div class="ms-3 ms-md-5" lm-all-activities-container >
        </div>

      </div>
    </div>
  </div>
</section>
</div>
<?php 
wp_enqueue_script('leadoma-customer-activities');
wp_enqueue_style('leadoma-customer-profile');
wp_enqueue_style('leadoma-disable-admin-notices');

?>