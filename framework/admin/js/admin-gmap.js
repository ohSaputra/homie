/* JavaScript File                                                  */
/* admin-gmap.js                                                    */
/* Modified March 24, 2016                                          */


jQuery(document).ready(function($) { 

	// --------------------------------------------- gmap form - enables a google map for selecting a pin point -----------------------------------------------------------
		
		$('div.gmap-form').each(function() {
		
			var gmap = $(this).attr('id');
			var address = $('#' + gmap + '-address');
			var button = $('#' + gmap + '-button');
			var latitude = $('#' + gmap + '-latitude');
			var longitude = $('#' + gmap + '-longitude');
			var zoomlevel = $('#' + gmap + '-zoom');
			var location = gmap + '-location';
			
			var width = $('#' + location).attr('data-width');
			var height = $('#' + location).attr('data-height');
					
			if (width !== '') { $('#' + location).css({'width' : width + 'px'}); }
			if (height !== '') { $('#' + location).css({'height' : height + 'px'}); }
			
			var geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(latitude.val(), longitude.val());

			var options = { zoom: parseInt(zoomlevel.val()), center: latlng, scrollwheel: false, mapTypeId: google.maps.MapTypeId.ROADMAP };
			var map = new google.maps.Map(document.getElementById(location), options);
			var marker = new google.maps.Marker({ position: latlng, title: 'Point', map: map, draggable: true });		
	        
			google.maps.event.addListener(map, 'click', function(event) { map.setCenter(event.latLng); marker.setPosition(event.latLng); });
			google.maps.event.addListener(map, 'center_changed', function() { latitude.val(map.getCenter().lat()); longitude.val(map.getCenter().lng()); zoomlevel.val(map.getZoom()); });
			google.maps.event.addListener(map, 'zoom_changed', function() { zoomlevel.val(map.getZoom()); });
			google.maps.event.addListener(marker, 'dragend', function(event) { latitude.val(event.latLng.lat()); longitude.val(event.latLng.lng()); map.setCenter(event.latLng); });

			$('a[data-toggle=tab]').click(function () { 
				
				var center = map.getCenter();

				google.maps.event.trigger(map, 'resize');
				map.setCenter(center);
			});

			button.click(function(e){ $(this).findGmapAddress(address, geocoder, map, marker); e.preventDefault(); });
		});
		
		$.fn.findGmapAddress = function(address, geocoder, map, marker) {
		
			if (geocoder && address.val() !== '') {
				
				geocoder.geocode( { 'address': address.val()}, function(results, status) { if (status === google.maps.GeocoderStatus.OK) { map.setCenter(results[0].geometry.location); marker.setPosition(results[0].geometry.location); } else { alert("Geocode was not successful for the following reason: " + status); } });
			}
		};

	// -----------------------------------------------------------------------------------------------------------------------------------------------------------
});
