// $('#btn').on('click', function(e) {
// 	$.ajax({
// 		url: 'http://olx.prog.uz/api/posters',
// 		type: 'get',
// 		dataType: 'json',
// 		success: function(data){
// 			console.log(data);
// 		}
// 	})
// })
	// const dddd = document.getElementById("search");

	// dddd.addEventListener("input", updateValue);

	// function updateValue(e) {
	//   var d = e.target.value;
	//   console.log(e.target.value)
	// }
	var s = $("#search")
	if (!s.val()) {
		$("#search_index").attr('disabled','disabled');
		// s.addClass('search_error');
	}
 
		$("#search").blur(function(){
			var d = $("#search");
			if(!d.val())
			{
				// d.addClass('search_error');
				$("#search_index").attr('disabled','disabled');
			}
			else
			{
				// d.removeClass('search_error');
				$("#search_index").removeAttr("disabled")
					$("#search_index").on('click', function(event){
						event.preventDefault();
				if (d.val()) {
						window.location.href = "http://advanced/site/search?ser="+d.val();
				}
					}) 
			}
		})

		var inutFile = $("#posters-image")
			// inutFile.addClass('search_error');

		$("#btn_form").on('click', function(){
			if (!inutFile.val()) {
				inutFile.addClass('search_error');
			}
		})

$("#search_page").on('click', function(event){
	event.preventDefault()
	var category = $("#category").val();
	var amount_from = $("#amount_from").val();
	var amount_to = $("#amount_to").val();
	var region = $("#region").val();
	console.log(search, category, amount_from, amount_to, region)
	window.location.href = "http://advanced/site/search-filter?category="+category+"&country="+region+"&amount_from="+amount_from+"&amount_to="+amount_to;
})

var title = $("#title");
var posters_price_disp = $("#posters-price-disp");
var select2_posters_category = $("#select2-posters-category-container");
var posters_image = $("#posters-image");
var select2_posters_address = $("#select2-posters-address-container");
var posters_description = $("#posters-description-container");

$("#add_btn").on('click', function(event){
	// event.preventDefault()
// console.log(posters_price_disp.val())
	// if ( !title.val() && !posters_price_disp.val() && !select2_posters_category.val() && !posters_image.val() && !select2_posters_address.val() )
	// {
	// 	$("#loader").html("<div class='alert alert-danger'>Ma'lumot kiritilmadi</div>");
	// }
})
