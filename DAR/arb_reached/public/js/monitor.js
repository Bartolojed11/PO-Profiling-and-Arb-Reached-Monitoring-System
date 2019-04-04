function monitorBeneficiary(uid){
    this.uid = uid;

	$.post("../server/logMonitoredBen.php", {
		id : this.uid
	} ,  function(data,status){
            console.log(data);
	});
}

function monitorOrganization(id){

}