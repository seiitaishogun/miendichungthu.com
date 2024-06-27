/*
Customization and settings for the Capture Widget.
*/
window.addEventListener('DOMContentLoaded', function (event) {
    window.DigitalIdentityHub.addModule({
        name: 'Web',
        init: function() {
            janrain.settings.capture.federateXdReceiver = '';
            janrain.settings.capture.federateLogoutUri = '';
            janrain.settings.capture.federateLogoutCallback = function() {};
            janrain.settings.capture.redirectUri = 'https://miendichungthu.com/'; // insert real domain URL, localhost can be used only for local testing
            // janrain.settings.capture.redirectUri = 'http://miendichungthu.cnv.vn/';
            window.DigitalIdentityHub.settings.enableFrontEndDeeplinking = false;
        },
        ready: function() {
        janrain.events.onCaptureLoginSuccess.addHandler(setWindowAfterLogin);
        janrain.events.onCaptureRegistrationSuccess.addHandler(setWindowAfterRegistration);
        janrain.events.onCaptureRegistrationSuccessNoLogin.addHandler(setWindowAfterRegistrationNoLogin);
        janrain.events.onCaptureSessionEnded.addHandler(setNavigationForLoggedOutUser);
        janrain.events.onCaptureExpiredToken.addHandler(setNavigationForLoggedOutUser);
        janrain.events.onCaptureAccessDenied.addHandler(setNavigationForLoggedOutUser);
        // janrain.events.onCaptureSessionFound.addHandler(setUserFirstName);
        },
    });
    function setWindowAfterLogin(result) {
        console.log('redirecting');
        const userData = JSON.parse(localStorage.getItem('janrainCaptureProfileData'));
        setCookie('user', JSON.stringify(userData), 365);
        window.location.href = "/";
        // window.location.href = '?screenToRender=editProfile';
        // if user isn't logged in already
        // create server session (call /jumpcontroller on M-C)
        // then redirect to home page
        // window.location = "home.html"
    }
    function setWindowAfterRegistration(result) {
        // console.log('redirecting');
        // window.location.href = '?screenToRender=editProfile';
        // window.location = "home.html"
    }
    function setWindowAfterRegistrationNoLogin(result) {
        // console.log('redirecting');
        // window.location.href = '?screenToRender=editProfile';
        // window.location = "thank_you.html"
    }
    function setNavigationForLoggedOutUser(result) {
        // window.location.href = 'index.html';
        // window.location = "loggedout.html"
    }
    function setUserFirstName(result) {
        // const userData = JSON.parse(localStorage.getItem('janrainCaptureProfileData'));
        // document.getElementById('welcomeMessage').innerText = userData.givenName;
    }
    window.DigitalIdentityHub.start();
});