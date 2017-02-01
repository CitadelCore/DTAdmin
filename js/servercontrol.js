var dataTimer = setInterval(postReady, 1000);
var loadCount = 0;

function postReady(){
  $.post('server/backend.php', {command: 'ISREADY'}, function(returnedData) {
    if (returnedData == "410A") {
     console.log("Backend is ready.");
     clearInterval(dataTimer);
     backendReady = true;
     $('#loadModal').modal('hide');
     $('#login-modal').modal('show');
    } else if (returnedData == "420A") {
     console.log("Backend is currently unavailable.");
     clearInterval(dataTimer);
     backendReady = false;
    } else if (returnedData == "430A") {
     console.log("Backend is currently down for maintenance.");
     clearInterval(dataTimer);
     backendReady = false;
    } else {
     if (loadCount <= 5) {
     console.log("Connection to backend failed, retrying...");
     loadCount = loadCount+1;
     backendReady = false;
     } else {
     console.log("Max retries reached, aborting connection.");
     clearInterval(dataTimer);
     backendReady = false;
     }
    }
  });
}

function submitCredentials(){
$('#login-modal').modal('hide');
$('#progressModal').modal('show');
var user = document.forms["loginform"]["userid"].value;
var pass = document.forms["loginform"]["password"].value;
var pass = sha512(pass);
var usernameerrorblock = document.getElementById("username-error-block");
var passworderrorblock = document.getElementById("password-error-block");
var loginerrorblock = document.getElementById("login-error-block");
var usernamestatusblock = document.getElementById("username-status-block");
var passwordstatusblock = document.getElementById("password-status-block");
var loginstatusblock = document.getElementById("login-status-block");
setTimeout(function(){
$.post('server/backend.php', {command: 'CREDPAYLOAD', userid: user, password: pass}, function(returnedData) {
if (returnedData == "510A") {
  //Logged in
  $('#progressModal').modal('hide');
  console.log("DEVELOPER: Logged in");
  window.location.href = "panel.php";
} else if (returnedData == "520A") {
passworderrorblock.innerHTML = "<p style='color:red'>Please try your password again.</p>";
usernameerrorblock.innerHTML = "";
loginerrorblock.innerHTML = "";

passwordstatusblock.className = "form-group has-warning";
usernamestatusblock.className = "form-group";
loginstatusblock.className = "form-group";
  setTimeout(function(){
  $('#progressModal').modal('hide');
  $('#login-modal').modal('show');
}, 1000);
  // Incorrect password
} else if (returnedData == "530A") {
  usernameerrorblock.innerHTML = "<p style='color:red'>Please try your username again.</p>";
  passworderrorblock.innerHTML = "";
  loginerrorblock.innerHTML = "";
  setTimeout(function(){
  $('#progressModal').modal('hide');
  $('#login-modal').modal('show');
}, 1000);
  // Incorrect username
} else if (returnedData == "540A") {
  loginerrorblock.innerHTML = "<p style='color:red'>There is a problem with your account.</p> <p style='color:red'>Please contact TOWER support.</p>";
  usernameerrorblock.innerHTML = "";
  passworderrorblock.innerHTML = "";
  setTimeout(function(){
  $('#progressModal').modal('hide');
  $('#login-modal').modal('show');
}, 1000);
  // Special characters in password
} else if (returnedData == "560A") {
passworderrorblock.innerHTML = "<p style='color:red'>Special characters are not allowed in passwords.</p>";
usernameerrorblock.innerHTML = "";
loginerrorblock.innerHTML = "";
  setTimeout(function(){
  $('#progressModal').modal('hide');
  $('#login-modal').modal('show');
}, 1000);
 // Special characters in username
} else if (returnedData == "560B") {
passworderrorblock.innerHTML = "";
usernameerrorblock.innerHTML = "<p style='color:red'>Special characters are not allowed in usernames.</p>";
loginerrorblock.innerHTML = "";
  setTimeout(function(){
  $('#progressModal').modal('hide');
  $('#login-modal').modal('show');
}, 1000);
  // Other
} else {
  loginerrorblock.innerHTML = "<p style='color:red'>An internal server error occured.</p> Please contact TOWER support.";
  usernameerrorblock.innerHTML = "";
  passworderrorblock.innerHTML = "";
  console.log("DEVELOPER: Internal error");
  //console.log(returnedData);
  // Internal error
}
});
}, 1000);
}
