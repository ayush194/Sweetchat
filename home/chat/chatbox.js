function sendMessage(chatid) {
	var msg = document.getElementById("msg").innerHTML;
  var stripped_msg = striphtmltags(msg);
  //window.alert(stripped_msg);
  if (/^\s*$/.test(stripped_msg)) {
    window.alert("Message is empty!");
    document.getElementById("msg").innerHTML = "";
    return;
  }
  document.getElementById("msg").innerHTML = "";
  pushMessage(chatid, msg);
  //window.location.reload(true);*/
}

function striphtmltags(str) {
  //remove all <br> tags
  str = str.replace(/<br\s*[\/]?>/ig, "");
  //extract text from inside <div></div> tags and prepend a newline
  str = str.replace(/<div\s*\/>/ig, "\n");
  str = str.replace(/<div\s*>([^<]*)<\/\s*div>/ig, "\n$1")
  return str;
}

/*
function currDate() {
  var d = new Date();
  var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July',
  'August', 'September', 'October', 'November', 'December'];
  var date = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear() + ' ' + d.getHours() + ':' + d.getSeconds();
  return date;
}
*/

function pushMessage(chatid, text) {
  $.ajax({
    url: "https://sweet-chat.herokuapp.com/home/chat/push_message",
    //for local testing
    //url: "push_message.php",
    type: "post",
    data: {
      "text" : text,
      "chatid" : chatid,
    },
    success: function(response){
      /*
      $('#chat-container').append(
        response
      );
      window.alert(response);
      */
    }
  });
}