const UserService = {
  init: function() {
    
    UserService.check_token();

    // validate the login form inside the login modal
    $('#login-form').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        $('#login-modal-spinner').show()
        UserService.login(entity);
      }
    });
  },

  check_token: function(){
    var token = localStorage.getItem("token");
    if (!token){
      // show login modal when page loads if there is no token
      $('#login-modal').modal('show');
    }
  },

  login: function(entity){    
    $.ajax({
      url: 'rest/login',
      type: 'POST',
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        console.log(result);
        localStorage.setItem("token", result.token);
        // hide the modal
        $('#login-modal').modal('hide');
        // hide the modal spinner
        $('#login-modal-spinner').hide();
        // setup contacts and account info
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        // hide the modal spinner
        $('#login-modal-spinner').hide();
      }
    });
  },

  logout: function(){
    localStorage.clear();
    location.reload();
  },

};

// Call the init function when the page loads
window.addEventListener('load', () => {
  UserService.init();
});
