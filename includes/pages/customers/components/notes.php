<div class="card lm-card lm-loading-small border-on-edit lm-have-edit" lm-notes-card> <!--  lm-loading-small -->  <!-- toggle "lm-edit-mode" for edit mode (along with "leadoma-overlay-off" on main leadoma container) -->
  <div class="d-flex justify-content-between">
    <span class="lm-card-title">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/note.svg" alt="">
      Notes
    </span>
  
    <span class="lm-badge-square lm-badge-svg cursor-pointer non-edit" lm-open-edit-notes style="--lm-badge-bg:var(--bs-primary-50);">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/pencil.svg" alt="">
    </span>
    
    <!-- show on-edit  -->
    <span class="lm-badge-square lm-badge-svg cursor-pointer p-0 on-edit" lm-close-edit-notes lm-close-overlay style="--lm-badge-bg:transparent">
      <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/close.svg" alt="">
    </span>
  </div>
  
  <div class="mt-3 font-10 non-edit" lm-notes-container>
  </div>

  <div class="lm-small-loader d-flex justify-content-center align-items-center" style="background-color: #fff5; z-index:1; width:100%; min-height: 200px">
    <div class="spinner-border text-primary text-center" role="status"></div>
  </div>

  <!-- <span onClick="handleCustomerActivitiesRedirect()" class="font-10 mt-1 lm-more-button a-dark cursor-pointer non-edit">
    <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/plus.svg" alt="+">
    All Notes
  </span> -->
  
  <div class="on-edit mt-2">
    <div>
      <textarea class="lm-textarea" name="" id="" cols="20" rows="5" lm-customer-note></textarea>
    </div>

    <button class="btn btn-primary d-inline btn-sm btn-icon-text btn-icon-text-reverse mt-3 float-end fw-normal font-12 px-2" save-note-changes>
      Add note
    </button>
  </div>

</div>