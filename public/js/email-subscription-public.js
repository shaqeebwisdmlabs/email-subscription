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
    }
  });
});

const isValidEmail = (email) => {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
};
