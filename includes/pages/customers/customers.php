
<div class="leadoma leadoma-overlay-off leadoma-font lm-bg-light"> <!-- toggle leadoma-overlay-off to show or hide overlay  -->
<div class="lm-overlay cursor-pointer" lm-overlay style="background-color: #0005; position:absolute; left:00%; top:0%; z-index:1; width:100%; height: 100%"></div>

<section class="container-fluid">
  <div class="row">
    <div class="col-12 page-title">
      Customers
    </div>
  </div>
  <div class="row mt-5 px-4">
    <div class="col-12">
      <div class="lm-table-top bg-white">
        <div class="lm-title-search-wrapper">
          <span  class="font-16 fw-bold" style="margin-right:96px">List of customers</span>
          <div class="d-flex">
            <input type="text" class="form-control primary d-inline-block me-3 customers-search-input" id="" placeholder="Search Customer, Emails,...">
            <button class="btn btn-outline-secondary btn-icon-text" style="padding:16px">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.16309 4.83594H12.5911" stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M6.17392 4.79595C6.17392 3.83457 5.38876 3.05502 4.42045 3.05502C3.45215 3.05502 2.66699 3.83457 2.66699 4.79595C2.66699 5.75733 3.45215 6.53688 4.42045 6.53688C5.38876 6.53688 6.17392 5.75733 6.17392 4.79595Z" stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square"/>
              <path d="M9.83691 11.2445H3.40889" stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9.82608 11.2042C9.82608 10.2428 10.6112 9.46323 11.5795 9.46323C12.5478 9.46323 13.333 10.2428 13.333 11.2042C13.333 12.1655 12.5478 12.9451 11.5795 12.9451C10.6112 12.9451 9.82608 12.1655 9.82608 11.2042Z" stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square"/>
              </svg>
            </button>
          </div>
        </div>
        <!-- <button class="btn btn-primary btn-icon-text px-3">Export <i class="bi bi-file-earmark-arrow-down"></i></button> -->
      </div>

      <div class="table-responsive customers-table">
        <table class="table table-hover leadoma-table table-bordered bg-white no-wrap">
          <thead>
            <tr class="lm-t-heading">
              <th class="table-checkbox">
                <input class="lm-checkbox select-all" name="select-all" type="checkbox" value="yes">
              </th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Tags</th>
              <th>Source</th>
              <th class="text-center">Level</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="lm-pagination"></div>
      <div class="table-loader-container" customers-table-loader>
        <div class="spinner-border text-primary text-center" role="status"></div>
      </div>
    </div>
  </div>

  <div class="tags-edit-container" style="display:none">
    <div class="bg-primary">
      <div>
        <div class="card lm-card">
          <div class="d-flex justify-content-between">
            <span class="lm-card-title font-14">Are you sure you want to delete this customer ?</span>
            <span class="lm-badge-square lm-badge-svg cursor-pointer p-0" lm-close-overlay lm-close-delete-customer style="--lm-badge-bg:transparent">
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
wp_enqueue_script('leadoma-customers');
wp_enqueue_style('leadoma-customer-profile');
wp_enqueue_style('leadoma-table');
wp_enqueue_style('leadoma-disable-admin-notices');
?>