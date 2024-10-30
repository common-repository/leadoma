<!-- todo: make cards columns responsive -->
<div class="leadoma leadoma-font leadoma-overlay-off lm-bg-light text-color lm-loading"
  style="--lm-text-color:var(--bs-gray-500)">
  <!-- toggle leadoma-overlay-off to show or hide overlay  -->
  <div class="lm-overlay cursor-pointer" lm-overlay
    style="background-color: #0005; position:absolute; left:00%; top:0%; z-index:2; width:100%; height: 100%"></div>
  <div class="lm-page-loader d-flex justify-content-center align-items-center"
    style="background-color: #fff5; position:absolute; left:0%; top:0%; z-index:1; width:100%; height: 100vh">
    <div class="spinner-border text-primary text-center" role="status"></div>
  </div>

  <section class="container-fluid">
    <div class="row">
      <div class="col-12 page-title">
        Customer's Profile
      </div>
    </div>
    <div class="row mt-5 px-4">
      <div class="col-12 col-sm-12 col-xl-3">
        <!-- Profile -->
        <div class="card lm-card font-10 lm-profile-card pt-4">
          <div class="lm-profile-card-info">
            <?php 
          $customers = get_users(array(
            'meta_key' => 'leadoma_id_'.getCurrentUserEmail(),
            'meta_value' => $_GET["id"]
          ));
          ?>
            <div class="lm-profile-image"
              style='background-image: url(""), linear-gradient(to bottom,var(--bs-gray-200),var(--bs-gray-200))'>
              <?php
            if(!empty($customers)){
              echo get_avatar($customers[0]->user_email);
            }
            ?>
              <span lm-bi-level>0</span>
            </div>

            <div class="font-16 fw-bold mt-3" lm-bi-fullname></div>

            <a class="lm-profile-email" lm-bi-email-href href="mailto:">
              <span>
                <img class="pe-1" src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/envelope.svg" alt="">
                <span lm-bi-email></span>
              </span>
              <span class="ms-1">
                <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/redo.svg" alt="">
              </span>
            </a>

            <div class="location-number d-flex justify-content-between align-items-center text-color mt-2"
              style="--lm-text-color:var(--bs-gray-300)">
              <span>
                <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/location.svg" alt="">
                <span lm-bi-city></span>, <span lm-bi-country></span>
              </span>
              <a class="ms-4 lm-phone-link" lm-bi-phoneenumber-href href="">
                <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/call-outgoing.svg" alt="">
                <span lm-bi-phonenumber></span>
              </a>
            </div>

            <!-- <a class="lm-more-button lm-delete-profile cursor-pointer mb-2" lm-delete-customer>
            <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/trash.svg" alt="">
            Delete Customer
          </a> -->
          </div>

          <hr>

          <!-- <div>
          <div class="lm-note-row lm-note-row-bigger">
            <div class="lm-line-ellipsis" title="Cash Back">
              <span class="text-color-lightgray">
                Cash Back
              </span>
            </div>
            <span class="ms-2 font-14 fw-bold">
              -
            </span>
          </div>
          <div class="lm-note-row lm-note-row-bigger">
            <div class="lm-line-ellipsis" title="Avg Level of previous 3 months">
              <span class="text-color-lightgray">
                Avg Level of previous 3 months
              </span>
            </div>
            <span class="ms-2 font-14 fw-bold">
              -
            </span>
          </div>
          <div class="lm-note-row lm-note-row-bigger">
            <div class="lm-line-ellipsis">
              <span class="text-color-lightgray" title="How often does the customer purchase? (Avg)">
              How often does the customer purchase? (Avg)
              </span>
            </div>
            <span class="ms-2 font-14 fw-bold">
              -
            </span>
          </div>
          <div class="lm-note-row lm-note-row-bigger">
            <div class="lm-line-ellipsis">
              <span class="text-color-lightgray" title="Number of orders of the customer">
                Number of orders of the customer
              </span>
            </div>
            <span class="ms-2 font-14 fw-bold">
              -
            </span>
          </div>
          <div class="lm-note-row lm-note-row-bigger">
            <div class="lm-line-ellipsis">
              <span class="text-color-lightgray" title="Avg of all Levels of previous months">
                Avg of all Levels of previous months
              </span>
            </div>
            <span class="ms-2 font-14 fw-bold">
              -
            </span>
          </div>
          <div class="lm-note-row lm-note-row-bigger">
            <div class="lm-line-ellipsis">
              <span class="text-color-lightgray" title="Total Monetary Value">
                Total Monetary Value
              </span>
            </div>
            <span class="ms-2 font-14 fw-bold">
              -
            </span>
          </div>

        </div> -->

        </div>

        <?php include(LEADOMA_DIR.'includes/pages/customers/components/tags.php') ?>

      </div>

      <div class="col-12 col-sm-6 col-xl-4-5">

        <!-- Basic info -->
        <?php include(LEADOMA_DIR.'includes/pages/customers/components/basic-info.php') ?>

        <!-- Last tags -->

        <!-- Last Orders/Projects -->
        <!-- <div class="card lm-card">
        <div class="d-flex justify-content-between">
          <span class="lm-card-title">
            <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/note.svg" alt="">
            Last Orders/Projects
          </span>
        </div>

        <div class="mt-3 font-10">
          
          <div class="lm-note-row">
            <div class="lm-line-ellipsis">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/shop.svg" alt="">
              <span class="ms-2">
                Order Rejected By Owner
              </span>
              <span class="text-color-lightgray ms-3">
                Customer has submitted the form Contact us form
              </span>
            </div>
            <span class="p-1 px-2 rounded-pill" style="background-color:var(--bs-gray-100)">2021-06-08</span>
          </div>
          <div class="lm-note-row">
            <div class="lm-line-ellipsis">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/shop.svg" alt="">
              <span class="ms-2">
                Order Rejected By Owner
              </span>
              <span class="text-color-lightgray ms-3">
                Customer has submitted the form Contact us form
              </span>
            </div>
            <span class="p-1 px-2 rounded-pill" style="background-color:var(--bs-gray-100)">2021-06-08</span>
          </div>
          <div class="lm-note-row">
            <div class="lm-line-ellipsis">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/shop.svg" alt="">
              <span class="ms-2">
                Order Rejected By Owner
              </span>
              <span class="text-color-lightgray ms-3">
                Customer has submitted the form Contact us form
              </span>
            </div>
            <span class="p-1 px-2 rounded-pill" style="background-color:var(--bs-gray-100)">2021-06-08</span>
          </div>
          <div class="lm-note-row">
            <div class="lm-line-ellipsis">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/shop.svg" alt="">
              <span class="ms-2">
                Order Rejected By Owner
              </span>
              <span class="text-color-lightgray ms-3">
                Customer has submitted the form Contact us form
              </span>
            </div>
            <span class="p-1 px-2 rounded-pill" style="background-color:var(--bs-gray-100)">2021-06-08</span>
          </div>
          <div class="lm-note-row">
            <div class="lm-line-ellipsis">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/shop.svg" alt="">
              <span class="ms-2">
                Order Rejected By Owner
              </span>
              <span class="text-color-lightgray ms-3">
                Customer has submitted the form Contact us form
                Customer has submitted the form Contact us form
                Customer has submitted the form Contact us form
              </span>
            </div>
            <span class="p-1 px-2 rounded-pill" style="background-color:var(--bs-gray-100)">2021-06-08</span>
          </div>

        </div>
        
        <a href="#" class="font-10 mt-1 lm-more-button a-dark">
          <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/plus.svg" alt="+">
          More Notes
        </a>

      </div> -->

        <!-- Notes -->
        <?php include(LEADOMA_DIR.'includes/pages/customers/components/notes.php') ?>

      </div>

      <div class="col-12 col-sm-6 col-xl-4-5">

        <!-- Additional info -->
        <?php include(LEADOMA_DIR.'includes/pages/customers/components/additional-info.php') ?>


        <!-- Last Activities -->
        <div class="card lm-card lm-loading-small" lm-activities-card>
          <div class="d-flex justify-content-between">
            <span class="lm-card-title">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/note.svg" alt="">
              Last Activities
            </span>
          </div>

          <div class="mt-3 font-10" lm-activities-container>

          </div>

          <div class="lm-small-loader d-flex justify-content-center align-items-center"
            style="background-color: #fff5; z-index:1; width:100%; min-height: 200px">
            <div class="spinner-border text-primary text-center" role="status"></div>
          </div>

          <!-- <span onClick="handleCustomerActivitiesRedirect()" class="font-10 mt-1 lm-more-button a-dark cursor-pointer">
          All Activities
        </span> -->

        </div>



      </div>
    </div>
    <div class="tags-edit-container delete-customer" style="display:none; top:20vh">
      <div class="bg-primary">
        <div>
          <div class="card lm-card">
            <div class="d-flex justify-content-between">
              <span class="lm-card-title font-14">Are you sure you want to delete this customer ?</span>
              <span class="lm-badge-square lm-badge-svg cursor-pointer p-0" lm-close-overlay lm-close-delete-customer
                style="--lm-badge-bg:transparent">
                <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/close.svg" alt="">
              </span>
            </div>

            <div class="delete-customer-info">
              <!-- handle with js -->
            </div>

            <div class="mt-4">
              <button class="btn btn-primary btn-danger w-100" lm-submit-delete-customer>Delete</button>
            </div>
          </div>
          </d>
        </div>
      </div>
  </section>
</div>
<?php 
wp_enqueue_script('leadoma-customer-profile');
wp_enqueue_style('leadoma-customer-profile');
wp_enqueue_style('leadoma-disable-admin-notices');

?>