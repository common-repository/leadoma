// todo: add loader to customer tags

//* TEMPLATES
const getCustomerTagsTemplate = (tags) => `
${  tags.map((tag) => tag.title!="LEADOMA" ? `<div class="lm-badge lm-badge-lg me-2 me-xxl-3 mb-2 mb-xxl-3" style="--lm-badge-bg:${tag.color_code??'#000000'}">${ tag.title } <i class="on-edit bi bi-x-circle ms-2 cursor-pointer" remove-tag-from-customer=${tag.slug}></i></div>` : "").join("") }
`
const getTagsListTemplate = (tags, selectedTagSlugs) => `
${
  tags.map((tag) => tag.title!='LEADOMA' ?`
    <div class="select-tag mb-1" style="${selectedTagSlugs.includes(tag.slug)?'display:none':''}">
      <div class="tag-name">${tag.title}</div>
      <div class="d-flex align-items-center">
        <span class="tag-color-bar mx-3" style="--tag-color:${tag.color_code??'#000000'}"></span>
        <span class="add-tag" add-tag-to-customer=${tag.slug}>Add</span>
      </div>
    </div>`:'').join("")
}
`

const getCustomerActivitiesTemplate = (activities) => `
${
  activities.map((activity, index) => index<5?
    `<div class="lm-note-row">
      <div class="lm-line-ellipsis">
        <img src="${LEADOMA_DIR_URL}admin/images/icons/clock.svg" alt="">
        <span class="text-color-lightgray ms-2">
          ${activity.activity_data?.description?.replace(/\\"/g, '"').replace(/\\'/g, "'")}
        </span>
      </div>
      <span class="p-1 px-2 rounded-pill" style="background-color:var(--bs-gray-100)">${lm_format_date_short(activity.created_at)}</span>
    </div>`:null
  ).join("")
}
`

// todo: may change the icon
const getCustomerNotesTemplate = (notes) => `
${
  notes.map((note, index) => index<5?
    `<div class="lm-note-row">
      <div class="lm-line-ellipsis">
        <img src="${LEADOMA_DIR_URL}admin/images/icons/book-open.svg" alt="">
        <span class="text-color-lightgray ms-2">
          ${note.text?.replace(/\\"/g, '"').replace(/\\'/g, "'")}
        </span>
      </div>
      <span class="p-1 px-2 rounded-pill" style="background-color:var(--bs-gray-100)">${lm_format_date_short(note.created_at)}</span>
    </div>`:null
  ).join("")
}
`
let CUSTOMER_INFO = {};

jQuery(() => {
  let $ = jQuery;

  
  // let toAdd = [];
  // let toRemove = [];

  let ALL_TAGS = []

  let selectedTags = []; //CUSTOMER_INFO.tags;

  let initialSelectedTags = []; //selectedTags;

  //* ELEMENTS
  const LeadomaContainer = $(".leadoma");

  const CloseOverlay = $("[lm-close-overlay] , [lm-overlay]");

  const OpenEditBasicInfo = $("[lm-open-edit-basic-info]");

  const CloseEditBasicInfo = $("[lm-close-edit-basic-info] , [lm-overlay]");

  const OpenEditAdditionalInfo = $("[lm-open-edit-additional-info]");

  const CloseEditAdditionalInfo = $("[lm-close-edit-additional-info] , [lm-overlay]");

  let OpenDeleteCustomer = $("[lm-delete-customer]");

  const CloseDeleteCustomer = $("[lm-close-delete-customer] , [lm-overlay]");

  const DeleteCustomerModal = $(".tags-edit-container.delete-customer");


  const BasicInfoCard = $("[lm-basic-info-card]");

  const AdditionalInfoCard = $("[lm-additional-info-card]");

  const OpenEditTags = $("[lm-open-edit-tags]");
  const OpenEditNotes = $("[lm-open-edit-notes]");

  const CloseEditTags = $("[lm-close-edit-tags] , [lm-overlay]");
  const CloseEditNotes = $("[lm-close-edit-notes] , [lm-overlay]");

  const TagsCard = $("[lm-tags-card]");
  const NotesCard = $("[lm-notes-card]");

  const SearchTagsInput = $("[search-tags-input]");

  const SaveTagChangesButton = $("[save-tag-changes]")
  const SaveNoteChangesButton = $("[save-note-changes]")

  const DeleteCustomerSubmitButton = $("[lm-submit-delete-customer]")
  
  // activities
  const customerActivitiesCard = $("[lm-activities-card]")
  const customerActivitiesContainer = $("[lm-activities-container]")

  // notes
  const customerNotesCard = $("[lm-notes-card]")
  const customerNotesContainer = $("[lm-notes-container]")

  const BasicInfo = {
    "full_name": $("#lm-bi-input-full_name"),
    "email": $("#lm-bi-input-email"),
    "phone_number": $("#lm-bi-input-phone_number"),
    "country": $("#lm-bi-input-country"),
    "city": $("#lm-bi-input-city"),
    "language": $("#lm-bi-input-language"),
  }

  const AdditionalInfo = {
    "phone_number": $("#lm-bi-input-phonenumber2"),
    "address": $("#lm-bi-input-address"),
    "company": $("#lm-bi-input-company"),
    "state": $("#lm-bi-input-state"),
    "website": $("#lm-bi-input-website"),
    "zip_code": $("#lm-bi-input-zipcode"),
  }


  //* FUNCTIONS
  const closeModals = () => {
    BasicInfoCard.removeClass("lm-edit-mode");
    AdditionalInfoCard.removeClass("lm-edit-mode");
    TagsCard.removeClass("lm-edit-mode");
    NotesCard.removeClass("lm-edit-mode");
    LeadomaContainer.addClass("leadoma-overlay-off");
    DeleteCustomerModal.hide();
  }

  //* EVENT LISTENERS
  CloseOverlay.on("click", () => {
    console.log("CloseOverlay");
    LeadomaContainer.addClass("leadoma-overlay-off");
  });
  
  CloseEditBasicInfo.on("click", () => {
    console.log("CloseEditBasicInfo");
    BasicInfoCard.removeClass("lm-edit-mode");
  });

  OpenEditBasicInfo.on("click", () => {
    console.log("OpenEditBasicInfo");
    LeadomaContainer.removeClass("leadoma-overlay-off");
    BasicInfoCard.addClass("lm-edit-mode");
  });
  
  CloseEditAdditionalInfo.on("click", () => {
    console.log("CloseEditAdditionalInfo");
    AdditionalInfoCard.removeClass("lm-edit-mode");
  });

  OpenEditAdditionalInfo.on("click", () => {
    console.log("OpenEditAdditionalInfo");
    LeadomaContainer.removeClass("leadoma-overlay-off");
    AdditionalInfoCard.addClass("lm-edit-mode");
  });

  CloseEditTags.on("click", () => {
    console.log("CloseEditTags");
    TagsCard.removeClass("lm-edit-mode");

    // close WITHOUT saving 
    selectedTags = initialSelectedTags;
    searchAndRenderTags();
    renderCustomerTags(selectedTags)
  });

  OpenEditTags.on("click", () => {
    console.log("OpenEditTags");
    LeadomaContainer.removeClass("leadoma-overlay-off");
    TagsCard.addClass("lm-edit-mode");
  });

  CloseEditNotes.on("click", () => {
    console.log("CloseEditNotes");
    NotesCard.removeClass("lm-edit-mode");

    // close WITHOUT saving 
    // selectedNotes = initialSelectedNotes;
    // searchAndRenderNotes();
    // renderCustomerNotes(selectedNotes)
  });

  OpenEditNotes.on("click", () => {
    console.log("OpenEditNotes");
    LeadomaContainer.removeClass("leadoma-overlay-off");
    NotesCard.addClass("lm-edit-mode");
  });


  OpenDeleteCustomer.on("click", () => {
    console.log("OpenDeleteCustomer");
    LeadomaContainer.removeClass("leadoma-overlay-off");
    DeleteCustomerModal.show();
  });

  CloseDeleteCustomer.on("click", () => {
    console.log("CloseDeleteCustomer");
    DeleteCustomerModal.hide();
  });


  //* RENDER

  // render basic & additional info
  const renderBasicInfo = (info) => {
    // const city = info.rendered_data.filter(item => item.title == "city")[0].value;
    const city = "";
    // const country = info.rendered_data.filter(item => item.title == "country")[0].value;
    const country = "";
    // const language = info.rendered_data.filter(item => item.title == "language")[0].value;
    const language = "";

    $("[lm-bi-fullname]").html(info.full_name?info.full_name:"-");
    $("[lm-bi-email]").html(info.email?info.email:"-");
    $("[lm-bi-phonenumber]").html(info.phone_number?info.phone_number:"-");
    $("[lm-bi-country]").html(country?country:"-");
    $("[lm-bi-city]").html(city?city:"-");
    $("[lm-bi-language]").html(language ? language : "-");

    BasicInfo.full_name.val(info.full_name);
    BasicInfo.email.val(info.email);
    BasicInfo.phone_number.val(info.phone_number);
    BasicInfo.country.val(country);
    BasicInfo.city.val(city);
    BasicInfo.language.val(language);
    // render profile
    $("[lm-bi-level]").html(info.level);
    $("[lm-bi-email-href]").attr("href", `mailto:${info.email}`);
    $("[lm-bi-phoneenumber-href]").attr("href", `tel:${info.phone_number}`);
    $("[lm-bi-level]").html(info.level);

    // 
    $("[lm-i-cashback]").html(info.cash_back?info.cash_back:"-");

    renderAdditionalInfo(info.customer_data)
  }

  const renderAdditionalInfo = (ainfo) => {

    const phonenumber2 = ainfo?.phone_numbers[0];
    const address = ainfo?.address;
    const company = ainfo?.company;
    const state = ainfo?.state;
    const website = ainfo?.website;
    const zipcode = ainfo?.zip_code;

    $("[lm-bi-phonenumber2]").html(phonenumber2 ? phonenumber2 : "-");
    $("[lm-bi-address]").html(address ? address : "-");
    $("[lm-bi-company]").html(company ? company : "-");
    $("[lm-bi-state]").html(state ? state : "-");
    $("[lm-bi-website]").html(website ? website : "-");
    $("[lm-bi-zipcode]").html(zipcode ? zipcode : "-");

    AdditionalInfo.phone_number.val(phonenumber2);
    AdditionalInfo.address.val(address);
    AdditionalInfo.company.val(company);
    AdditionalInfo.state.val(state);
    AdditionalInfo.website.val(website);
    AdditionalInfo.zip_code.val(zipcode);
    
  }

  // render customer activities
  const renderCustomerActivities = (activities) => {
    customerActivitiesContainer.html(getCustomerActivitiesTemplate(activities))
  }
  // render customer notes
  const renderCustomerNotes = (notes) => {
    customerNotesContainer.html(getCustomerNotesTemplate(notes))
  }


  // TAGS
  // c: user clicks on add tag button
  const addListenerToAddTagToCustomer = () => {
    const AddTagToCustomer = $("[add-tag-to-customer]")
    AddTagToCustomer.on("click", (e) => {
      const tagSlugToAdd = $(e.currentTarget).attr("add-tag-to-customer");

      // toAdd.push(tagSlugToAdd);
      // toRemove = toRemove.filter(slg=>slg!=tagSlugToAdd);

      selectedTags = [...selectedTags, ...ALL_TAGS.filter(item => item.slug == tagSlugToAdd)];
      searchAndRenderTags();
      renderCustomerTags(selectedTags)
    })
  }

  // c: user clicks on remove tag button
  const addListenerToRemoveTagFromCustomer = () => {
    const RemoveTagFromCustomer = $("[remove-tag-from-customer]")
    RemoveTagFromCustomer.on("click", (e) => {
      const tagSlugToRemove = $(e.currentTarget).attr("remove-tag-from-customer");

      // toRemove.push(tagSlugToRemove);
      // toAdd = toAdd.filter(slg=>slg!=tagSlugToRemove);

      console.log("clicked on remove", tagSlugToRemove)
      selectedTags = selectedTags.filter(item => item.slug != tagSlugToRemove);
      console.log(selectedTags)
      searchAndRenderTags()
      renderCustomerTags(selectedTags)
    })
  }

  // c: Rendering selected or customer's tags
  const renderCustomerTags = (tags) => {
    $("[lm-customer-tags]").html(getCustomerTagsTemplate(tags))
    addListenerToRemoveTagFromCustomer()
  }

  // c: Rendering all tags list
  const renderTagsList = (tags, selectedTagSlugs) => {
    $("[lm-all-tags]").html(getTagsListTemplate(tags, selectedTagSlugs))
    addListenerToAddTagToCustomer()
  }

  // c: Rerendering searched tags
  const searchAndRenderTags = () => {
    const search = SearchTagsInput.val().toLowerCase();
    const result = ALL_TAGS.filter(item => item.title.toLowerCase().search(search) == -1);
    renderTagsList(ALL_TAGS, [...result, ...selectedTags].map(item => item.slug));
  }
  SearchTagsInput.on("keyup", searchAndRenderTags);

  // c: user clicks on save tag changes button
  SaveTagChangesButton.on("click", async () => {
    console.log("update customer tags");
    const code = CUSTOMER_INFO.customer.code;
    const dataToRemove = {
      tags: selectedTags.map(tg => { return { "slug": tg.slug } })
    }

    SaveTagChangesButton.prop('disabled', true);
    const res = await lm_update_customer_tags(code, dataToRemove);
    SaveTagChangesButton.prop('disabled', false);
    
    if (res) {
      CUSTOMER_INFO = res;
      console.log(CUSTOMER_INFO)
      
      renderBasicInfo(CUSTOMER_INFO.customer);

      initialSelectedTags = CUSTOMER_INFO.customer.tags;
      selectedTags = initialSelectedTags;
      renderCustomerTags(CUSTOMER_INFO.customer.tags);
      searchAndRenderTags();
      closeModals();
    } else {
      console.error("Leadoma: Error getting customers");
      // todo: show an alert
    }
  })

  SaveNoteChangesButton.on("click", async () => {
    console.log("add note to customer");
    const code = CUSTOMER_INFO.customer.code;
    const textarea = $("[lm-customer-note]");
    const text = textarea.val();
    if (!text.trim()) {
      return;
    }
    console.log(text)

    SaveNoteChangesButton.prop('disabled', true);
    // send add note request
    const res = await lm_add_customer_note(code, text);
    SaveNoteChangesButton.prop('disabled', false);
    
    if (res.create) {
      textarea.val("");
      initCustomerNotes(code);
      closeModals();
      
    } else {
      console.error("Leadoma: Error adding note to customer");
      // todo: show an alert
    }
  })

  // c: user clicks on delete customer
  DeleteCustomerSubmitButton.on("click", async() => { 

    DeleteCustomerSubmitButton.prop('disabled', true);
    const code = CUSTOMER_INFO.customer.code;
    const res = await lm_delete_customer(code);
    DeleteCustomerSubmitButton.prop('disabled', false);

    if (res) {
      leadomaRedirectTo("leadoma-customers");
      closeModals();
    } else {
      setInputError(DeleteTagInput, "Error deleting customer!");
      console.error("Leadoma: Error deleting customer!");
    }
  })

  $("#lm-bi-form").submit(async(e) => {
    e.preventDefault();
    console.log("bi form submitted");
    const SubmitButtons = $("#lm-bi-form button:submit")

    // get values and send requests
    let data = {}
    const basicInfoKeys = Object.keys(BasicInfo);
    basicInfoKeys.map(key => { data[key] = BasicInfo[key].val() });
    
    let {city, country, language, ...rest} = data; 

    const code = CUSTOMER_INFO.customer.code;
    
    SubmitButtons.prop('disabled', true);
    const res = await lm_update_customer(code, rest);
    SubmitButtons.prop('disabled', false);

    // todo: refactor
    if (res) {
      CUSTOMER_INFO = res;
      console.log(CUSTOMER_INFO)
      // renderCustomers(CUSTOMER_INFO.customer)

      renderBasicInfo(CUSTOMER_INFO.customer);
      initialSelectedTags = CUSTOMER_INFO.customer.tags;
      selectedTags = initialSelectedTags;
      renderCustomerTags(CUSTOMER_INFO.customer.tags);
      
      closeModals();
    } else {
      // todo: show an alert or something
      console.error("Leadoma: Error getting customers");
    }

    // $(e.target.elements["login_email_address"]);


    // after success: call renderBasicInfo with new values or render the whole page again
  })

  $("#lm-ai-form").submit(async(e) => {
    e.preventDefault();
    console.log("ai form submitted");
    const SubmitButtons = $("#lm-ai-form button:submit")

    // get values and send requests
    let data = {}
    const additionalInfoKeys = Object.keys(AdditionalInfo);
    additionalInfoKeys.map(key => { data[key] = AdditionalInfo[key].val() });
    
    let {...rest} = data; 

    const code = CUSTOMER_INFO.customer.code;
    
    SubmitButtons.prop('disabled', true);
    const res = await lm_update_customer_additional(code, rest);
    SubmitButtons.prop('disabled', false);

    // todo: refactor
    if (res) {
      CUSTOMER_INFO.customer_data = res;
      console.log(CUSTOMER_INFO)

      renderAdditionalInfo(CUSTOMER_INFO.customer_data);
      
      closeModals();
    } else {
      // todo: show an alert or something
      console.error("Leadoma: Error getting customers additional info");
    }

    // $(e.target.elements["login_email_address"]);


    // after success: call renderBasicInfo with new values or render the whole page again
  })

  const initCustomerActivities = async (code) => {
    customerActivitiesCard.addClass("lm-loading-small");
    const res = await lm_get_customer_activities(code);
    console.log(res)
    if (res) { 
      let CUSTOMER_ACTIVITIES = res;
      console.log(CUSTOMER_ACTIVITIES)
      renderCustomerActivities(CUSTOMER_ACTIVITIES.activities);
    }
    customerActivitiesCard.removeClass("lm-loading-small");
    
  }
  const initCustomerNotes = async (code) => {
    customerNotesContainer.html("")
    customerNotesCard.addClass("lm-loading-small");
    const res = await lm_get_customer_notes(code);
    console.log(res)
    if (res) { 
      CUSTOMER_NOTES = res;
      console.log(CUSTOMER_NOTES)
      renderCustomerNotes(CUSTOMER_NOTES.notes); //! be careful about .note
    }
    customerNotesCard.removeClass("lm-loading-small");
    
  }

  const init = async() => {
    const code = leadomaGetParam("id");
    
    LeadomaContainer.addClass("lm-loading")
    // todo: refactor
    res = await lm_get_customer(code);
    if (res) {
      CUSTOMER_INFO = res;
      console.log(CUSTOMER_INFO)
      // renderCustomers(CUSTOMER_INFO.customer)

      initCustomerActivities(code);
      initCustomerNotes(code);

      renderBasicInfo(CUSTOMER_INFO.customer);
      initialSelectedTags = CUSTOMER_INFO.customer.tags;
      selectedTags = initialSelectedTags;
      renderCustomerTags(CUSTOMER_INFO.customer.tags);
      
    } else {
      // todo: show an alert or something
      console.error("Leadoma: Error getting customers");
    }
    LeadomaContainer.removeClass("lm-loading")
    
  }

  const initTags = async () => { 
    // todo: get and render all tags, when modal is open
    res = await lm_get_list_of_tags();
    if (res) {
      ALL_TAGS = res.tags;
      // render tags and customer tags
      searchAndRenderTags()
    } else {
      // todo: show an alert or something
      console.error("Leadoma: Error getting customers");
    }
    
  }

  init();
  initTags();


  
})

const handleCustomerActivitiesRedirect = () => {
  if (CUSTOMER_INFO.customer) {
    const customerName = CUSTOMER_INFO.customer.full_name;
    const customerCode = CUSTOMER_INFO.customer.code;
    const customerImage = "";// don't have image
    const customerLevel = CUSTOMER_INFO.customer.level;
    leadomaRedirectTo('leadoma-customer-activities', { name: customerName, id: customerCode, image: customerImage, level: customerLevel })
  } else {
    // todo: show something..
  }
}