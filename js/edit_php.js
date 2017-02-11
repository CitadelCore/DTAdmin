function submitCreateForm() {
var servername = document.forms["newserver"]["servername"].value;
var serverip = document.forms["newserver"]["serverip"].value;
var dtqueryport = document.forms["newserver"]["dtqueryport"].value;
var dtquerysecret = document.forms["newserver"]["dtquerysecret"].value;
var rconport = document.forms["newserver"]["rconport"].value;
var rconpassword = document.forms["newserver"]["rconpassword"].value;
//var servergame = document.forms["newserver"]["servergame"].value;
var servergame = "Garry's Mod";
var servergamemode = document.forms["newserver"]["servergamemode"].value;
//var serveradminsystem = document.forms["newserver"]["serveradminsystem"].value;
var serveradminsystem = "ULX";
var steamid = document.forms["newserver"]["steamid"].value;
$.post('server/backend.php', {command: 'NEWSERVER', servername: servername, serverip: serverip, dtqueryport: dtqueryport, dtquerysecret: dtquerysecret, rconport: rconport, rconpassword: rconpassword, servergame: servergame, servergamemode: servergamemode, serveradminsystem: serveradminsystem, steamid: steamid}, function(returnedData) {
});
}

function submitProfileEditForm() {
  $('#passwordConfirmModal').modal('show');
}

function confirmProfileEditForm() {
  var formemail = document.forms["profileedit"]["email"].value;
  var formfirstname = document.forms["profileedit"]["firstname"].value;
  var formlastname = document.forms["profileedit"]["lastname"].value;
  var passconfirm = sha512(document.forms["checkpointForm"]["cppassword"].value);
  $.post('server/backend.php', {command: 'UPDATEUSERPROFILE', email: formemail, firstname: formfirstname, lastname: formlastname, passconfirm: passconfirm}, function(returnedData) {
   if (returnedData == "210A") {
    $('#passwordConfirmModal').modal('hide');
    location.reload();
   } else if (returnedData == "570A") {
    cperrorblock.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
   } else if (returnedData == "580A") {
    cperrorblock.innerHTML = "<p style=\"color:red\">Incorrect password.</p>";
   } else {
    cperrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
   }
 })
}

function submitAccountDeleteForm() {
  confirmAccountDeleteForm();
}

function confirmAccountDeleteForm() {
  var deleteusername = document.forms["accountDeleteForm"]["deleteusername"].value;
  var deletepassword = sha512(document.forms["accountDeleteForm"]["deletepassword"].value);
  $.post('server/backend.php', {command: 'DELETEUSERPROFILE', deleteusername: deleteusername, deletepassword: deletepassword}, function(returnedData) {
    if (returnedData == "210A") {
     $('#passwordConfirmModal').modal('hide');
     window.location.href = "login.php?signoutreason=Your+account+has+been+deleted.";
    } else if (returnedData == "570A") {
     removeerrorblock.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
    } else if (returnedData == "580A") {
     removeerrorblock.innerHTML = "<p style=\"color:red\">Incorrect password.</p>";
    } else if (returnedData == "710A") {
    removeerrorblock.innerHTML = "<p style=\"color:red\">Incorrect username.</p>";
    } else {
     removeerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
    }
  })
}

function openPasswordChangeModal() {
  $('#passwordChangeModal').modal('show');
}

function submitPasswordChange() {
  var oldpassword = sha512(document.forms["passwordChangeForm"]["oldpassword"].value);
  var newpassword = sha512(document.forms["passwordChangeForm"]["newpassword"].value);
  var newpasswordconfirm = sha512(document.forms["passwordChangeForm"]["newpasswordconfirm"].value);
  if (newpassword == newpasswordconfirm) {
    $.post('server/backend.php', {command: 'UPDATEUSERPROFILE', passwordhash: newpassword, passconfirm: oldpassword}, function(returnedData) {
     if (returnedData == "210A") {
      $('#passwordConfirmModal').modal('hide');
      location.reload();
     } else if (returnedData == "570A") {
      changeerrorblock.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
     } else if (returnedData == "580A") {
      changeerrorblock.innerHTML = "<p style=\"color:red\">Incorrect password.</p>";
     } else {
      changeerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
     }
   })
  } else {
    changeerrorblock.innerHTML = "<p style=\"color:red\">The passwords don't match.</p>";
  }
}

function openAccountDeleteModal() {
  $('#accountDeleteModal').modal('show');
}

function resetCreateForm() {

}

function deleteSecretKeyConfirm() {
deleteerrorblock.innerHTML = "";
$('#keyDeleteModal').modal('show');
}

function keyCreateFormModal() {
createerrorblock.innerHTML = "";
$('#keyCreateModal').modal('show');
}

//$('#profileedit').validator().on('submit', function (e) {
//  if (e.isDefaultPrevented()) {
//    console.log("form invalid");
//  } else {
//    // everything looks good!
//  }
//})

function deleteSecretKey(secretid2, userid2) {
  $.post('server/backend.php', {command: 'DELETESECRETKEY', secretid: secretid2, userid: userid2}, function(returnedData) {
    if (returnedData == "210A") {
      $('#keyDeleteModal').modal('hide');
      location.reload();
    } else if (returnedData == "570A") {
      deleteerrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else if (returnedData == "620A") {
      createerrorblock.innerHTML = "<p style=\"color:red\">You don't have permission to create or delete keys.</p>";
    } else {
      deleteerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
    }
  });
}

function submitKeyCreateForm() {
  var keynote2 = document.forms["keyCreateForm"]["keynote"].value;
  $.post('server/backend.php', {command: 'CREATESECRETKEY', keynote: keynote2}, function(returnedData) {
    if (returnedData == "210A") {
      $('#keyCreateModal').modal('hide');
      location.reload();
    } else if (returnedData == "570A") {
      createerrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else if (returnedData == "620A") {
      createerrorblock.innerHTML = "<p style=\"color:red\">You don't have permission to create or delete keys.</p>";
    } else {
      createerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
      console.log(returnedData);
    }
  });
}

function submitCheckPerms() {
  $.post('server/backend.php', {command: 'PERMTEST'}, function(returnedData) {
   console.log(returnedData);
  });
}

function submitCheckCommand() {
  var serverid = document.forms["permtest"]["serverid"].value;
  var servercommand = document.forms["permtest"]["command"].value;
  $.post('server/backend.php', {command: 'CHECKCOMMAND', serverid: serverid, servercommand: servercommand}, function(returnedData) {
   console.log(returnedData);
  });
}

function open2FALoadingModal() {
  $('#2FALoadingModal').modal('show');
  $.post('server/backend.php', {command: 'CHECK2FASTATUS'}, function(returnedData) {
    if (returnedData == "880A") {
      $('#2FALoadingModal').modal('hide');
      $('#2FAStatusModal').modal('show');
      mfastatusblock.innerHTML = "Status: <a style=\"color:green\">Enforced</a>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"open2FADisableModal()\"><i class=\"fa fa-trash fa-fw\"></i>Deactivate Multi-Factor</button>";
    } else if (returnedData == "890A") {
      $('#2FALoadingModal').modal('hide');
      $('#2FAStatusModal').modal('show');
      mfastatusblock.innerHTML = "Status: <a style=\"color:red\">Disabled</a>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"submit2FAEnableModal()\"><i class=\"fa fa-mobile fa-fw\"></i>Activate Multi-Factor</button>";
    } else if (returnedData == "890B") {
      $('#2FALoadingModal').modal('hide');
      $('#2FAStatusModal').modal('show');
      mfastatusblock.innerHTML = "Status: <a style=\"color:olive\">Pending</a>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"continue2FASetup()\"><i class=\"fa fa-mobile fa-fw\"></i>Continue Multi-Factor Setup</button>";
    } else if (returnedData == "570A") {
      $('#2FALoadingModal').modal('hide');
      $('#2FAStatusModal').modal('show');
      mfastatusblock.innerHTML = "Status: <a style=\"color:red\">Error retrieving data</a>";
      mfastatuserrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else {
      $('#2FALoadingModal').modal('hide');
      $('#2FAStatusModal').modal('show');
      mfastatusblock.innerHTML = "Status: <a style=\"color:red\">Error retrieving data</a>";
      mfastatuserrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
      console.log(returnedData);
    }
  });
}

function open2FAStatusModal() {
  $('#2FAStatusModal').modal('show');

}

function open2FAEnableModal() {
  $('#2FAEnableModal').modal('show');
}

function open2FADisableModal() {
  $('#2FAStatusModal').modal('hide');
  $('#2FADisableModal').modal('show');
}

function submit2FAEnableModal() {
  $.post('server/backend.php', {command: 'ENABLEUSER2FA'}, function(returnedData) {
    if (returnedData == "210A") {
      getQrCodeDetails();
    } else if (returnedData == "570A") {
      mfastatuserrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else if (returnedData == "840A") {
      mfastatuserrorblock.innerHTML = "<p style=\"color:red\">2FA is already enabled.</p>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"continue2FASetup()\"><i class=\"fa fa-mobile fa-fw\"></i>Continue Multi-Factor Setup</button>";
    } else {
      mfastatuserrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
      console.log(returnedData);
    }
  });
}

function continue2FASetup() {
  $.post('server/backend.php', {command: 'GET2FAQRCODE'}, function(returnedData) {
    $('#2FAStatusModal').modal('hide');
    $('#2FAContinueModal').modal('show');
    mfastatusblock.innerHTML = "Status: <a style=\"color:olive\">Pending</a>";
    mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"continue2FASetup()\"><i class=\"fa fa-mobile fa-fw\"></i>Continue Multi-Factor Setup</button>";
    var imgstart = "<img src='";
    var imgend = "'/>";

    qrcodecontinue.innerHTML = imgstart.concat(returnedData, imgend);
  });
}

function submit2FAEnableContinueModal() {
  var mfacontinue = document.forms["2facontinue"]["tokencontinue"].value;
  $.post('server/backend.php', {command: 'CONFIRMUSER2FA', token: mfacontinue}, function(returnedData) {
    if (returnedData == "210A") {
      $('#2FAContinueModal').modal('hide');
      mfastatusblock.innerHTML = "Status: <a style=\"color:green\">Enforced</a>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"open2FADisableModal()\"><i class=\"fa fa-trash fa-fw\"></i>Deactivate Multi-Factor</button>";
      open2FALoadingModal();
    } else if (returnedData == "570A") {
      mfacontinueerrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else if (returnedData == "870A") {
      mfacontinueerrorblock.innerHTML = "<p style=\"color:red\">Incorrect confirmation code.</p>";
    } else if (returnedData == "860A") {
      mfacontinueerrorblock.innerHTML = "<p style=\"color:red\">Already confirmed.</p>";
    } else {
      mfacontinueerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
      console.log(returnedData);
    }
  });
}

function removePending2FAToken() {
  $.post('server/backend.php', {command: 'REMOVEPENDINGTOKEN'}, function(returnedData) {
    if (returnedData == "210A") {
      $('#2FAContinueModal').modal('hide');
      mfastatusblock.innerHTML = "Status: <a style=\"color:red\">Disabled</a>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"submit2FAEnableModal()\"><i class=\"fa fa-mobile fa-fw\"></i>Activate Multi-Factor</button>";
      open2FALoadingModal();
    } else if (returnedData == "570A") {
      mfacontinueerrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else if (returnedData == "860A") {
      mfacontinueerrorblock.innerHTML = "<p style=\"color:red\">Already confirmed.</p>";
    } else {
      mfacontinueerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
      console.log(returnedData);
    }
  });
}

function getQrCodeDetails() {
  $.post('server/backend.php', {command: 'GET2FAQRCODE'}, function(returnedData) {
    $('#2FAStatusModal').modal('hide');
    $('#2FAConfirmModal').modal('show');
    mfastatusblock.innerHTML = "Status: <a style=\"color:olive\">Pending</a>";
    mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"continue2FASetup()\"><i class=\"fa fa-mobile fa-fw\"></i>Continue Multi-Factor Setup</button>";
    var imgstart = "<img src='";
    var imgend = "'/>";

    qrcode.innerHTML = imgstart.concat(returnedData, imgend);
  });
}

function submit2FAEnableConfirmModal() {
  var mfaconfirm = document.forms["2faconfirm"]["token"].value;
  $.post('server/backend.php', {command: 'CONFIRMUSER2FA', token: mfaconfirm}, function(returnedData) {
    if (returnedData == "210A") {
      $('#2FAConfirmModal').modal('hide');
      $('#2FAStatusModal').modal('show');
      mfastatusblock.innerHTML = "Status: <a style=\"color:green\">Enforced</a>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"open2FADisableModal()\"><i class=\"fa fa-trash fa-fw\"></i>Deactivate Multi-Factor</button>";
    } else if (returnedData == "570A") {
      mfaconfirmerrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else if (returnedData == "870A") {
      mfaconfirmerrorblock.innerHTML = "<p style=\"color:red\">Incorrect confirmation code.</p>";
    } else if (returnedData == "860A") {
      mfaconfirmerrorblock.innerHTML = "<p style=\"color:red\">Already confirmed.</p>";
    } else {
      mfaconfirmerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
      console.log(returnedData);
    }
  });
}

function submit2FADisableConfirmModal() {
  var mfaconfirm = document.forms["2fadisable"]["tokendisable"].value;
  var passconfirm = sha512(document.forms["2fadisable"]["passworddisable"].value);
  $.post('server/backend.php', {command: 'REMOVEUSER2FA', token: mfaconfirm, password: passconfirm}, function(returnedData) {
    if (returnedData == "210A") {
      $('#2FADisableModal').modal('hide');
      mfastatusblock.innerHTML = "Status: <a style=\"color:red\">Disabled</a>";
      mfacontrolblock.innerHTML = "<button type=\"button\" class=\"btn btn-default\" onclick=\"submit2FAEnableModal()\"><i class=\"fa fa-mobile fa-fw\"></i>Activate Multi-Factor</button>";
      open2FALoadingModal();
    } else if (returnedData == "570A") {
      mfadisableerrorblock.innerHTML = "<p style=\"color:red\">You're not logged in.</p>";
    } else if (returnedData == "870A") {
      mfadisableerrorblock.innerHTML = "<p style=\"color:red\">Incorrect confirmation code.</p>";
    } else if (returnedData == "890A") {
      mfadisableerrorblock.innerHTML = "<p style=\"color:red\">2FA is not enabled.</p>";
    } else if (returnedData == "580A") {
      mfadisableerrorblock.innerHTML = "<p style=\"color:red\">Incorrect password.</p>";
    } else {
      mfadisableerrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
      console.log(returnedData);
    }
  });
}

// Admin profile edit

function confirmAdminEditForm(useridadmin) {
  var formemail = document.forms["adminedit"]["email"].value;
  var formfirstname = document.forms["adminedit"]["firstname"].value;
  var formlastname = document.forms["adminedit"]["lastname"].value;
  var formusername = document.forms["adminedit"]["username"].value;
  var formplevel = document.forms["adminedit"]["profileeditpermission"].value;
  var username = document.forms["adminedit"]["username"].value;
  if (formplevel.length > 1) {
    $.post('server/backend.php', {command: 'UPDATEUSERPROFILEADMIN', userid: useridadmin, email: formemail, firstname: formfirstname, lastname: formlastname, username: username, permissionlevel: formplevel}, function(returnedData) {
     if (returnedData == "210A") {
      $('#passwordConfirmModal').modal('hide');
      location.reload();
     } else if (returnedData == "570A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
     } else if (returnedData == "580A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Incorrect password.</p>";
     } else if (returnedData == "630A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Cannot modify a group higher than your own.</p>";
     } else if (returnedData == "640A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Cannot modify your own account. Use Settings for that.</p>";
     } else if (returnedData == "620A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">You don't have permission to perform this action.</p>";
     } else if (returnedData == "720A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Parameter error.</p>";
     } else {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
     }
   })
  } else {
    $.post('server/backend.php', {command: 'UPDATEUSERPROFILEADMIN', userid: useridadmin, email: formemail, firstname: formfirstname, lastname: formlastname, username: username}, function(returnedData) {
     if (returnedData == "210A") {
      $('#passwordConfirmModal').modal('hide');
      location.reload();
     } else if (returnedData == "570A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
     } else if (returnedData == "580A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Incorrect password.</p>";
     } else if (returnedData == "630A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Cannot modify a group higher than your own.</p>";
     } else if (returnedData == "640A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Cannot modify your own account. Use Settings for that.</p>";
     } else if (returnedData == "620A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">You don't have permission to perform this action.</p>";
     } else if (returnedData == "720A") {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">Parameter error.</p>";
     } else {
      adminediterrorblock.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
     }
   })
  }
}
