<div class="card lm-card border-on-edit lm-have-edit" lm-additional-info-card>
  <!-- toggle "lm-edit-mode" for edit mode (along with "leadoma-overlay-off" on main leadoma container) -->
  <div class="d-flex justify-content-between" style="height:33px">
    <span class="lm-card-title">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/book.svg" alt="">
      Additional info
    </span>

    <!-- hide on-edit  -->
    <span class="lm-badge-square lm-badge-svg cursor-pointer non-edit" lm-open-edit-additional-info
      style="--lm-badge-bg:var(--bs-primary-50);">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/pencil.svg" alt="">
    </span>

    <!-- show on-edit  -->
    <span class="lm-badge-square lm-badge-svg cursor-pointer p-0 on-edit" lm-close-edit-additional-info lm-close-overlay
      style="--lm-badge-bg:transparent">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/close.svg" alt="">
    </span>
  </div>

  <!-- hide on-edit  -->
  <div class="mx-4 font-14 font-xxl-16 non-edit">
    <div class="row mt-4">
      <div class="col-4 pe-0">Company Name</div>
      <div class="col-8 ps-0 text-color-lightgray" lm-bi-company></div>
    </div>
    <div class="row mt-3">
      <div class="col-4 pe-0">Address</div>
      <div class="col-8 ps-0 text-color-lightgray" lm-bi-address></div>
    </div>
    <div class="row mt-3">
      <div class="col-4 pe-0">Zip Code</div>
      <div class="col-8 ps-0 text-color-lightgray" lm-bi-zipcode></div>
    </div>
    <div class="row mt-3">
      <div class="col-4 pe-0">State</div>
      <div class="col-8 ps-0 text-color-lightgray" lm-bi-state></div>
    </div>
    <div class="row mt-3">
      <div class="col-4 pe-0">Phone 2</div>
      <div class="col-8 ps-0 text-color-lightgray" lm-bi-phonenumber2></div>
    </div>
    <div class="row mt-3">
      <div class="col-4 pe-0">Website</div>
      <div class="col-8 ps-0 text-color-lightgray" lm-bi-website></div>
    </div>
  </div>

  <!-- show on-edit  -->
  <form action="" id="lm-ai-form" class="mx-2 on-edit mt-0">
    <div class="row mt-3">
      <div class="col-6 mt-0">
        <label for="" class="form-label fw-normal font-10 text-color-lightgray">Company Name</label>
        <input type="text" class="form-control form-control-sm primary text-color-lightgray px-2 font-12"
          id="lm-bi-input-company" placeholder="Company">
      </div>
      <div class="col-6 mt-0">
        <label for="" class="form-label fw-normal font-10 text-color-lightgray">Address</label>
        <input type="text" class="form-control form-control-sm primary text-color-lightgray px-2 font-12"
          id="lm-bi-input-address" placeholder="56 East Park St.">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-6 mt-0">
        <label for="" class="form-label fw-normal font-10 text-color-lightgray">Zip Code</label>
        <input type="text" class="form-control form-control-sm primary text-color-lightgray px-2 font-12"
          id="lm-bi-input-zipcode" placeholder="36104">
      </div>
      <div class="col-6 mt-0">
        <label for="" class="form-label fw-normal font-10 text-color-lightgray">State</label>
        <input type="text" class="form-control form-control-sm primary text-color-lightgray px-2 font-12"
          id="lm-bi-input-state" placeholder="Alabama">
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-6 mt-0">
        <label for="" class="form-label fw-normal font-10 text-color-lightgray">Phone 2</label>
        <input type="text" class="form-control form-control-sm primary text-color-lightgray px-2 font-12"
          id="lm-bi-input-phonenumber2" placeholder="2124567890">
      </div>
      <div class="col-6 mt-0">
        <label for="" class="form-label fw-normal font-10 text-color-lightgray">Website</label>
        <input type="text" class="form-control form-control-sm primary text-color-lightgray px-2 font-12"
          id="lm-bi-input-website" placeholder="www.example.com">
      </div>
    </div>

    <button class="btn btn-primary btn-sm btn-icon-text btn-icon-text-reverse mt-3 float-end fw-normal font-12 px-2">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M5.58018 7.50553C6.97286 8.38599 8.01344 9.95934 8.01344 9.95934H8.03432C8.03432 9.95934 10.245 6.04746 14.3521 3.6416"
          stroke="white" stroke-width="1.5" stroke-linecap="square" />
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M7.81413 14.1667C11.2199 14.1667 13.9808 11.4058 13.9808 8.00004C13.9808 4.59428 11.2199 1.83337 7.81413 1.83337C4.40837 1.83337 1.64746 4.59428 1.64746 8.00004C1.64746 11.4058 4.40837 14.1667 7.81413 14.1667Z"
          stroke="white" stroke-width="1.5" stroke-linecap="round" />
      </svg>
      Save Changes
    </button>

  </form>

  <div class="non-edit" style="padding-bottom:calc(48px - 12px)"></div>
  <!-- <div class="on-edit"></div> -->

</div>