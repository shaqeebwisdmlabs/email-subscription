jQuery(document).ready(function ($) {
  $("#subscription-form").on("submit", (e) => {
    e.preventDefault();
    const email = $("#email").val();
    let error = false;
    if (!email) {
      $("#email").addClass("error");
      $("#error-message").text("*Email is required!");
      error = true;
    } else if (!isValidEmail(email)) {
      $("#email").addClass("error");
      $("#error-message").text("*Email is not valid!");
      error = true;
    } else {
      $("#email").removeClass("error");
      $("#error-message").text("");
      error = false;
    }

    if (!error) {
      $.ajax({
        url: ajax_url.ajaxurl,
        type: "POST",
        data: {
          action: "wsdm_email_subscription",
          email: email,
        },
        success: function (response) {
          console.log(response);
          $("#subscription-message").text(response.data.message);
        },
        error: function (error) {
          console.log(error);
          $("#subscription-message").text(error.data.message);
        },
      });
    }
  });
});

const isValidEmail = (email) => {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
};
