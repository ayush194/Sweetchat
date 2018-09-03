//window.alert("validate.js");

//For having a secure validation we need to validate our forms on server-side.
//While validating the form on client side using javascript and ajax calls to
//the server gives a better user experience as form gets validated as it is
//typed in. But it is insecure as, the Javascript or AJAX calls can be altered
//by malicious people. So to have a secure and user-friendly validation, it is
//best to validate forms both on client and server side

//Here we implement the client side validation.

setInterval(function() {
  var inputs = document.getElementsByTagName("input");
  var flag = true;
  for(var i = 0; i < inputs.length; i++) {
    if (inputs[i].classList.contains("is-invalid")) {
      flag = false;
      break;
    }
  }
  if (!flag) {
    $(":submit").prop("disabled", true);
  } else {
    $(":submit").prop("disabled", false);
  }
}, 100);

function validateName(element) {
	var generic_name = /^[A-Za-z\s]+$/;
  var valid = generic_name.test(element.value);
  if (valid && element.value != "") {
    element.classList.remove("is-invalid");
    element.classList.add("is-valid");
  } else {
    element.classList.remove("is-valid");
    element.classList.add("is-invalid");
  }
}

function validateEmail(element) {
  var generic_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  var valid = generic_email.test(element.value);
	//console.log(element.value);
  $.ajax({
    url: "https://sweet-chat.herokuapp.com/signup/submit",
    //for local testing
    //url: "https://submit.php",
    type: "post",
    data: {
      "email_check" : 1,
      "email" : element.value,
    },
    success: function(response){
      if (response == "available" && element.value != "" && valid) {
        element.classList.remove("is-invalid");
        element.classList.add("is-valid");
      } else {
        element.classList.remove("is-valid");
        element.classList.add("is-invalid");
      }
    }
  });
}

function validateUser(element) {
  //console.log(element.value);
  var generic_username = /^[A-Za-z0-9_]+$/;
  var valid = generic_username.test(element.value);
  $.ajax({
    url: "https://sweet-chat.herokuapp.com/signup/submit",
    //for local testing
    //url: "https://submit.php",
    type: "post",
    data: {
    	"username_check" : 1,
    	"username" : element.value,
    },
    success: function(response){
      if (response == "available" && element.value != "" && valid) {
        element.classList.remove("is-invalid");
        element.classList.add("is-valid");
      } else {
        element.classList.remove("is-valid");
        element.classList.add("is-invalid");
      }
    }
  });
}

function validatePass(element) {
  if (element.value.length >= 8 && element.value != "") {
    element.classList.remove("is-invalid");
    element.classList.add("is-valid");
  } else {
    element.classList.remove("is-valid");
    element.classList.add("is-invalid");
  }
}

//validate();