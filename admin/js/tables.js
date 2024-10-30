jQuery(function () {
  //button select all or cancel
  jQuery("#select-all").click(function () {
    var all = jQuery("input.select-all")[0];
    all.checked = !all.checked
    var checked = all.checked;
    jQuery("input.select-item").each(function (index, item) {
      item.checked = checked;
    });
  });
  //column checkbox select all or cancel
  jQuery("input.select-all").click(function () {
    var checked = this.checked;
    jQuery("input.select-item").each(function (index, item) {
      item.checked = checked;
    });
  });
  //check selected items
  jQuery("input.select-item").click(function () {
    var checked = this.checked;
    var all = jQuery("input.select-all")[0];
    var total = jQuery("input.select-item").length;
    var len = jQuery("input.select-item:checked:checked").length;
    all.checked = len === total;
  });

});