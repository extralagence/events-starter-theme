$(document).ready(function(){

	var oldIE = $("html").hasClass("lte7") ? true : false;
	/*********************
	 *
	 * SUMMARY
	 * 
	 ********************/
	var summary = $("#booking-summary");

	/*********************
	 *
	 * PRESET FIRST ATTENDEE
	 *
	 ********************/
	if (extra_booking_datas['extra_first_name'] != '') {
		$('.em-first-attendee-fields .input-field-extra_attendee_first_name input').val(extra_booking_datas['extra_first_name']);
	}
	if (extra_booking_datas['extra_last_name'] != '') {
		$('.em-first-attendee-fields .input-field-extra_attendee_last_name input').val(extra_booking_datas['extra_last_name']);
	}


	/*********************
	 *
	 * CHECKBOX & RADIO
	 * 
	 ********************/  
	// ADJUST LABELS
	$('#extra-booking-content .input-radio .input-group').each(function(){
		var parent = $(this);
		var inputs = parent.find('input[type="radio"]');
		inputs.each(function(i){
			var input = $(this);
			$(input[0].nextSibling).wrap('<label>');
			if(!input.attr("id")) {
				input.attr("id", input.attr("name") + i);
				input.next("label").attr("for", input.attr("id"));
			}
		});
	});
	// REPLACE
	$('#extra-booking-content p .input-group > input[type="radio"], #extra-booking-content .input-group > input[type="checkbox"]').extraCheckbox();

	var _slider = $('<div class="slider"></div>');


	/*********************
	 *
	 * ACTIVITIES & RESTAURANTS
	 *
	 ********************/
	$("#booking-meal").each(function(index) {
		var container = $(this);
		var activities = $("#activity_selector");
		var restaurants = $("#restaurant_selector");
		var both = activities.add(restaurants);
		//var input = $("#activity_selector").hide();
		var firstClick = false;
		activities.change(function(){
			var current = activities.val();
			if(current != "") {
				activities.attr("disabled", "disabled");
				restaurants.find("option").attr("disabled", "disabled").filter("[data-connected~="+current+"]").removeAttr("disabled");
			}
		});
		restaurants.change(function(){
			var current = restaurants.val();
			if(current != "") {
				restaurants.attr("disabled", "disabled");
				activities.find("option").attr("disabled", "disabled").filter("[data-connected~="+current+"]").removeAttr("disabled");
			}
		});
		both.change(function(){
			var activitiesTxt = "";
			activitiesTxt = activities.find("option:selected").filter(function(){
				return $(this).val() != "";
			}).text();
			var restaurantsTxt = "-";
			restaurantsTxt = restaurants.find("option:selected").filter(function(){
				return $(this).val() != "";
			}).text();
			/*if(activitiesTxt != "" || restaurantsTxt != "") {
			 input.val(activitiesTxt + " / " + restaurantsTxt);
			 } else {
			 input.val("");
			 }*/
		});
		container.find(".reset").click(function(){
			activities.removeAttr('disabled').val("").find("option").removeAttr('disabled');
			restaurants.removeAttr('disabled').val("").find("option").removeAttr('disabled');
			both.change();
			return false;
		});

		/*********************
		 *
		 * REMOVE DISABLE WHEN PUSH
		 *
		 ********************/
		$("#em-booking-form").submit(function(){
			both.filter(":disabled").removeAttr("disabled").addClass("disabled");
		});
		$(document).on("em_booking_ajax_complete", function(){
			both.filter(".disabled").removeClass("disabled").attr("disabled", "disabled");
		});
	});

	if(window.location.hash != "") {
		var hash = window.location.hash;
		var parts = hash.split("/");
		if(parts.length == 3) {
			switch(parts[1]) {
				case "activite":
					$("#activity_selector").val(parts[2]).change();
					break;
				case "restaurant":
					$("#restaurant_selector").val(parts[2]).change();
					break;
			}
		}
	}

	/*********************
	 *
	 * GUESTS SLIDER
	 * 
	 ********************/
	var _guest = $('<p class="input-group"><label for="">Nom de l\'invité</label><input type="text" class="input guest" value="" /></p>');
	var _maxguest = 10;
	var guestsInput = $("#extra_guest_num");
	var _guest_names = $("#extra_guest_names").hide();
	_guest_names.prev("label").hide();
	
	// INIT
	guestsInput.each(function(){
		var input = $(this);
		var parent = input.parent();
		var guests = [];
		parent.addClass("input-guest input-slider");
		for(var i = 0; i<_maxguest; i++) {
			guests[i] = _guest.clone().appendTo(_guest_names.parent());
			guests[i].find("label").attr("for", "_extra_guest_"+i).text("Nom de l'invité "+(i+1));
			guests[i].find("input").attr("id", "_extra_guest_"+i).on("change focus blur", function(){
				updateGuests();
			});
		}
		
		// INIT SLIDER
		var $slider = _slider.clone().insertBefore(input).slider({
			value: 1,
			min: 1,
			max: _maxguest
		}).on("slide slidechange", function(event, ui){
			// SLIDER UPDATE
			input.val(ui.value);
			$.each(guests, function(index, item){
				if(index < parseInt(ui.value)) {
					item.show();
				} else {
					item.hide();
				}
				updateGuests();
				updateSummary();
			});
		});
		$slider.slider("value", 1);
		
		// UPDATE GUEST NAMES
		function updateGuests(){
			var value = parseInt($slider.slider("value"));
			var txt = "";
			$.each(guests, function(index, item){
				if(index < value) {
					txt += $.trim(item.find("input").val()) + "\n";
				}
				_guest_names.val($.trim(txt));
			});
		}
	});
	/*********************
	 *
	 * SUMMARY
	 * 
	 ********************/
	function updateSummary(){

		var nbAttendee = 1;
		var attendeeSelect = $('#em-ticket-spaces-1');
		if (attendeeSelect.length > 0) {
			nbAttendee = attendeeSelect.val();
		}
		var ticketPrice = parseInt(summary.find(".summary-ticket-price").data("price"));
		var priceTotal = ticketPrice*nbAttendee;
		if (nbAttendee <= 1) {
			summary.find(".summary-ticket-price .price").html(ticketPrice + ' &euro;');
		} else {
			summary.find(".summary-ticket-price .price").html(ticketPrice + ' &euro; x ' + nbAttendee + ' = ' + priceTotal + ' &euro;');
		}
		//
		// FIRST NAME AND LAST NAME
		// 
		var sumName = summary.find(".name"); 
		var first_name = $("#first_name");
		var last_name = $("#last_name");
		if((first_name.size() > 0 && first_name.val() != "") || (last_name.size() > 0 && last_name.val() != "")) {
			sumName.show();
			sumName.text(" ");
			if(first_name.size() > 0 && first_name.val() != "") { 
				sumName.append(first_name.val() + " ");
			}
			if(last_name.size() > 0 && last_name.val() != "") {
				sumName.append(last_name.val());
			}
		} else if(sumName.text().replace(/\s/g,"") == "") {
			sumName.hide();
		}
		// 
		// ADDRESS
		// 
		var addressName = summary.find(".address"); 
		var address = $("#dbem_extra_address"); 
		var address2 = $("#dbem_extra_address2");
		var postal_code = $("#dbem_extra_postal_code");
		var city = $("#dbem_extra_city");
		var country = $(".dbem_extra_country");
		if(	(address.size() > 0 && address.val() != "")
			|| (postal_code.size() > 0 && postal_code.val() != "")
			|| (city.size() > 0 && city.val() != "")) {
			addressName.show();
			addressName.text(" ");
			if(address.size() > 0 && address.val() != "") { 
				addressName.append(address.val()+"<br />");
			}
			if(address2.size() > 0 && address2.val() != "") {
				addressName.append(address2.val()+"<br />");
			}
			if(postal_code.size() > 0 && postal_code.val() != "") {
				addressName.append(postal_code.val() + " ");
			}
			if(city.size() > 0 && city.val() != "") {
				addressName.append(city.val());
			}
			if(country.size() > 0 && country.find("option:selected").val() != "") {
				addressName.append(", " + country.find("option:selected").text());
			}
		} else if(addressName.text().replace(/\s/g,"") == "") {
			addressName.hide();
		}
		// 
		// TELEPHONE
		// 
		var sumTel = summary.find(".tel"); 
		var telephone = $("#dbem_extra_phone");
		if((telephone.size() > 0 && telephone.val() != "")) {
			sumTel.show();
			sumTel.text(telephone.val() + " ");
		} else if(sumTel.text().replace(/\s/g,"") == "") {
			sumTel.hide();
		}
		// 
		// MOBILE
		// 
		var sumMobile = summary.find(".mobile"); 
		var mobile = $("#dbem_extra_mobile");
		if((mobile.size() > 0 && mobile.val() != "")) {
			sumMobile.show();
			sumMobile.text(mobile.val());
		} else if(sumMobile.text().replace(/\s/g,"") == "") {
			sumMobile.hide();
		}
		// 
		// EMAIL
		// 
		var sumEmail = summary.find(".email"); 
		var email = $("#user_email");
		if((email.size() > 0 && email.val() != "")) {
			sumEmail.show();
			sumEmail.text(email.val());
		} else if(sumEmail.text().replace(/\s/g, "") == "") {
			sumEmail.hide();
		}
		// 
		// HEBERGEMENT
		//
		var booking_option1 = $("#booking-hosting-summary .hosting-option1");
		var booking_option2 = $("#booking-hosting-summary .hosting-option2");
		var hotels_price = summary.find(".summary-hotels-price");
		if(!$("#extra_hosting").is(":checked")){
			// RIEN DE COCHÉ
			booking_option1.show();
			booking_option2.hide();
			hotels_price.hide();
		} else {
			// HOTEL & ROOM
			booking_option1.hide();
			booking_option2.show();
			var hotel = $("#booking-hosting .extra_hotel");
			var room = $("#booking-hosting .extra_room_type");
			var sumHotel = $("#booking-hosting-summary .hotel");
			var sumRoom = $("#booking-hosting-summary .room");
			if(hotel.val() != "" && room.val() != "") {
				sumHotel.parent().show();
				sumHotel.text(hotel.find("option:selected").text());
				sumRoom.text(room.find("option:selected").text().toLowerCase());
				hotels_price.show();
				hotels_price.find(" > p").hide();

				var hotelId = hotel.val();
				if (room.find("option").eq(1).is(':selected')) {
					hotels_price.find(".summary-hotel-simple-price").filter('[data-hotel-id="'+hotelId+'"]').show();
				} else if (room.find("option").eq(2).is(':selected')) {
					hotels_price.find(".summary-hotel-double-price").filter('[data-hotel-id="'+hotelId+'"]').show();
				}

//				if(hotel.find("option").eq(1).is(':selected') && room.find("option").eq(1).is(':selected')) {
//					hotels_price.find(".summary-hotel1simple-price").show();
//				} else if(hotel.find("option").eq(1).is(':selected') && room.find("option").eq(2).is(':selected')) {
//					hotels_price.find(".summary-hotel1double-price").show();
//				} else if(hotel.find("option").eq(2).is(':selected') && room.find("option").eq(1).is(':selected')) {
//					hotels_price.find(".summary-hotel2simple-price").show();
//				} else if(hotel.find("option").eq(2).is(':selected') && room.find("option").eq(2).is(':selected')) {
//					hotels_price.find(".summary-hotel2double-price").show();
//				}
			} else {
				sumHotel.parent().hide();
				hotels_price.hide();
			}
			// ARRIVAL
			var arrivalDate = $("#booking-hosting #extra_arrival_date");
			var arrivalTime = $("#booking-hosting #extra_arrival_time");
			var sumArrivalDate = $("#booking-hosting-summary .arrival .date");
			var sumArrivalTime = $("#booking-hosting-summary .arrival .time");
			if(arrivalDate.val() != "" && arrivalTime.val() != "") {
				sumArrivalDate.parent().show();
				sumArrivalDate.text(arrivalDate.val());
				sumArrivalTime.text(arrivalTime.val());
			} else {
				sumArrivalDate.parent().hide();
			}
			// DEPARTURE
			var departureDate = $("#booking-hosting #extra_departure_date");
			var departureTime = $("#booking-hosting #extra_departure_time");
			var sumDepartureDate = $("#booking-hosting-summary .departure .date");
			var sumDepartureTime = $("#booking-hosting-summary .departure .time");
			if(departureDate.val() != "" && departureTime.val() != "") {
				
				sumDepartureDate.parent().show();
				sumDepartureDate.text(departureDate.val());
				sumDepartureTime.text(departureTime.val());
			} else {
				sumDepartureDate.parent().hide();
			}
			// BOTH TO CALCULATE LENGTH
			if(hotel.val() != "" && arrivalDate.val() != "" && departureDate.val() != "") {
				var dateFormat = arrivalDate.datepicker("option", "dateFormat");
				var arrivalUnix = $.datepicker.parseDate(dateFormat, arrivalDate.val());
				var departureUnix = $.datepicker.parseDate(dateFormat, departureDate.val());
				var daysBetween = ((departureUnix - arrivalUnix) / 86400000);
				hotels_price.show().find(" > p").each(function(){
					var price = $(this).data("price");
					$(this).find(".price").text(price + " x " + daysBetween + " = " + (price * daysBetween) + " €");
				});
				priceTotal += hotels_price.find("> p:visible").eq(0).data("price") * daysBetween;
			} else {
				hotels_price.hide().find(" > p").each(function(){
					$(this).find(".price").text(" - €");
				});
			}
		}
		// MEAL
		var sumMeal = $("#booking-meal-summary");
		// 
		// COCKTAILS
		//
		var sumCocktailYes = summary.find(".cocktail-yes");
		var sumCocktailNo = summary.find(".cocktail-no"); 
		var cocktail = $("#extra_cocktail");
		var cocktailPrice = summary.find(".summary-cocktail-price");
		if(cocktail.size() > 0 && cocktail.is(":checked")) {
			sumCocktailYes.show();
			sumCocktailNo.hide();
			cocktailPrice.show();
			priceTotal += cocktailPrice.data("price");
			
		} else {
			sumCocktailYes.hide();
			sumCocktailNo.show();
			cocktailPrice.hide();
		}
		// 
		// GALA
		//
		var sumGalaYes = summary.find(".gala-yes");
		var sumGalaNo = summary.find(".gala-no"); 
		var gala = $("#extra_gala");
		var sumGuestYes = summary.find(".guest-yes");
		var sumGuestNo = summary.find(".guest-no"); 
		var guest = $("#extra_guest");
		var guestList = summary.find(".guest-list");
		var galaPrice = summary.find(".summary-gala-price");
		if(gala.size() > 0 && gala.is(":checked")) {
			sumGalaYes.show();
			sumGalaNo.hide();
			// 
			// HAS GUEST
			//
			if(guest.size() > 0 && guest.is(":checked")) {
				sumGuestYes.show();
				sumGuestNo.hide();
				guestList.show();
				// NAMES
				var names = $("#extra_guest_names").val().split("\n");
				var namesTxt = "";
				for(var name in names) {
					if(names[name] != "") {
						namesTxt += "<li>"+names[name]+"</li>";
					}
				}
				guestList.html(namesTxt);
				var price = galaPrice.data("price");
				var numGuests = parseInt($("#extra_guest_num").val()) + 1;
				galaPrice.show().find(".price").text(price + " x " + numGuests + " = " + (price * numGuests) + " €");
				priceTotal += price * numGuests;
			} else {
				sumGuestYes.hide();
				sumGuestNo.show();
				guestList.hide();
				var price = galaPrice.data("price");
				galaPrice.show().find(".price").text(price + " €");
				priceTotal += price;
			}
		} else {
			sumGalaYes.hide();
			sumGalaNo.show();
			galaPrice.hide();
			// HIDE GUEST TOO
			sumGuestYes.hide();
			sumGuestNo.hide();
			guestList.hide();
		}
		// 
		// DIET
		//
		var sumDiet = summary.find(".diet");
		var sumDietTxt = summary.find(".diet-text"); 
		var diet = $("#extra_diet"); 
		var dietTxt = $("#extra_diet_text");
		if(diet.size() > 0 && diet.is(":checked")) {
			sumDiet.show();
			sumDietTxt.show();
			sumDietTxt.html(dietTxt.val().replace(/\n/g, '<br />'))
		} else {
			sumDiet.hide();
			sumDietTxt.hide();
		}

		var sumActivityAndRestaurant = summary.find(".activity-and-restaurant");
		var sumActivity = summary.find(".activity");
		var sumRestaurant = summary.find(".restaurant");
		var activity = $("#activity_selector");
		var restaurant = $("#restaurant_selector");


		sumActivityAndRestaurant.hide();
		if(activity.val() != null && activity.val() != "" && restaurant.val() != null && restaurant.val() !=  "") {
			sumActivityAndRestaurant.show();
			sumActivity.html(activity.find('option[value="'+activity.val()+'"]').html());
			sumRestaurant.html(restaurant.find('option[value="'+restaurant.val()+'"]').html());
		}

		summary.find(".total-price .price").text(priceTotal + " €");
		
		$.waypoints('refresh');
		
	}
	$("#extra-booking-content").on("change focus blur", "select, input, textarea", function(){
		updateSummary();
	});
	updateSummary();
	/*********************
	 *
	 * WAYPOINTS
	 * 
	 ********************/  
	$("#extra-booking-content > fieldset").waypoint(function(direction){
		var id = $(this).attr("id");
		$("#extra-booking-navigation li").removeClass("active above").filter(function(){
			return $(this).find("a").attr("href") == "#"+id;
		}).addClass("active");
		var above = $.waypoints('above');
		if(above.length > 0) {
			$.each(above, function(index, item){
				$("#extra-booking-navigation li a[href='#"+$(item).attr("id")+"']").parent().addClass("above");
			});
		}
	}, {
		offset: 50
	});
	/*********************
	 *
	 * TOP NAV
	 * 
	 ********************/
	var topNav = $("#extra-booking-navigation");
	topNav.waypoint('sticky', {
		offset: 25
	});
	topNav.on("click", "a", function(){  
		$.waypoints('refresh');
		var the_id = $(this).attr("href"); 
		var current = $(window).scrollTop();
		var to = $(the_id).offset().top - 50;
		if(current > to) {
			to -= 1;
		}
		TweenMax.to($(window), 1, {scrollTo:{y:to}});
		return false;  
	}); 
	/*********************
	 *
	 * UPDATE STICKY
	 * 
	 ********************/
	TweenMax.delayedCall(1, function(){
		$.waypoints('refresh');
	});
});