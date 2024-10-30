<div class="card lm-card border-on-edit lm-have-edit" lm-tags-card> <!-- toggle "lm-edit-mode" for edit mode (along with "leadoma-overlay-off" on main leadoma container) -->
  <div class="d-flex justify-content-between" style="height:33px">
    <span class="lm-card-title">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/book.svg" alt="">
      Tags
    </span>

    <!-- hide on-edit  -->
    <span class="lm-badge-square lm-badge-svg cursor-pointer non-edit" lm-open-edit-tags style="--lm-badge-bg:var(--bs-primary-50);">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/pencil.svg" alt="">
    </span>
    
    <!-- show on-edit  -->
    <span class="lm-badge-square lm-badge-svg cursor-pointer p-0 on-edit" lm-close-edit-tags lm-close-overlay style="--lm-badge-bg:transparent">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/close.svg" alt="">
    </span>
  </div>

  <div class="d-flex flex-wrap mt-4" lm-customer-tags>
  </div>

  <!-- show on-edit  -->
  <div class="on-edit mt-2">

    <div class="edit-tags-container">
      <div class="search-tags-input-container">
        <div class="input-search-icon">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="7.33266" cy="7.19252" r="5.35902" stroke="#BFBFBF" stroke-width="1.5" stroke-linecap="square"/>
            <path d="M10.9912 11.1389L14.0269 14.1667" stroke="#BFBFBF" stroke-width="1.5" stroke-linecap="square"/>
          </svg>
        </div>
        <input type="text" search-tags-input class="form-control form-control-sm search-tags-input" id="" placeholder="Search tags">
      </div>

      <!-- all tags but display hidden if is selected -->
      <div class="select-tags mt-2 font-12 font-xxl-10" lm-all-tags>
      </div>

    </div>

    <button class="btn btn-primary d-inline btn-sm btn-icon-text btn-icon-text-reverse mt-3 float-end fw-normal font-12 px-2" save-tag-changes>
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M5.58018 7.50553C6.97286 8.38599 8.01344 9.95934 8.01344 9.95934H8.03432C8.03432 9.95934 10.245 6.04746 14.3521 3.6416" stroke="white" stroke-width="1.5" stroke-linecap="square"/>
        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.81413 14.1667C11.2199 14.1667 13.9808 11.4058 13.9808 8.00004C13.9808 4.59428 11.2199 1.83337 7.81413 1.83337C4.40837 1.83337 1.64746 4.59428 1.64746 8.00004C1.64746 11.4058 4.40837 14.1667 7.81413 14.1667Z" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
      Save Changes
    </button>
  </div>

</div>