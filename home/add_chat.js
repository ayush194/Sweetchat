function createChatPopup(element) {
	if (element.innerHTML == '-') {
		element.innerHTML = '+';
		document.getElementById('create-chat-popup').style.display = 'none';
	} else {
		element.innerHTML = '-';
		document.getElementById('create-chat-popup').style.display = 'flex';
	}
	
}

function colorChange(element) {
	document.getElementById('create-chat-popup').style.borderColor = '#' + element.value;
	//window.alert(element.value);
}

function addMember(element) {
  //window.alert("add");
  $('#create-chat-members').append(
        '<div class="input-group mb-2">' + 
          '<div class="input-group-prepend">' + 
            '<span class="input-group-text" id="basic-addon1">@</span>' + 
          '</div>' + 
          '<input onfocusout="validateUser(this)" class="form-control create-chat-member" name="member1" required>' + 
          '<div class="input-group-append">' + 
            '<span onclick="removeMember(this)" class="btn btn-primary" style="width:35px;" id="basic-addon2">-</span>' +
          '</div>' + 
        '</div>'
  );
  renumber();
}

function removeMember(element) {
  //window.alert("remove");
  document.getElementById('create-chat-members').removeChild(element.parentNode.parentNode);
  renumber();
}

function renumber() {
  members = document.getElementsByClassName('create-chat-member');
  for (var i = 0; i < members.length; i++) {
    members[i].name = 'member' + (i + 1);
  }
}

function validateUser(element) {
  $.ajax({
    url: "https://sweet-chat.herokuapp.com/signup/submit",
    //for local testing
    //url: "/signup/submit.php",
    type: "post",
    data: {
      "username_check" : 1,
      "username" : element.value,
    },
    success: function(response){
      if (response == "available") {
        element.classList.remove("is-valid");
        element.classList.add("is-invalid");
      } else {
        element.classList.remove("is-invalid");
        element.classList.add("is-valid");
      }
    }
  });
}