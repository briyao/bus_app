/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Handles all interaction with admin “View Routes” page (selecting a route, displaying route 
info on map and info card, handling changes to the route in edit route card)
*/

var autocomplete;
var markers = [];

//initialize map
function initMapAndAutocomplete() {
    //initialize directions service, display, and maps
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: {lat: 40.33, lng: -74.13}
    });
    var preview_map = new google.maps.Map(document.getElementById('preview-map'), {
      zoom: 10,
      center: {lat: 40.33, lng: -74.13}
    });
    
    //display route if selected
    document.getElementById('route-select').addEventListener('change', function() {
      $(document.getElementById("editRouteCard")).collapse("hide");
      directionsDisplay.setMap(map);
      getRouteAddresses(directionsService, directionsDisplay);
    });
    
    //handle previewing stops to combine on map
    document.getElementById('preview-combine-stops-btn').addEventListener('click', function() {
      for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(null);
      }
      //plot checked addresses
      var selected_addresses = getSelectedAddresses();
      for (var i = 0; i < selected_addresses.length; i++) {
        geocodeAddress(selected_addresses[i], geocoder, preview_map, 0);
      }
      //plot combined location
      var new_address = document.getElementById("autocomplete").value;
      if (new_address != "") {
        geocodeAddress(new_address, geocoder, preview_map, 1);
      }
    });
    
    //initialize autocomplete variables
    // Create the autocomplete object, restricting the search predictions to
    // geographical location types.
    autocomplete = new google.maps.places.Autocomplete(
    document.getElementById('autocomplete'), {types: ['geocode']});
  
    // Avoid paying for data that you don't need by restricting the set of
    // place fields that are returned to just the address components..
    autocomplete.setFields(['address_component']);
  
    // When the user selects an address from the drop-down, populate the
    // address fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

//return stop_times array
function getRouteAddresses(dirSer, dirDis) {
    var dropdown = document.getElementById('route-select');
    var selected_route = dropdown.options[dropdown.selectedIndex].text;
    
    //get the addresses in route
    $.ajax({
        url: './process-php/get-addresses-for-route.php',
        type: 'GET',
        data: {'route_name': selected_route},
        success: function(response) {
          console.log(response);
          var address_list = JSON.parse(response); //get list of addresses in route
          //console.log(address_list);
          
          //display the route, create dictionary of addresses, stop_times
          displayRoute(dirSer, dirDis, address_list, function(stop_times){
            //console.log(stop_times);
            var summaryPanel = document.getElementById('routeinfo');
            summaryPanel.innerHTML = '';
            $.ajax({
              url: './process-php/get-driver-of-route.php',
              type: 'GET',
              data: {'route_name': selected_route},
              success: function(response) {
                var stops_array = [];
                var driver_name = response;
                var stopInfo = '';
                summaryPanel.innerHTML += 'Driver: ' + driver_name + '<br><br>';
                
                //display information about each stop
                createStopsArray(stop_times, selected_route, function(stops_array){
                  //summaryPanel.innerHTML += 'Here is the stop array!' + stops_array;
                  orderStopsArray(stops_array, function(ordered_stops){
                    for (var j = 0; j < ordered_stops.length; j++){
                      summaryPanel.innerHTML += ordered_stops[j];
                    }
                  });
                });
              },
              error: function(request, error) {
                console.log("Error", error);
              }
            });
          });
        },
        error: function(request, error) {
          console.log("Error", error);
        }
    });
}

//order the array created by route_segment name
function orderStopsArray(stops_array, callback){
  var ordered_stops = new Array(stops_array.length);
  var num_ordered_stops = 0;
  
  //loop through stops_array
  for (var i = 0; i < stops_array.length; i++){
    var stopNum = 0;
    stopNum = stops_array[i][0];
    
    //add to new array in order
    ordered_stops[stopNum - 1] = stops_array[i][1];
    num_ordered_stops += 1;
    if (num_ordered_stops === stops_array.length){
      callback(ordered_stops);
    }
  }
}

//create stop array
function createStopsArray(stop_times, selected_route, callback){
  var stops_array = [];
  
  //loop through stops_array
  for (var i = stop_times.length-1; i >= 0; i--){
    
    //get the stop info
    createStopInfo(stop_times, selected_route, i, function(stopInfoArray){
      stops_array.push(stopInfoArray);
      if (stops_array.length === stop_times.length){
        //document.getElementById('routeinfo').innerHTML += 'length: ' + stops_array.length;
        callback(stops_array);
      }
    })
  }
}

//return array of route_segment and stop information
function createStopInfo(stop_times, selected_route, index, callback){
  $.ajax({
    url: './process-php/get-students-at-stop.php',
    type: 'GET',
    data: {'route_name': selected_route, 'address': stop_times[index]['address']},
    success: function(response) {
      console.log(stop_times[index]['route_segment']);
      var stopInfo = '';
      //display stop number
      stopInfo += '<b>Stop: ' + stop_times[index]['route_segment'] + '</b><br>';
      
      //display names
      stopInfo += 'Student(s): ';
      var students_in_route = JSON.parse(response);
      for (var k = 0; k < students_in_route.length; k ++){
        stopInfo += students_in_route[k];
        if (k != students_in_route.length - 1){
          stopInfo += ', '
        }
      }
      
      //display address and stop time
      stopInfo += '<br>Address: ' + stop_times[index]['address'] + '<br>';
      stopInfo += 'Stop Time: ' + stop_times[index]['stop_time'] + ' A.M. <br><br>';
      
      callback([stop_times[index]['route_segment'],stopInfo]);
    },
    error: function(request, error) {
      console.log("Error", error);
    }
  });
}

//display route to user
function displayRoute(directionsService, directionsDisplay, addresses, callback) {
    waypts = [];
    addresses.forEach(function(a) {
        waypts.push({location: a, stopover: true});
    });
      //call route on directions service object
      directionsService.route({                                         //pass in DirectionsRequest object literal
        origin: "4000 Kozloski Rd, Freehold, NJ 07728",                                        //start location
        destination: "765 Newman Springs Rd, Lincroft, NJ 07738",       //end location
        waypoints: waypts,                                              //array of DirectionsWaypoints, each waypoint is an object literal with location and stopover(bool)
        optimizeWaypoints: true,                                        //returning optimized route specified in waypoint_order field
        travelMode: 'DRIVING'
      }, function(response, status) { //callback function
        if (status === 'OK') {
          
          directionsDisplay.setDirections(response);    //display map
          
          var route = response.routes[0];
          var stop_times = [];
          var stopTime = new Date();
          stopTime.setHours(7,28);      //set start time to 7:28
          
          //describe each route
          for (var i = route.legs.length - 2; i >= 0; i--){
            var routeSegment = i + 1;
            var end_address = route.legs[i].end_address;
            
            //calculate stop time
            stopTime = new Date(stopTime.getTime() - route.legs[i].duration.value*1000);
            display_stopTime = ("0" + stopTime.getHours()).slice(-2)+ ':' + ("0" + stopTime.getMinutes()).slice(-2);
            stop_times.push({address: end_address, stop_time: display_stopTime, route_segment: routeSegment, duration: route.legs[i].duration.text});
          }
          callback(stop_times);
        } else {
          window.alert('Directions request failed due to ' + status);
        }
    });
}

function getProperty(property, index_num, address_list, callback){  //get property function for geocoding
  callback(address_list[index_num][property]);
}


/* EDIT ROUTE --------------------------------------------------------------*/
document.getElementById('delete-route-btn').addEventListener('click', function() {
  //get route name to send to php doc
  var dropdown = document.getElementById('route-select');
  var selected_route = dropdown.options[dropdown.selectedIndex].text;
  console.log(selected_route);
  
  $.ajax({
    url: './process-php/delete-route.php',
    type: 'POST',
    data: {'route_name': selected_route},
    success: function(response) {
      console.log(response);
      alert ('Successfully deleted route');
      window.location.reload(true); 
    },
    error: function(request, error) {
      console.log("Error", error);
    }
  });
  
});

//if delete is clicked, delete
document.getElementById('delete-route-btn-confirm').addEventListener('click', function() {
  var dropdown = document.getElementById('route-select');
  if (dropdown.options[dropdown.selectedIndex].text == '-- Select a Route --') {
    alert("Please select a route.");
  } else {
    var modal = document.getElementById("deleteConfirmModal");
    modal.style.display = "inline";
  }
});

//if close is clicked, close
document.getElementById('delete-modal-close-btn').addEventListener('click', function() {
  var modal = document.getElementById("deleteConfirmModal");
  modal.style.display = "none";
});

//if cancel is clicked, cancel
document.getElementById('delete-modal-cancel-btn').addEventListener('click', function() {
  var modal = document.getElementById("deleteConfirmModal");
  modal.style.display = "none";
});
  
document.getElementById('edit-route-btn').addEventListener('click', function() {
  //get route name to send to php doc
  var dropdown = document.getElementById('route-select');
  if (dropdown.options[dropdown.selectedIndex].text != '-- Select a Route --') {
    var selected_route = dropdown.options[dropdown.selectedIndex].text;
    
    //EDIT STOPS ---------------------------------------------------------
    //set edit stops combine inner html
    $.ajax({
      url: './process-php/get-stops-list.php',
      type: 'GET',
      data: {'route_name': selected_route},
      success: function(response) {
        console.log(response);
        document.getElementById('edit-stops-combine').innerHTML = response;
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
    
    //set edit stops separate inner html
    $.ajax({
      url: './process-php/get-combined-stops.php',
      type: 'GET',
      data: {'route_name': selected_route},
      success: function(response) {
        console.log(response);
        document.getElementById('edit-stops-separate').innerHTML = response;
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
    
    //set edit students inner html
    //remove students
    $.ajax({
      url: './process-php/get-students-in-route.php',
      type: 'GET',
      data: {'route_name': selected_route},
      success: function(response) {
        console.log(response);
        document.getElementById('edit-student-remove').innerHTML = response;
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
    
    //add students
    $.ajax({
      url: './process-php/unassigned-students-with-id.php',
      type: 'GET',
      data: {'route_name': selected_route},
      success: function(response) {
        console.log(response);
        document.getElementById('edit-student-add').innerHTML = response;
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
    
    //set change driver inner html
    
    //set change admin inner html
    $(document.getElementById("editRouteCard")).collapse("show");
  } else { //if not selected
    alert("Please select a route.");
  }
});

/* HANDLE EDIT STOPS ------------------------------------------------------- */

/* ----------------------- HANDLE COMBINE STOPS ---------------------------- */
function geocodeAddress(location, geocoder, map, marker_type) {
  geocoder.geocode( { 'address': location}, function(results, status) {
  //alert(status);
    if (status == google.maps.GeocoderStatus.OK) {

      //alert(results[0].geometry.location);
      map.setCenter(results[0].geometry.location);
      if (marker_type == 0) {
        createMarker(results[0].geometry.location,map);
      } else {
        createCombinedMarker(results[0].geometry.location,map);
      }
    }
    else
    {
      alert("some problem in geocode" + status);
    }
  }); 
}

//creates a red marker for current stops
function createMarker(latlng,map){
  var marker = new google.maps.Marker({
    position: latlng,
    map: map
  }); 
  markers.push(marker);
}

//creates a green marker for new stop location
function createCombinedMarker(latlng,map){
  var marker = new google.maps.Marker({
    position: latlng,
    map: map,
    icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
  }); 
  markers.push(marker);
}

//takes in address, converts to formatted address
function geocodeStudents(address, callback){
  var geocoder = new google.maps.Geocoder();
  if (geocoder) {
      geocoder.geocode({'address':address}, function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            callback(results[0].formatted_address);
          }
          else {
              throw('No results found: ' + status);
          }
    });
  }
}

//gets checked list of addresses in edit route combine stops card
function getSelectedAddresses() {
  var checkboxes = document.getElementsByName("stop-list-checkbox");
  console.log(checkboxes);
  var checkboxesChecked = [];
  // loop over them all
  for (var i=0; i<checkboxes.length; i++) {
     // And stick the checked ones onto an array...
     if (checkboxes[i].checked) {
        var checkbox_label = checkboxes[i].id;
        checkboxesChecked.push(checkbox_label);
        console.log("test");
        console.log(checkbox_label);
     }
  }
  // Return the array if it is non-empty, or null
  return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}

//gets label of an element
function getLabel(id)
{
  return $("#"+id).next("label").html();
}

//handle combine stops by getting selected addresses and making sql call
document.getElementById('combine-stops-btn').addEventListener('click', function() {
  var selected_addresses = getSelectedAddresses();
  var old_address = document.getElementById("autocomplete").value;
  geocodeStudents(old_address, function(new_address){
      if (selected_addresses == null || selected_addresses.length <= 1) {
      alert("Please select more than 1 address to combine.")
    } else if (new_address == "") {
      alert("Please select the new stop address.")
    } else {
      console.log(selected_addresses);
      //get route name
      var dropdown_route = document.getElementById('route-select');
      var selected_route = dropdown_route.options[dropdown_route.selectedIndex].text;
      
      //set edit stops inner html
      $.ajax({
        url: './process-php/combine-stops.php',
        type: 'POST',
        data: {'selected_addresses': selected_addresses, 'route_name': selected_route, 'new_address': new_address},
        success: function(response) {
          console.log(response);
          alert("Successfully combined stops.");
          window.location.reload(true); 
        },
        error: function(request, error) {
          console.log("Error", error);
        }
      });
    
    }
  });
});

/* ----------------------- HANDLE SEPARATE STOPS ---------------------------- */
document.getElementById('separate-stops-btn').addEventListener('click', function() {
  //get selected route
  var dropdown_route = document.getElementById('route-select');
  var selected_route = dropdown_route.options[dropdown_route.selectedIndex].text;
  
  //get selected address from radio button
  var radios = document.getElementsByName('stop-list-radio');
  var selected_radio = null;
  var anyChecked = false;

  for (var i = 0, length = radios.length; i < length; i++)
  {
   if (radios[i].checked)
   {
    // do whatever you want with the checked radio
    console.log(radios[i].value);
    selected_radio = radios[i].value;
    anyChecked = true;
  
    // only one radio can be logically checked, don't check the rest
    break;
   }
  }
  
  //ajax only if an address is checked
  if (anyChecked) {
    $.ajax({
      url: './process-php/separate-stop.php',
      type: 'POST',
      data: {'selected_radio': selected_radio, 'route_name': selected_route},
      success: function(response) {
        console.log(response);
        alert("Successfully separated stops.");
        window.location.reload(true);
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
  } else {
    alert("Please select a combined stop to separate.")
  }
  
});

/* HANDLE CHANGE DRIVER ---------------------------------------------------- */
document.getElementById('driver-change-btn').addEventListener('click', function() {
  //get new driver
  var dropdown_driver = document.getElementById('driver-select');
  var selected_driver = dropdown_driver.options[dropdown_driver.selectedIndex].text;
  
  if(selected_driver != '-- Select a Driver --') {
    //get route name
    var dropdown_route = document.getElementById('route-select');
    var selected_route = dropdown_route.options[dropdown_route.selectedIndex].text;
  
    //set edit stops inner html
    $.ajax({
      url: './process-php/change-driver.php',
      type: 'POST',
      data: {'driver_name': selected_driver, 'route_name': selected_route},
      success: function(response) {
        console.log(response);
        alert("Successfully changed driver.");
        window.location.reload(true);
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
  } else {
    alert("Please select a driver.");
  }
});


/* HANDLE REMOVE STUDENT ------------------------------------------------- */
function getSelectedRemovedStudents() {
  var checkboxes = document.getElementsByName("student-list-checkbox");
  var checkboxesChecked = [];
  // loop over them all
  for (var i=0; i<checkboxes.length; i++) {
     // And stick the checked ones onto an array...
     if (checkboxes[i].checked) {
        var checkbox_label = getLabel(checkboxes[i].id)
        console.log(checkbox_label);
        checkboxesChecked.push(checkbox_label.split(' | ')[2]);
     }
  }
  // Return the array if it is non-empty, or null
  return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}

document.getElementById('remove-student-btn').addEventListener('click', function() {
  var selected_students = getSelectedRemovedStudents();
  if (selected_students == null) {
    alert("Please select at least one student.")
  } else {
    //console.log(selected_students);
    //get route name
    var dropdown_route = document.getElementById('route-select');
    var selected_route = dropdown_route.options[dropdown_route.selectedIndex].text;
    
    //set edit stops inner html
    $.ajax({
      url: './process-php/remove-student-from-route.php',
      type: 'POST',
      data: {'selected_students': selected_students, 'route_name': selected_route},
      success: function(response) {
        console.log(response);
        alert("Successfully removed student.");
        window.location.reload(true);
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
    
  }
  
});

/* HANDLE ADD STUDENT ---------------------------------------------------- */
function getSelectedAddStudents() {
  var checkboxes = document.getElementsByName("student-checkbox");
  var checkboxesChecked = [];
  // loop over them all
  for (var i=0; i<checkboxes.length; i++) {
     // And stick the checked ones onto an array...
     if (checkboxes[i].checked) {
        var checkbox_label = getLabel(checkboxes[i].id)
        console.log(checkbox_label);
        checkboxesChecked.push(checkbox_label.split(' | ')[1]);
     }
  }
  // Return the array if it is non-empty, or null
  return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}

document.getElementById('add-student-btn').addEventListener('click', function() {
  var selected_students = getSelectedAddStudents();
  if (selected_students == null) {
    alert("Please select at least one student.")
  } else {
    console.log(selected_students);
    //get route name
    var dropdown_route = document.getElementById('route-select');
    var selected_route = dropdown_route.options[dropdown_route.selectedIndex].text;
    
    //set edit stops inner html
    $.ajax({
      url: './process-php/add-student-to-route.php',
      type: 'POST',
      data: {'selected_addresses': selected_students, 'route_name': selected_route},
      success: function(response) {
        console.log(response);
        alert("Successfully added student.");
        window.location.reload(true);
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
    
  }
});

/* HANDLE CHANGE NAME ---------------------------------------------------- */
/* HANDLE FORM ------------------------------------------------------------ */
$('form.ajax-form').on('submit', function() {
  //get route name
  var dropdown_route = document.getElementById('route-select');
  var selected_route = dropdown_route.options[dropdown_route.selectedIndex].text;
  
  var that = $(this),
      url = that.attr('action'),
      type = that.attr('method'),
      data = {};
  
  var changed_name = document.getElementById('new-name').value;

  $.ajax({
    url: url,
    type: type,
    data: {'new_name': changed_name, 'route_name': selected_route},
    success: function(response) {
      console.log(response);
      alert("Successfully changed name.");
      window.location.reload(true);
    },
    error: function(request, error) {
      console.log("Error", error);
    }
  });
  return false;
})

/* GOOGLE MAPS AUTO COMPLETE FUNCTIONS ------------------------------------- */

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle(
          {center: geolocation, radius: position.coords.accuracy});
      autocomplete.setBounds(circle.getBounds());
    });
  }
}

function addLocate() {
  var address = document.getElementById('autocomplete').value;

  $.ajax({
      url: 'https://kflorendo.github.io/bus-app/add-route.php', // to the server
      type: 'POST',
      data: {'address': address},
      success: function(data) {
          alert(data);
      },
      error: function(request, error) {
          console.log("Error", error)
      }
  })

}