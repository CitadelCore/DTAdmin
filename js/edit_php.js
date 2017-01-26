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
  $('#profileedit').validator()
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
