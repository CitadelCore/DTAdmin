function confirmProfileCreateForm() {
  var username = document.forms["profilecreate"]["username"].value;
  var formemail = document.forms["profilecreate"]["email"].value;
  var formfirstname = document.forms["profilecreate"]["firstname"].value;
  var formlastname = document.forms["profilecreate"]["lastname"].value;
  var password = sha512(document.forms["profilecreate"]["password"].value);
  var passwordconfirm = sha512(document.forms["profilecreate"]["passwordconfirm"].value);
  var invitekey = document.forms["profilecreate"]["invitekey"].value;
  if (password == passwordconfirm) {
    if (invitekey.length > 10) {
      $.post('server/backend.php', {command: 'CREATEUSERPROFILE', username: username, email: formemail, firstname: formfirstname, lastname: formlastname, passwordhash: password, invitecode: invitekey}, function(returnedData) {
       if (returnedData == "210A") {
        window.location.href = "login.php?signoutreason=Your+account+has+been+created.+Please+check+your+email+for+further+instructions.";
       } else if (returnedData == "830A") {
        createerrorblock.innerHTML = "<p style=\"color:red\">An error occured while creating your account. Please double-check your entered information.</p>";
       } else if (returnedData == "810A") {
        createerrorblock.innerHTML = "<p style=\"color:red\">The invite key you entered has expired. Please enter a valid invite key.</p>";
       } else if (returnedData == "820A") {
        createerrorblock.innerHTML = "<p style=\"color:red\">The invite key you entered is invalid. Please enter a valid invite key.</p>";
       } else {
        createerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
       }
     })
    } else {
      $.post('server/backend.php', {command: 'CREATEUSERPROFILE', username: username, email: formemail, firstname: formfirstname, lastname: formlastname, passwordhash: password}, function(returnedData) {
       if (returnedData == "210A") {
        $('#passwordConfirmModal').modal('hide');
        window.location.href = "login.php?signoutreason=Your+account+has+been+created.+Please+check+your+email+for+further+instructions.";
       } else if (returnedData == "830A") {
        createerrorblock.innerHTML = "<p style=\"color:red\">An error occured while creating your account. Please double-check your entered information.</p>";
       } else {
        createerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
       }
     })
    }
  } else {
    createerrorblock.innerHTML = "<p style=\"color:red\">The passwords do not match.</p>";
  }
}
