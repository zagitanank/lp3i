(function () {
  var primary = localStorage.getItem("primary") || "#0066FF";
  var secondary = localStorage.getItem("secondary") || "#4350B9";

  window.CubaAdminConfig = {
    // Theme Primary Color
    primary: primary,
    // theme secondary color
    secondary: secondary,
  };
})();
