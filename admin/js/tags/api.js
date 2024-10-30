const lm_get_list_of_tags = async (page) => {
  try {
    const res = await jQuery.ajax({
      "type": "GET",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_list_of_tags",
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
const lm_create_tag = async (data) => {
  try {
    const res = await jQuery.ajax({
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_create_tag",
        "data": data,
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
const lm_edit_tag = async (slug, data) => {
  try {
    const res = await jQuery.ajax({
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_edit_tag",
        "slug": slug,
        "data": data,
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
const lm_delete_tag = async (slug) => {
  try {
    const res = await jQuery.ajax({
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_delete_tag",
        "slug": slug,
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
//! not used yet
const lm_add_tags_to_customers = async (data) => {
  try {
    const res = await jQuery.ajax({
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_add_tags_to_customers",
        "data": data,
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
const lm_update_customer_tags = async (code, data) => {
  try {
    const res = await jQuery.ajax({
      "type": "POST",
      "url": ajaxurl,
      "data": {
        "action": "leadoma_update_customer_tags",
        "data": data,
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