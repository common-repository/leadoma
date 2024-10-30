jQuery(() => {
  let $ = jQuery;

  // list of customers will be set after api call
  let CUSTOMERS = {};
  let currentUserData = {};

  //* ELEMENTS
  const LeadomaContainer = $(".leadoma");

  const CloseOverlay = $("[lm-close-overlay] , [lm-overlay]");

  const CloseDeleteCustomer = $("[lm-close-delete-customer] , [lm-overlay]");

  let OpenDeleteCustomer = $("[lm-delete-customer]");

  const DeleteCustomerModal = $(".tags-edit-container");

  const CustomerInfo = $(".delete-customer-info");

  const TagsTableBody = $(".customers-table tbody");
  const CustomersTableLoader = $("[customers-table-loader]");

  const DeleteCustomerButton = $("[lm-submit-delete-customer]");

  //* TEMPLATE GENERATORS
  const getDeleteCustomerTemplate = (info) => {
    const city = info.rendered_data.filter((field) => field.title == "city")[0]
      .value;
    const country = info.rendered_data.filter(
      (field) => field.title == "country"
    )[0].value;
    // <div class="lm-profile-image" style='--level:"${info.level}";background-image: url("${ LEADOMA_DIR_URL }admin/images/temp/profile.png")'></div>
    return `
    <div class="card lm-card font-10 lm-profile-card delete-profile-card pt-4 pb-4">
      <div class="lm-profile-card-info">
        <div class="lm-profile-image" style='--level:"${info.level}";background-image: url(""),   linear-gradient(to bottom,var(--bs-gray-200),var(--bs-gray-200))'></div>
        <div class="font-16 fw-bold mt-3">${info.full_name}</div>
        <a class="lm-profile-email" href="mailto:${info.email}">
          <span>
            <img class="pe-1" src="${LEADOMA_DIR_URL}admin/images/icons/envelope.svg" alt="">
            <span>${info.email}</span>
          </span>
          <span class="ms-1">
            <img src="${LEADOMA_DIR_URL}admin/images/icons/redo.svg" alt="">
          </span>
        </a>
        <div class="location-number d-flex justify-content-between align-items-center text-color mt-2" style="--lm-text-color:var(--bs-gray-300)">
          <span>
            <img src="${LEADOMA_DIR_URL}admin/images/icons/location.svg" alt="">
            ${city}, ${country}
          </span>
          <span class="ms-4">
            <img src="${LEADOMA_DIR_URL}admin/images/icons/call-outgoing.svg" alt="">
            ${info.phone_number}
          </span>
        </div>
      </div>
    </div>
    `;
  };

  const getCustomerRowTemplate = (info, index) =>
    `
    <tr>
      <td class="table-checkbox">
        <input class="lm-checkbox select-item" name="select-item" type="checkbox" value="1001">
      </td>
      <td>${info.full_name}</td>
      <td>${info.email}</td>
      <td>${info.phone_number}</td>
      <td style="max-width:300px" class="have-badge">
        <div class="contains-badge">
          <div>
            ${info.tags
              .map((tag) =>
                tag.title != "LEADOMA"
                  ? `<span class="lm-badge" style="--lm-badge-bg:${
                      tag.color_code ?? "#000000"
                    }">${tag.title}</span>`
                  : ""
              )
              .join("")}
          </div>
          <span class="lm-badge lm-badge-icon cursor-pointer" style="--lm-badge-color: var(--bs-gray-500);--lm-badge-bg:var(--bs-gray-50)"><i class="bi bi-three-dots"></i></span>
        </div>
      </td>
      <td>${info.score}</td>
      <td class="text-center">${info.level}</td>
      <td>${lm_format_date(info.created_at)}</td>
      <td class="text-center have-badge">  
        <div class="d-flex justify-content-center">
          <span class="lm-badge-square cursor-pointer me-2" onClick="leadomaRedirectTo('leadoma-customer-profile', { id: '${
            info.code
          }'})"><i class="bi bi-eye"></i> Overview</span>
          </div>
          </td>
    </tr>
    `;
  // <span class="lm-badge-square cursor-pointer me-2" onClick="leadomaRedirectTo('leadoma-customer-profile', { id: '${info.code}'})"><i class="bi bi-pencil-square"></i> Edit</span>
  // <span class="lm-badge-square cursor-pointer" lm-delete-customer="${info.code}" style="--lm-badge-bg:var(--bs-error-500); --lm-badge-color:#FFF"><i class="bi bi-trash3"></i></span>

  //* FUNCTIONS
  const setDeleteCustomerData = (code, mode) => {
    if (mode == "delete") {
      currentUserData = CUSTOMERS.customers.filter(
        (customer) => customer.code == code
      )[0];
      CustomerInfo.html(getDeleteCustomerTemplate(currentUserData));
    }
  };

  const getPaginationTemplate = (max, current) => {
    let pages = [...Array(max + 1).keys()];
    pages = pages.splice(1);
    ret = pages.map((page) => {
      return `<span class='${
        page == current ? "current lm-page" : "lm-page"
      }'>${page}</span>`;
    });
    return ret;
  };

  const closeModals = () => {
    DeleteCustomerModal.hide();
    LeadomaContainer.addClass("leadoma-overlay-off");
  };

  //* EVENT LISTENERS
  // c: closing delete modal and overlay
  CloseOverlay.on("click", (e) => {
    console.log("CloseOverlay");
    LeadomaContainer.addClass("leadoma-overlay-off");
  });
  CloseDeleteCustomer.on("click", (e) => {
    console.log("CloseDeleteCustomer");
    DeleteCustomerModal.hide();
  });

  // c: opening delete customer modal on click
  const DeleteButtonListener = () => {
    OpenDeleteCustomer.on("click", (e) => {
      console.log("OpenDeleteCustomer");
      LeadomaContainer.removeClass("leadoma-overlay-off");
      DeleteCustomerModal.show();

      let code = $(e.currentTarget).attr("lm-delete-customer");
      setDeleteCustomerData(code, "delete");
    });
  };

  // c: user submits the delete button
  DeleteCustomerButton.on("click", async (e) => {
    e.preventDefault();

    DeleteCustomerButton.prop("disabled", true);
    const code = currentUserData.code;
    const res = await lm_delete_customer(code);
    DeleteCustomerButton.prop("disabled", false);

    if (res) {
      init();
      closeModals();
    } else {
      setInputError(DeleteTagInput, "Error deleting customer!");
      console.error("Leadoma: Error deleting customer!");
    }
  });

  //* RENDER FUNCTIONS
  // c: renders the list of customers
  const renderCustomers = (customers) => {
    const tableRows = customers.map((info, index) => {
      return getCustomerRowTemplate(info, index);
    });

    TagsTableBody.html(tableRows);

    OpenDeleteCustomer = $("[lm-delete-customer]");
    DeleteButtonListener();
  };

  const renderPagination = (max, current) => {
    $(".lm-pagination").html(getPaginationTemplate(max, current));
  };
  // c: fetching customers and calling the render function

  const init = async (page = 1) => {
    $(".lm-pagination").html("");
    setTableLoading(TagsTableBody, CustomersTableLoader, true);
    CUSTOMERS = await lm_get_list_of_customers(page);

    if (CUSTOMERS) {
      if (!CUSTOMERS.customers.length) {
        console.log("Leadoma: No customers");
      } else {
        console.log(CUSTOMERS);
        renderCustomers(CUSTOMERS.customers);
        renderPagination(
          Math.ceil(CUSTOMERS.count / CUSTOMERS.page_size),
          page
        );
      }
    } else {
      // todo: show an alert or something
      console.error("Leadoma: Error getting customers");
    }
    setTableLoading(TagsTableBody, CustomersTableLoader, false);
  };
  init(1);

  // pagination
  $(document).on("click", (e) => {
    if (e.target.classList.contains("lm-page")) {
      console.log("was page...");
      const pageElement = $(e.target);
      init(pageElement.html());
    }
  });
});
