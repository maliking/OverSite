<h2>My platform</h2>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '177243886462061',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v3.0'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  function myFacebookLogin(){
  	FB.login(function(response){
  		console.log("Successfully logged in", response);
  	}, {scope: 'manage pages'});
  }

</script>

<button onstick="myFacebookLogin()">Login with Facebook</button>