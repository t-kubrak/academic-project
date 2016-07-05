window.fbAsyncInit = function() {
  FB.init({
    appId: '767562826713610',
    cookie: true, // This is important, it's not enabled by default
    version: 'v2.2',
    xfbml      : true,  // parse social plugins on this page
  });
};

(function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

// -- JS Login button -- //

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
  FB.api('/me',  {fields: "id,about,age_range,picture,bio,birthday,context,email,first_name,gender,hometown,link,location,middle_name,name,timezone,website,work"}, function(response) {
/*    console.log('Successful login for: ' + response.name);
    console.log(response);*/
    if (response && !response.error) {
     /* document.getElementById('status').innerHTML =
              'Thanks for logging in, ' + response.name + '!' + response.email + " " + response.age_range.min;*/
      window.location.replace("fb-login/login.php");
    }
  });
}

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
  console.log('statusChangeCallback');
  console.log(response);
  // The response object is returned with a status field that lets the
  // app know the current login status of the person.
  // Full docs on the response object can be found in the documentation
  // for FB.getLoginStatus().
  if (response.status === 'connected') {
    // Logged into your app and Facebook.
    /*console.log(response.authResponse.accessToken);*/
    testAPI();
  } else if (response.status === 'not_authorized') {
    // The person is logged into Facebook, but not your app.
    /*document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';*/
  } else {
    // The person is not logged into Facebook, so we're not sure if
    // they are logged into this app or not.
    /*document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';*/
    /*window.location.replace("home.php");*/
  }
}

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}

/*window.onload = function() {
  if(document.getElementById("fb_login") != null){
    document.getElementById("fb_login").addEventListener("click", checkLoginState);
  }
  if(document.getElementById("fb_signup") != null){
    document.getElementById("fb_signup").addEventListener("click", checkLoginState);
  }
};*/


