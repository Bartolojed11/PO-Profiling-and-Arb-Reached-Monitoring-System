$(document).ready(function(){
	let pageURL = $(location).attr("href");
	if(pageURL.search("profile") || pageURL.search("register")){
		$('#provv > li').on('click', function(){
			$('#cityin > div > input').val('');
			$('#barangay').val('');
			$('#other_addr').val('');
			let provincev = $(this).val();
			if(provincev == "" || provincev < 1){
				$('#province').val('');
				$('#province').focus();
			} else {
				$.post("../server/disp_prov.php" , {
					pid : provincev
				} , function(data,status){
					$('#province').val(data);
				});

				$.post("../server/get_city.php", {
					pid : provincev
				} ,  function(data){
					$('#cityy').html(data);
				});
			}
		});
		$('#aprovv > li').on('click', function(){
			let provincev = $(this).val();
				$.post("../server/disp_prov.php" , {
					pid : provincev
				} , function(data,status){
					$('#aprovince').val(data);
				});

				$.post("../server/dropdCity.php", {
					pid : provincev
				} ,  function(data){
					$('#acityy').html(data);
				});
		});
		if(pageURL.search("profile") > 0){
			update();
		}
	}

	$('#province , #cityin > div > input, #barangay').on('keypress',update);
	$('#aprovince , #acityin > div > input, #abarangay').on('keypress',update);
});

function update(){
	$.post("../server/get_city.php", {
		province : $('#province').val()
	} ,  function(data){
		$('#cityy').html(data);
	});

	$.post("../server/get_barangay.php", {
		city : $('#cityin > div > input').val()
	} ,  function(data){
		$('#brgyy').html(data);
	});

	$.post("../server/get_otheraddr.php", {
		brgy : $('#barangay').val()
		} ,  function(data){
		$('#other_addr_ul').html(data);
	});

	console.log($('#cityin > div > input').val());
}
function showcity(cityval){
		$('#barangay').val('');
		$('#other_addr_div > div > input').val('');
		$.post("../server/disp_city.php" , {
			cid : cityval
		} , function(data,status){
			$('#cityin > div > input').val(data);
		});

		if(cityval == "" ||  cityval < 1){
			$('#cityin > div > input').val('');
			$('#cityin > div > input').focus();
		} else {
			$.post("../server/get_barangay.php", {
				cid : cityval
			} ,  function(data){
				$('#brgyy').html(data);
				//assigned_brgy
			});
		}
}

function showbrgy(brgyval){
	$('#other_addr_div > div > input').val('');
	$.post("../server/disp_brgy.php" , {
		cid : brgyval
	} , function(data,status){
		$('#barangay').val(data);
	});

	$.post("../server/disp_brgy.php" , {
		cid : brgyval
	} , function(data,status){
		$('#abarangay').val(data);
	});

	if(brgyval == "" ||  brgyval < 1){
		$('#barangay').val('');
		$('#barangay').focus();
	} else {
		$.post("../server/get_otheraddr.php", {
			bid : brgyval
		} ,  function(data){
			$('#other_addr_ul').html(data);
		});
	}

}
function showotheraddr(other_addr){
	if(other_addr == 0 || other_addr == ''){
		$('#other_addr_div > div > input').val('');
		$('#other_addr_div > div > input').focus();
	} else 
	$.post("../server/disp_other.php" , {
		oid : other_addr
	} , function(data,status){
		$('#other_addr_div > div > input').val(data);
	});

}
function ashowcity(cityval){
	$.post("../server/disp_city.php" , {
		cid : cityval
	} , function(data,status){
		$('#acityin > div > input').val(data);
	});
		$.post("../server/dropdBrgy.php", {
			cid : cityval
		} ,  function(data){
			$('#brgy_body').html(data);
		});
}
// function ashowbrgy(brgyval){
// 	$.post("../server/dropdBrgy.php" , {
// 		cid : brgyval
// 	} , function(data,status){
// 		console.log(status);
// 		$('#brgy_body').html(data);
// 	});
// }