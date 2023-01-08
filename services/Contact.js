const ContactService = {
  init: function() {
    
    // ContactService.check_token();
    ContactService.list();

  },

  check_token: function(){
    var token = localStorage.getItem("token");
    if (!token){
      // show login modal when page loads if there is no token
      $('#login-modal').modal('show');
    }
  },

  list: function(){
    $.ajax({
       url: "rest/contacts",
       type: "GET",
       beforeSend: function(xhr){
         xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
       },
       success: function(data) {
         $("#note-list").html("");
         var html = "";
         for(let i = 0; i < data.length; i++){
           html += `
            <div id="contact-`+data[i].id+`" name="Contact Item" class="card btn text-start mb-1" style="background-color: azure;">
              <div class="card-body py-2 px-0">
                <div class="container">
                  <div class="row">
                    <div class="col">
                      <p class="fs-5 mb-1">`+data[i].first_name+` `+data[i].last_name+`</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           `;
         }
         $("#contact-list-col").html(html);
         console.log(data);
       },
       error: function(XMLHttpRequest, textStatus, errorThrown) {
         toastr.error(XMLHttpRequest.responseJSON.message);
         ContactService.logout();
       }
    });
  },

};

// Call the init function when the page loads
window.addEventListener('load', () => {
  ContactService.init();
});
