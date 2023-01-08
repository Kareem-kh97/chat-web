const MessageService = {
  init: function() {
    MessageService.get_messages(5);
  },

  get_messages: function(contactId){
    
    $.ajax({
      url: "rest/contacts/"+contactId,
      type: "GET",
      beforeSend: function(xhr){
        xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      },
      success: function(data) {
        // $("#note-list").html("");
        // var html = "";
        // for(let i = 0; i < data.length; i++){
        //   html += `
        //    <div id="contact-`+data[i].id+`" name="Contact Item" class="card btn text-start mb-1" style="background-color: azure;">
        //      <div class="card-body py-2 px-0">
        //        <div class="container">
        //          <div class="row">
        //            <div class="col">
        //              <p class="fs-5 mb-1">`+data[i].first_name+` `+data[i].last_name+`</p>
        //            </div>
        //          </div>
        //        </div>
        //      </div>
        //    </div>
        //   `;
        // }
        // $("#contact-list-col").html(html);
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
  MessageService.init();
});
