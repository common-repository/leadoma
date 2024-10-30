
const leadomaRedirectTo = (page, params={}) => {
  let url = new window.URL(document.location);
  url.searchParams.set('page', page)
  Object.keys(params).map((item) => {
    url.searchParams.set(item, params[item])
  })
  // window.location.replace(url.toString());
  window.open(url.toString(), "_self")
}

const leadomaGetParam = (name) => {
  let url = new window.URL(document.location);
  const param = url.searchParams.get(name)
  return param;
}

jQuery("input[type=email], input[type=password], input[type=text]").on("change", e => {
  jQuery(e.target).removeClass("is-invalid");
});

const leadoma_auth_test = async () => {
  jQuery.post(
    ajaxurl,
    {
      "action": "leadoma_test",
      "data": {
        test:"none"
      }
    },
    function (res) {
      if (res.status == 200) {
        jQuery("#temp_info").html(`
        <p class="mt-2 mb-1 font-14 fw-bold">Authorized</p>
        `);
      }
      else { 
        jQuery("#temp_info").html(`
        <p class="mt-2 mb-1 font-14 fw-bold">Unauthorized</p>
        
        `)

      }
    }
  )
} 

const leadoma_auth_logout = async () => {
  const res = await jQuery.ajax(
    {
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_logout",
        "data": {},
      }
    }
  );

  if (res.status == 200) {
    jQuery("#temp_info").html(`        
      <p class="mt-2 mb-1 font-14 fw-bold">Logged out</p>
    `);
  }
  return;
}

const logoutAndRedirect = async () => {
  await leadoma_auth_logout();
  leadomaRedirectTo('leadoma-login')
}

const lm_format_date = (date) => new Date(date).toLocaleString("en-GB", { year: 'numeric', month: 'numeric', day: 'numeric', 'hour':"2-digit", "minute":"2-digit" })
const lm_format_date_short = (date) => new Date(date).toLocaleString("en-CA", { year: 'numeric', month: 'numeric', day: 'numeric' }).replaceAll("/","-")

// const lmGetPhoneNumber = ()=>

const setInputError = (input, error="", clear=false) => {
  // input is a jQuery selected element
  input.closest('div').find(".form-helper-text").html(error)
  if (clear) {
    input.removeClass("is-invalid");
  } else {
    input.addClass("is-invalid");
  }
}

const setTableLoading = (tableBody, loader, state=true) => {
  if (state) {
    tableBody.hide()
    loader.show()
  } else {
    tableBody.show()
    loader.hide()
  }
}

const sendEmailVerificationRequest = async(elem) => {
  jQuery(elem).prop('disabled', true)
  const res = await jQuery.ajax(
    {
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_email_verification_request",
        "data": {},
      }
    }
  );

  if (res.status == 200 || res.status == 409) {
    jQuery(elem).prop('disabled', true)
    jQuery(elem).text("Email sent")
  } else {
    jQuery(elem).prop('disabled', false)
  }
  return;
}


const leadomaSyncUnsuncedCustomers = () => {
  // 
  try{
  // change button text to syncing users and disable it
  // submit.prop('disabled', true);
  jQuery(".lm-sync").hide()
  jQuery(".lm-syncing").show()
  jQuery.post(
    ajaxurl,
    {
      "action": "leadoma_sync_unsynced_customer",
      "data": null,
    },
    function (res) {
      console.log("hereeeeee");
      if (res.status == 200 || res.status == 201) {
        console.log("Syncing customers");
        jQuery(".lm-syncing").show()
      }
      else if (res.status == 401) {
        console.log("unauthorized");
        jQuery(".lm-sync").show()
        jQuery(".lm-syncing").hide()
      } else {
        console.log("something went wrong");
        jQuery(".lm-sync").show()
        jQuery(".lm-syncing").hide()
      }
    }
  )

} catch (err) {
  console.log(err);
}
}