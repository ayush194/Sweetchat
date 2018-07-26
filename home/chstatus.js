function changeStatus(userid_1, userid_2, istatusid, fstatusid) {
	$.ajax({
    url: "status.php",
    type: "post",
    data: {
    	"userid_1" : userid_1,
    	"userid_2" : userid_2,
      "istatusid" : istatusid,
      "fstatusid" : fstatusid,
    },
    success: function(response){
      //window.alert(response);
    }
  });
  window.location.reload(true); 
}