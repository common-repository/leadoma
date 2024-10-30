jQuery(() => {
  let $ = jQuery;

  // list of tags will be set after api call
  let TAGS = []

  // setting this when edit or delete modal opens
  let = currentTag = {};
  
  // todo: get the default color from feature palette
  const defaultColor = "red";
  const defaultBorder = "#000000";
  // const defaultColor = COLOR_LIST[0].color;
  // const defaultBorder = COLOR_LIST[0].border;

  //* ELEMENTS
  const LeadomaContainer = $(".leadoma");

  const CloseOverlay = $("[lm-close-overlay] , [lm-overlay]");

  const CloseEditTag = $("[lm-close-edit-tag] , [lm-overlay]");

  let OpenEditTag = $("[lm-open-edit-tag]");

  const OpenCreateTag = $("[lm-open-create-tag]");

  const EditTagModal = $(".tag-edit-modal");
  
  const EditTagNameInput = $("input[lm-edit-tag-name]");
  
  const CurrentColor = $(".tag-colors-container .current-color");

  const AddEditTagForm = $("#lm-edit-add-tag");

  const EditTagButton = $("[lm-submit-edit-tag]");
  const CreateTagButton = $("[lm-submit-create-tag]");
  
  const EditTagInput = $("input[lm-edit-tag-name]");
  const CreateTagInput = $("input[lm-create-tag-name]");

  const TagsTableBody = $(".tags-table tbody");
  const TagsTableLoader = $("[tags-table-loader]");
  
  let OpenDeleteTag = $("[lm-open-delete-tag]");
  const CloseDeleteTag = $("[lm-close-delete-tag] , [lm-overlay]");
  const DeleteTagModal = $(".tag-delete-modal");
  const DeleteTagSubmit = $("[lm-submit-delete-tag]");
  const DeleteTagInput = $("[lm-delete-tag-name]");


  //* TEMPLATE GENERATORS 
  let currentColorHex = defaultColor;
  const getCurrentColorTemplate = (color, border) => {
    currentColorHex = color;
    return `<span class="square-tag-color" style="--tag-color:${color??'#000000'};--border-color:${border}"></span>`
  };

  const getTagRowTemplate = (tag, index) => 
    `<tr>
      <td class="table-checkbox">
        <input class="lm-checkbox select-item" name="select-item" type="checkbox" value="${tag.slug}">
      </td>
      <td style="width:30%">${tag.title}</td>
      <td><span class="color-bar" style="--tag-color:${tag.color_code??'#000000'}" ></span></td>
      <td>${lm_format_date(tag.created_at)}</td>
      <td class="text-center have-badge">
        <div class="d-flex justify-content-center">
          <span class="lm-badge-square cursor-pointer me-2" lm-open-edit-tag="${tag.slug}"><i class="bi bi-pencil-square"></i> Edit</span>
          <span class="lm-badge-square cursor-pointer" lm-open-delete-tag="${tag.slug}" style="--lm-badge-bg:var(--bs-error-500); --lm-badge-color:#FFF"><i class="bi bi-trash3"></i></span>
        </div>
      </td>
    </tr>`

  
  //* FUNCTIONS

  const setEditCreateDeleteTagData = (slug, mode) => {
    if(mode == "create") {
      CurrentColor.html(getCurrentColorTemplate(defaultColor, defaultBorder))
      EditTagModal.removeClass("lm-edit-mode");

    } else {
      currentTag = TAGS.tags.filter(tag=>tag.slug==slug)[0]
      title = currentTag.title;
      color = currentTag.color_code;
      border = "#000000";
      // const border = COLOR_LIST.filter(a => a.color == `#${color}`)[0].border

      if (mode == "edit") {    
        EditTagModal.addClass("lm-edit-mode");
        EditTagNameInput.val(title);
        CurrentColor.html(getCurrentColorTemplate(color, border))
        
        //* setting all colors based on list
        // $(".tag-colors-container .select-color").html(COLOR_LIST.map(color => `<span class="square-tag-color mx-1" style="--tag-color:${color.color};--border-color:${color.border}"></span>`))

      } else if (mode == "delete") {
        DeleteTagSubmit.prop('disabled', true);
        DeleteTagInput.attr("placeholder", title);

      }
    
    }
  } 

  const getPaginationTemplate = (max, current) => {
    let pages = [...Array(max+1).keys()];
    pages = pages.splice(1);
    ret = pages.map((page) => {
      return `<span class='${(page == current)?"current lm-page":"lm-page" }'>${page}</span>`;
    })
    return ret
  }

  const closeModals = () => {
    EditTagModal.hide();
    DeleteTagModal.hide();
    LeadomaContainer.addClass("leadoma-overlay-off");
  }


  //* EVENT LISTENERS

  // c: closing edit&create / delete modals and overlay 
  CloseOverlay.on("click", (e) => {
    console.log("CloseOverlay");
    LeadomaContainer.addClass("leadoma-overlay-off");
  });
  CloseEditTag.on("click", (e) => {
    console.log("CloseEditTag");
    EditTagModal.hide();
  });
  CloseDeleteTag.on("click", (e) => {
    console.log("CloseDeleteTag");
    DeleteTagModal.hide();
  });

  // c: opening delete tag modal on click
  const DeleteButtonListener = () => {
    OpenDeleteTag.on("click", async (e) => {
      LeadomaContainer.removeClass("leadoma-overlay-off");
      DeleteTagModal.show();
      
      let slug = $(e.currentTarget).attr("lm-open-delete-tag");
      setEditCreateDeleteTagData(slug, "delete");
    
      DeleteTagInput.val("");
      setInputError(DeleteTagInput, "", clear=true);
      DeleteTagInput.focus();
      
    });
  }

  // c: opening edit tag modal on click
  const EditButtonListener = () => {
    OpenEditTag.on("click", async(e) => {
      LeadomaContainer.removeClass("leadoma-overlay-off");
      EditTagModal.show();
      
      let slug = $(e.currentTarget).attr("lm-open-edit-tag");
      setEditCreateDeleteTagData(slug, "edit");
    
      // value will be set in setEditCreateDeleteTagData
      setInputError(EditTagInput, "", clear=true);
      EditTagInput.focus();
      
    });
  }

  // c: opening create tag modal on click
  OpenCreateTag.on("click", (e) => {
    LeadomaContainer.removeClass("leadoma-overlay-off");
    EditTagModal.show();

    setEditCreateDeleteTagData("", "create");
    
    CreateTagInput.val("");
    setInputError(CreateTagInput, "", clear=true);
    CreateTagInput.focus();
  });


  // c: setting current color on change
  $("[lm-set-current-color]").on("click", (e) => {
    color = $(e.currentTarget).attr("lm-set-current-color")
    // border = COLOR_LIST.filter(a => a.color == color)[0].border;
    border = "#000000";
    CurrentColor.html(getCurrentColorTemplate(color, border));
  });

  
  // c: user submits edit tag button
  EditTagButton.on("click", async(e) => {
    AddEditTagForm.addClass("leadoma-was-validated");
    
    const colorCode = currentColorHex;
    const title = EditTagInput.val();
    const slug = currentTag.slug
    
    // todo: more validation
    if (!title) {
      setInputError(EditTagInput, "Name cannot be empty!");
      return;
    }
    
    const data = {
      title: title,
      color_code: colorCode,
    };
    
    EditTagButton.prop('disabled', true);
    const res = await lm_edit_tag(slug, data);
    EditTagButton.prop('disabled', false);
    if (res) {
      closeModals();
      init();
    } else {
      setInputError(EditTagInput, "Error editing tag!");
      console.error("error creating tag");
    }


    // CreateTagInput.addClass("is-invalid");

    // todo: send edit request
  });

  // c: user submits the create button
  CreateTagButton.on("click", async(e) => {
    const colorCode = currentColorHex;
    const title = CreateTagInput.val();
    
    AddEditTagForm.addClass("leadoma-was-validated");
    
    // todo: more validation
    if (!title) {
      setInputError(CreateTagInput, "Name cannot be empty!");
      return;
    }
    
    const data = {
      title: title,
      color_code: colorCode,
    };

    CreateTagButton.prop('disabled', true);
    const res = await lm_create_tag(data);
    CreateTagButton.prop('disabled', false);
    if (res) {
      init();
      closeModals();
    } else {
      setInputError(CreateTagInput, "Error creating tag!");
      console.error("Leadoma Error creating tag!");
    }

  })

  // c: Delete tag input match
  DeleteTagInput.on("keyup", (e) => {
    const value = DeleteTagInput.val();
    const title = currentTag.title;
    if (title == value) {
      DeleteTagSubmit.prop('disabled', false);
    } else {
      DeleteTagSubmit.prop('disabled', true);
    }
  });

  // c: user submits the delete button
  DeleteTagSubmit.on("click", async() => {
    AddEditTagForm.addClass("leadoma-was-validated");
    
    DeleteTagSubmit.prop('disabled', true);
    const slug = currentTag.slug;
    const res = await lm_delete_tag(slug);
    DeleteTagSubmit.prop('disabled', false);
    if (res) {
      init();
      closeModals();
    } else {
      setInputError(DeleteTagInput, "Error deleting tag!");
      console.error("Leadoma: Error deleting tag!");
    }
  })


  //* RENDER FUNCTIONS
  // c: renders the list of tags
  const renderTags = (tags) => {
    const tableRows = tags.flatMap((tag, index) => {
        return (!LEADOMA_EXCLUDEEDTAGS.includes(tag.title)) ? getTagRowTemplate(tag, index) : []
    })
    
    TagsTableBody.html(tableRows)
    
    // todo: add event listeners to edit and delete again
    OpenEditTag = $("[lm-open-edit-tag]");
    EditButtonListener();
    OpenDeleteTag = $("[lm-open-delete-tag]");
    DeleteButtonListener();
  }

  const renderPagination = (max, current) => {
    $(".lm-pagination").html(getPaginationTemplate(max, current));
  }

  // c: fetching tags and calling the render function 
  const init = async (page = 1) => {
    $(".lm-pagination").html("");
    setTableLoading(TagsTableBody, TagsTableLoader, true)
    TAGS = await lm_get_list_of_tags(page);
    if (TAGS) {
      console.log(TAGS)
      renderTags(TAGS.tags)
      renderPagination(Math.ceil(TAGS.count/TAGS.page_size), page)

    } else {
      // todo: show an alert or something
      console.error("Leadoma: Error getting tags");
    }
      setTableLoading(TagsTableBody, TagsTableLoader, false)
  }
  init(1);
  
  // pagination
  $(document).on("click", (e) => {
    if (e.target.classList.contains("lm-page")) {
      const pageElement = $(e.target);
      init(pageElement.html());
    }
  });
  

})