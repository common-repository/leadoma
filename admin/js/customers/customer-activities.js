//* TEMPLATES

const getCustomerActivitiesTemplate = (activities) => `
${
  activities.map((activity, index) =>
    `<div class="d-flex align-items-center all-activities_activity p-3 px-0">
      <span class="text-color-lightgray pe-2 pe-md-3 pe-xl-4 no-wrap">${lm_format_date_short(activity.created_at)}</span>
      <span class="activities-timeline"></span>
      <p class="mb-0 font-16 ps-2 ps-md-3 ps-xl-4">${activity.activity_data?.description?.replace(/\\"/g, '"').replace(/\\'/g, "'")}</p>
    </div>`

    
  ).join("")
}
`
let CUSTOMER_ACTIVITIES = {};

jQuery(() => {
  let $ = jQuery;

  //* ELEMENTS
  const LeadomaContainer = $(".leadoma");

  const CloseOverlay = $("[lm-close-overlay] , [lm-overlay]");

  // activities
  const customerActivitiesContainer = $("[lm-all-activities-container]")


  //* FUNCTIONS
  const closeModals = () => {
    LeadomaContainer.addClass("leadoma-overlay-off");
  }

  //* EVENT LISTENERS
  CloseOverlay.on("click", (e) => {
    console.log("CloseOverlay");
    LeadomaContainer.addClass("leadoma-overlay-off");
  });


  //* RENDER

  // render customer activities
  const renderCustomerActivities = (activities) => {
    customerActivitiesContainer.html(getCustomerActivitiesTemplate(activities))
  }


  
  const init = async() => {
    const code = leadomaGetParam("id");
    const customerImage = leadomaGetParam("image");// we don't have it yet
    const customerLevel = leadomaGetParam("level");
    const customerName = leadomaGetParam("name");
    $("[lm-customer-name]").html(customerName);
    $("[lm-bi-level]").html(customerLevel);
    
    LeadomaContainer.addClass("lm-loading")
    // todo: refactor
    res = await lm_get_customer_activities(code);
    if (res) {
      CUSTOMER_ACTIVITIES = res;
      console.log(CUSTOMER_ACTIVITIES)
      renderCustomerActivities(CUSTOMER_ACTIVITIES.activities);
      
    } else {
      // todo: show an alert or something
      console.error("Leadoma: Error getting customer's activities");
    }
    LeadomaContainer.removeClass("lm-loading")
    
  }

  init();

})
