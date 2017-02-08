function disableUserByID(userid) {
  $.post('server/backend.php', {command: 'DISABLEUSERPROFILE', userid: userid}, function(returnedData) {
    if (returnedData == "210A") {
     location.reload();
    } else if (returnedData == "570A") {
     actionerrors.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
    } else if (returnedData == "910A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You can't disable your own account.</p>";
    } else if (returnedData == "620A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You're not authorized to perform this action.</p>";
    } else {
     actionerrors.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
    }
  })
}

function enableUserByID(userid) {
  $.post('server/backend.php', {command: 'ENABLEUSERPROFILE', userid: userid}, function(returnedData) {
    if (returnedData == "210A") {
     location.reload();
    } else if (returnedData == "570A") {
     actionerrors.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
    } else if (returnedData == "920A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You can't enable your own account.</p>";
    } else if (returnedData == "620A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You're not authorized to perform this action.</p>";
    } else {
     actionerrors.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
    }
  })
}

function lockUserByID(userid) {
  $.post('server/backend.php', {command: 'LOCKUSERPROFILE', userid: userid}, function(returnedData) {
    if (returnedData == "210A") {
     location.reload();
    } else if (returnedData == "570A") {
     actionerrors.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
   } else if (returnedData == "930A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You can't lock your own account.</p>";
    } else if (returnedData == "620A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You're not authorized to perform this action.</p>";
    } else {
     actionerrors.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
    }
  })
}

function unlockUserByID(userid) {
  $.post('server/backend.php', {command: 'UNLOCKUSERPROFILE', userid: userid}, function(returnedData) {
    if (returnedData == "210A") {
     location.reload();
    } else if (returnedData == "570A") {
     actionerrors.innerHTML = "<p style=\"color:red\">Your session has expired. Please log in again.</p>";
   } else if (returnedData == "940A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You can't unlock your own account.</p>";
    } else if (returnedData == "620A") {
     actionerrors.innerHTML = "<p style=\"color:red\">You're not authorized to perform this action.</p>";
    } else {
     actionerrors.innerHTML = "<p style=\"color:red\">An internal error occured.</p>";
    }
  })
}
