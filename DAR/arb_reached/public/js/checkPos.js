function checkPos(){
    let posId = $('#officer').val();
    if(posId == 7){
        console.log(1);
        $('#assigned_addr').removeAttr('disabled' , 'disabled');
        $('#assigned_addr').removeAttr('hidden' , 'hidden');
        let acity = $('#acity').val();
        if(acity == ""){
            $('#upd').attr('disabled' , 'disabled');
        } else {
            $('#upd').removeAttr('disabled' , 'disabled');
        }
    } else {
        $('#assigned_addr').attr('disabled' , 'disabled');
        $('#assigned_addr').attr('hidden' , 'hidden');
    }
}