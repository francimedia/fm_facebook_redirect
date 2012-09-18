<?php

require_once(dirname(__FILE__)).'/facebook-sdk/src/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => 'xxx',
  'secret' => 'yyy',
));         

// invoke redirect from apps.facebook.com to www.facbeook.com/page_url
$redirect_to_facebook_frame = 0;

if(isset($_POST['signed_request']) && $_POST['signed_request']) {
    $signed_request = $this->_facebook->getSignedRequest();
    $page_data = is_array($signed_request) && array_key_exists('page', $signed_request) ? $signed_request['page'] : false;
    if($page_data == false) {
        $redirect_to_facebook_frame = 1;
    }
}

?><html>
    <head>

        <title>My Page title</title>

       <script type="text/javascript">

            function isMobile() {
                var ua = (window.navigator && navigator.userAgent) || ""; 

                if ((/FBForIPhone/).test(ua) || (/Android/).test(ua)) {
                    return true;
                }  

                if ((/iPad/).test(ua)) {
                    return false;
                }

                if (window.outerWidth < 540) {
                    return true;
                } else {
                    return false;
                }
            }

            function inFacebook() {
                return window.location != top.location ? true : false;
            }

            var fbRedirect = {
                url: 'https://www.facebook.com/FacebookDevelopers', // your target url
                skip: false, // change this value using PHP if you have a special case to disable the redirect
                active: false,
                force_redirect: <?php echo $redirect_to_facebook_frame; ?>
            };

            if (fbRedirect.skip == false && isMobile() == false && (inFacebook() == false || fbRedirect.force_redirect == 1) ) {
                top.location = fbRedirect.url.+'&app_data=location|'+window.location.pathname+escape(window.location.search);
                fbRedirect.active = true;
            }    

        </script>

    </head>

        <body>

            <script type="text/javascript">
            // hide the body if a redirect is active. This will: 1. speed up the redirect as no images are loaded, 2. Prevent broken images (happens on Safari+SSL+JS redirect during page load)
            if(fbRedirect.active == true) {
                document.body.style.display = 'none';
            }
            </script>

        </body>

</html>