<div class="leadoma leadoma-overlay-off leadoma-font lm-bg-light">
  <!-- toggle leadoma-overlay-off to show or hide overlay  -->
  <div class="lm-overlay cursor-pointer" lm-overlay
    style="background-color: #0005; position:absolute; left:00%; top:0%; z-index:1; width:100%; height: 100%"></div>
  <section class="container-fluid">
    <div class="row">
      <div class="col-12 page-title">
        Tags
      </div>
    </div>
    <div class="row mt-4 px-4">

      <div class="col-12 mt-2 mb-3">
        <button class="btn btn-primary btn-icon-text btn-icon-text-reverse px-3" lm-open-create-tag><i
            class="bi bi-file-earmark-plus"></i> Create New Tag</button>
      </div>

      <div class="col-12">
        <div class="lm-table-top bg-white">
          <div class="lm-title-search-wrapper">
            <span class="font-16 fw-bold" style="margin-right:96px">List of Tags</span>
            <div class="d-flex">
              <input type="text" class="form-control primary d-inline-block me-3 customers-search-input" id=""
                placeholder="Search Tags">
              <button class="btn btn-outline-secondary btn-icon-text" style="padding:16px">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M6.16309 4.83594H12.5911" stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M6.17392 4.79595C6.17392 3.83457 5.38876 3.05502 4.42045 3.05502C3.45215 3.05502 2.66699 3.83457 2.66699 4.79595C2.66699 5.75733 3.45215 6.53688 4.42045 6.53688C5.38876 6.53688 6.17392 5.75733 6.17392 4.79595Z"
                    stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square" />
                  <path d="M9.83691 11.2445H3.40889" stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square" />
                  <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M9.82608 11.2042C9.82608 10.2428 10.6112 9.46323 11.5795 9.46323C12.5478 9.46323 13.333 10.2428 13.333 11.2042C13.333 12.1655 12.5478 12.9451 11.5795 12.9451C10.6112 12.9451 9.82608 12.1655 9.82608 11.2042Z"
                    stroke="#FB8C00" stroke-width="1.5" stroke-linecap="square" />
                </svg>
              </button>
            </div>
          </div>
          <!-- <button class="btn btn-primary btn-icon-text px-3">Export <i class="bi bi-file-earmark-arrow-down"></i></button> -->
        </div>

        <div class="table-responsive">
          <table class="table table-hover tags-table leadoma-table table-bordered bg-white">
            <thead>
              <tr class="lm-t-heading">
                <th class="table-checkbox">
                  <input class="lm-checkbox select-all" name="select-all" type="checkbox" value="yes">
                </th>
                <th>Name</th>
                <th>color</th>
                <th>Created At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <div class="lm-pagination"></div>
        <div class="table-loader-container" tags-table-loader>
          <div class="spinner-border text-primary text-center" role="status"></div>
        </div>
        <!-- <button id="select-all" class="btn button-default">SelectAll/Cancel</button> -->
      </div>
    </div>

    <div class="tags-edit-container tag-edit-modal lm-have-edit" style="display: none;">
      <div id="lm-edit-add-tag" novalidate>
        <div class="card lm-card">
          <div class="d-flex justify-content-between">
            <!-- on edit -->
            <span class="lm-card-title on-edit font-20">Edit Tag</span>
            <!-- not on edit -->
            <span class="lm-card-title non-edit font-20">Create Tag</span>
            <span class="lm-badge-square lm-badge-svg cursor-pointer p-0" lm-close-overlay lm-close-edit-tag
              style="--lm-badge-bg:transparent">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/close.svg" alt="">
            </span>
          </div>

          <div class="mt-4 mb-0 mb-xxl-2">
            <!-- on edit -->
            <div>
              <label for="" class="form-label fw-400 on-edit">Edit Name</label>
              <input type="text" class="form-control primary on-edit" lm-edit-tag-name placeholder="Tag Name">
              <span class="form-helper-text invalid-feedback">Name is invalid</span>
            </div>

            <!-- not on edit -->
            <div>
              <label for="" class="form-label fw-400 non-edit">Name</label>
              <input type="text" class="form-control primary non-edit" lm-create-tag-name placeholder="Tag Name">
              <span class="form-helper-text invalid-feedback">Name is invalid</span>
            </div>
          </div>

          <div class="mt-4">
            <!-- on edit -->
            <label for="" class="form-label on-edit fw-400">Edit Color</label>
            <!-- not on edit -->
            <label for="" class="form-label non-edit fw-400">Choose Color</label>

            <div class="tag-colors-container mb-3">
              <div class="current-color"><span class="square-tag-color" style="--tag-color:red"></span></div>

              <div class="select-color">
                <!-- todo: more color based on new palette -->
                <!-- <span class="square-tag-color" lm-set-current-color="LightCoral" style="--tag-color:LightCoral"></span> -->
                <span class="square-tag-color" lm-set-current-color="red" style="--tag-color:red"></span>
                <span class="square-tag-color" lm-set-current-color="black" style="--tag-color:black"></span>
                <span class="square-tag-color" lm-set-current-color="gray" style="--tag-color:gray"></span>
                <!-- <span class="square-tag-color" lm-set-current-color="#00C19F" style="--tag-color:#00C19F"></span> -->
                <!-- <span class="square-tag-color" lm-set-current-color="#9747FF" style="--tag-color:#9747FF"></span> -->
                <!-- <span class="square-tag-color" lm-set-current-color="#55C100" style="--tag-color:#55C100"></span> -->
                <span class="square-tag-color" lm-set-current-color="lime" style="--tag-color:lime"></span>
                <!-- <span class="square-tag-color" lm-set-current-color="#DEDCDB" style="--tag-color:#DEDCDB"></span> -->
                <span class="square-tag-color" lm-set-current-color="gold" style="--tag-color:gold"></span>
                <!-- <span class="square-tag-color" lm-set-current-color="#455A64" style="--tag-color:#455A64"></span> -->
                <!-- <span class="square-tag-color" lm-set-current-color="#F55C42" style="--tag-color:#F55C42"></span> -->
                <!-- <span class="square-tag-color" lm-set-current-color="#5A57DD" style="--tag-color:#5A57DD"></span> -->
                <span class="square-tag-color" lm-set-current-color="blue" style="--tag-color:blue"></span>
                <!-- <span class="square-tag-color" lm-set-current-color="#4A251F" style="--tag-color:#4A251F"></span> -->
                <!-- <span class="square-tag-color" lm-set-current-color="#DD57C0" style="--tag-color:#DD57C0"></span> -->
                <span class="square-tag-color" lm-set-current-color="pink" style="--tag-color:pink"></span>
                <span class="square-tag-color" lm-set-current-color="cyan" style="--tag-color:cyan"></span>
                <!-- <span class="square-tag-color" lm-set-current-color="#ADFFBF" style="--tag-color:#ADFFBF"></span> -->
                <!-- <span class="square-tag-color" lm-set-current-color="#3603C8" style="--tag-color:#3603C8"></span> -->
                <span class="square-tag-color" lm-set-current-color="indigo" style="--tag-color:indigo"></span>
                <!-- <span class="square-tag-color" lm-set-current-color="#ECD0F9" style="--tag-color:#ECD0F9"></span> -->
                <!-- <span class="square-tag-color" lm-set-current-color="#FF7A00" style="--tag-color:#FF7A00"></span> -->
                <span class="square-tag-color" lm-set-current-color="orange" style="--tag-color:orange"></span>
                <!-- <span class="square-tag-color" lm-set-current-color="#A0123D" style="--tag-color:#A0123D"></span> -->
              </div>
            </div>

            <!-- on edit -->
            <button class="btn btn-primary mt-4 w-100 on-edit" lm-submit-edit-tag>Edit</button>
            <!-- not on edit -->
            <button class="btn btn-primary mt-4 w-100 non-edit" lm-submit-create-tag>Create</button>

          </div>
        </div>
      </div>
    </div>

    <div class="tags-edit-container tag-delete-modal" style="display: none;">
      <div class="">
        <div class="card lm-card">
          <div class="d-flex justify-content-between">
            <span class="lm-card-title font-14 mb-3">Are you sure you want to delete this tag?</span>
            <span class="lm-badge-square lm-badge-svg cursor-pointer p-0" lm-close-overlay lm-close-delete-tag
              style="--lm-badge-bg:transparent">
              <img src="<?php echo LEADOMA_DIR_URL ?>admin/images/icons/close.svg" alt="">
            </span>
          </div>

          <div>
            <label for="" class="form-label fw-400">Type tag name for delete</label>
            <input type="text" class="form-control primary" lm-delete-tag-name placeholder="">
            <span class="form-helper-text invalid-feedback">Error deleting tag!</span>
          </div>

          <div class="mt-3">
            <button class="btn btn-primary btn-danger w-100" lm-submit-delete-tag>Delete</button>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>
<?php
wp_enqueue_script('leadoma-tags');
wp_enqueue_style('leadoma-table');
wp_enqueue_style('leadoma-tags');
wp_enqueue_style('leadoma-disable-admin-notices');
?>