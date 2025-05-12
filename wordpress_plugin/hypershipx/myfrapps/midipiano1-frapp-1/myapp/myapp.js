


var myxcustom = {
  API_URL: 'http://wazu.local/wp-json/hypershipx/v1/appmidipiano1',

  mytest1: function () {
    alert("mytest1");
  },

  xlogin: function (xemail, xusername, xpassword) {
    $.ajax({
      url: xapp.xcustom.API_URL + '/home-info',
      type: 'POST',
      data: { email: xemail, username: xusername, password: xpassword },
      success: function (response) {
        // $('#app-page').html(response);
        localStorage.setItem('token', response.token);
        // window.location.reload();
        $('#app-page').trigger('load');
      },
      error: function (response) {
        console.log(response);
      }
    });
  }

}

var xapp = new App(myxcustom);

