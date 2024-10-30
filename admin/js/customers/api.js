const lm_get_list_of_customers = async (page=1) => {
  try {
    const res = await jQuery.ajax({
      "type": "GET",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_list_of_customers",
        "page": page,
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}
const lm_update_customer = async (code, data) => {
  try {
    const res = await jQuery.ajax({
      "type": "GET",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_update_customer",
        "data": data,
        "code": code,
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}
const lm_update_customer_additional = async (code, data) => {
  try {
    const res = await jQuery.ajax({
      "type": "GET",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_update_customer_additional",
        "data": data,
        "code": code,
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}

const lm_get_customer = async (code) => {
  try {
    const res = await jQuery.ajax({
      "type": "GET",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_get_customer",
        "data": {},
        "code": code
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}
const lm_get_customer_activities = async (code) => {
  try {
    const res = await jQuery.ajax({
      "type": "GET",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_get_customer_activities",
        "data": {},
        "code": code
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}

const lm_get_customer_notes = async (code) => {
  try {
    const res = await jQuery.ajax({
      "type": "GET",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_get_customer_notes",
        "data": {},
        "code": code
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}
const lm_add_customer_note = async (code, text) => {
  try {
    const res = await jQuery.ajax({
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_add_customer_note",
        "text": text,
        "code": code,
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}

const lm_delete_customer = async (code) => {
  try {
    const res = await jQuery.ajax({
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_delete_customer",
        "code": code,
        "data": {},
      }
    });
    if (res.status == 200 || res.status == 201) {
      return res.body;
    } else {
      console.log("something went wrong");
    }
  } catch (err) {
    console.log(err);
  }
  return false;
}