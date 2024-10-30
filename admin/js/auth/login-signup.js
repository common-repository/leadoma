const changeStateTo = (newState) => {
  let $ = jQuery;
  const authForms = $("#auth-forms");
  if (newState == "login") {
    authForms.removeClass("signup-state");
    authForms.addClass("login-state");
    authForms.removeClass("reset-state");
    $(".login-tab").addClass("active");
    $(".signup-tab").removeClass("active");
  }
  if (newState == "signup") {
    authForms.removeClass("login-state");
    authForms.addClass("signup-state");
    authForms.removeClass("reset-state");
    $(".login-tab").removeClass("active");
    $(".signup-tab").addClass("active");
  }
  if (newState == "reset") {
    authForms.removeClass("login-state");
    authForms.removeClass("signup-state");
    authForms.addClass("reset-state");
  }
};

const changeStepTo = (newStep) => {
  let $ = jQuery;
  const welcomeAuth = $(".lm-welcome-auth"); //welcome-step, auth-step, email-step

  if (newStep == "auth") {
    welcomeAuth.removeClass("welcome-step");
    welcomeAuth.addClass("auth-step");
    welcomeAuth.removeClass("verify-step");

    $(".auth-tab").addClass("active");
    $(".welcome-tab").removeClass("active");
  }
  if (newStep == "welcome") {
    welcomeAuth.addClass("welcome-step");
    welcomeAuth.removeClass("auth-step");
    welcomeAuth.removeClass("verify-step");

    $(".auth-tab").removeClass("active");
    $(".welcome-tab").addClass("active");
  }
  if (newStep == "verify") {
    welcomeAuth.removeClass("welcome-step");
    welcomeAuth.removeClass("auth-step");
    welcomeAuth.addClass("verify-step");

    $(".auth-tab").addClass("active");
    $(".welcome-tab").removeClass("active");
  }
};

let leadomaEmailSentSuccessfully = () => {
  let $ = jQuery;
  $(".leadoma-login").hide();
  $(".email-sent").show();
};

const leadomaHandleAcceptCloudNotice = () => {
  const $ = jQuery;
  try {
    // close modal
    $(".leadoma-cloud-notice").hide();
    $(".lm-login-form").closest("form").find(":submit").prop("disabled", false);
    $(".lm-signup-form")
      .closest("form")
      .find(":submit")
      .prop("disabled", false);

    $.post(
      ajaxurl,
      {
        action: "leadoma_cloud_notice",
      },
      function (res) {
        if (res.status == 200) {
          console.log("cloud");
        } else {
          console.log("not cloud");
        }
      }
    );
  } catch (err) {
    console.log(err);
  }
};

jQuery(() => {
  let $ = jQuery;
  $("input[type=email], input[type=password], input[type=text]").on(
    "change",
    (e) => {
      $(e.target).removeClass("is-invalid");
    }
  );

  $(".lm-login-form").on("submit", async (e) => {
    e.preventDefault();

    const form = $(e.target);
    form.addClass("leadoma-was-validated");
    const submit = form.closest("form").find(":submit");

    const email = $(e.target.elements["login_email_address"]);
    const password = $(e.target.elements["login_password"]);

    if (!email.is(":valid") || !password.is(":valid")) {
      return;
    }

    const data = {
      username: email.val(),
      password: password.val(),
    };

    try {
      submit.prop("disabled", true);
      $.post(
        ajaxurl,
        {
          action: "leadoma_login",
          data: data,
        },
        function (res) {
          if (res.status == 200 || res.status == 201) {
            console.log("logged in successfully", "should redirect...");
            leadomaRedirectTo("leadoma");
          } else if (res.status == 401) {
            console.log("unauthorized");
            email.addClass("is-invalid");
            password.addClass("is-invalid");
          } else {
            console.log("something went wrong");
            email.addClass("is-invalid");
            password.addClass("is-invalid");
          }
          submit.prop("disabled", false);
        }
      );
    } catch (err) {
      console.log(err);
      submit.prop("disabled", false);
    }
  });

  $(".lm-signup-form").on("submit", async (e) => {
    e.preventDefault();
    console.log("signup submitted", e);

    const form = $(e.target);
    form.addClass("leadoma-was-validated");

    const submit = form.closest("form").find(":submit");

    const fullname = $(e.target.elements["signup_fullname"]);
    const email = $(e.target.elements["signup_email_address"]);
    const password = $(e.target.elements["signup_password"]);
    console.log(fullname, email, password);
    // validate fields...
    if (
      !fullname.is(":valid") ||
      !email.is(":valid") ||
      !password.is(":valid")
    ) {
      return;
    }

    const data = {
      full_name: fullname.val(),
      email: email.val(),
      password: password.val(),
    };

    try {
      email.removeClass("is-invalid");
      password.removeClass("is-invalid");

      submit.prop("disabled", true);
      $.post(
        ajaxurl,
        {
          action: "leadoma_signup",
          data: data,
        },
        function (res) {
          if (res.status == 200 || res.status == 201) {
            console.log(
              "successfully signed up and logged in",
              "redirecting..."
            );
            changeStepTo("verify");
          } else if (res.status == 409 || res.status == 400) {
            email.addClass("is-invalid");
            email
              .closest("div")
              .find(".form-helper-text")
              .html("User already exists");
          } else if (res.status == 422) {
            password.addClass("is-invalid");
            const errorText = res.body?.detail[0].msg;
            password.closest("div").find(".form-helper-text").html(errorText);
          } else {
            email.addClass("is-invalid");
            email
              .closest("div")
              .find(".form-helper-text")
              .html("Something went wrong");
            console.log("something went wrong");
          }
          submit.prop("disabled", false);
        }
      );
    } catch (err) {
      console.log(err);
      submit.prop("disabled", false);
      //todo: show some error
    }
  });

  $(".lm-reset-form").on("submit", async (e) => {
    e.preventDefault();

    const form = $(e.target);
    form.addClass("leadoma-was-validated");
    const submit = form.closest("form").find(":submit");

    const email = $(e.target.elements["login_email_address"]);

    if (!email.is(":valid")) {
      return;
    }

    const data = {
      email: email.val(),
    };

    try {
      submit.prop("disabled", true);
      $.post(
        ajaxurl,
        {
          action: "leadoma_req_reset_password",
          data: data,
        },
        function (res) {
          if (res.status == 200 || res.status == 201) {
            changeStepTo("verify");
          } else if (res.status == 404) {
            email.addClass("is-invalid");
            email
              .closest("div")
              .find(".form-helper-text")
              .html(res.body.detail);
          } else {
            email
              .closest("div")
              .find(".form-helper-text")
              .html("something went wrong");
            email.addClass("is-invalid");
          }
          submit.prop("disabled", false);
        }
      );
    } catch (err) {
      console.log(err);
      submit.prop("disabled", false);
    }
  });
});
