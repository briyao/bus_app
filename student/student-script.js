/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Initialize stop location map, handles API call to display stop information
and calculate estimated stop time, handles user request to change status (going/not going)
*/

//initialize the map
function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var geocoder = new google.maps.Geocoder();
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: {lat: 41.85, lng: -87.65}
  });
  
  //plot address
  getAndPlotAddress(directionsService, directionsDisplay, geocoder, map);
}

//get address, plot
function getAndPlotAddress(dirSer, dirDis, geocoder, map) {
  $.ajax({
      url: 'get-stop-address.php',
      type: 'GET',
      data: {'student_id': student_id},
      success: function(response) {
        console.log(response);
        document.getElementById("address-text").innerHTML = response;
        var stud_address = response;
        geocodeAddress(response, geocoder, map);
        seeIfGoing(dirSer, dirDis, stud_address);
      },
      error: function(request, error) {
        console.log("Error", error);
      }
  });
}

//geocode the address for plotting
function geocodeAddress(location, geocoder, map) {
  geocoder.geocode( { 'address': location}, function(results, status) {
  //alert(status);
    if (status == google.maps.GeocoderStatus.OK) {
      //alert(results[0].geometry.location);
      map.setCenter(results[0].geometry.location);
      createMarker(results[0].geometry.location,map);
    }
    else
    {
      alert("some problem in geocode" + status);
    }
  }); 
}

//create marker on map
function createMarker(latlng,map){
  var marker = new google.maps.Marker({
    position: latlng,
    map: map
  }); 
}

function seeIfGoing(dirSer, dirDis, stud_address){
  $.ajax({
      url: 'get-status.php',
      type: 'GET',
      data: {'student_id': student_id},
      success: function(response) {
        if (response == 1){
          getRouteAddresses(dirSer,dirDis,stud_address);
        }
      },
      error: function(request, error) {
        console.log("Error", error);
      }
  });
}
//get the addresses in the route
function getRouteAddresses(dirSer, dirDis, stud_address){
  $.ajax({
      url: 'get-going-stops.php',
      type: 'GET',
      data: {'student_id': student_id},
      success: function(response) {
        console.log(response);
        var address_list = JSON.parse(response);
        
        //calculate the stop times of people going in the route
        calculateTimes(dirSer,address_list,function(stop_times){
          console.log(stop_times);
          for (var i = 0; i < stop_times.length; i++){
            if (stop_times[i]['address'] === stud_address){
              document.getElementById("estimated-time").innerHTML = stop_times[i]['stop_time'];
            }
          }
        });
      },
      error: function(request, error) {
        console.log("Error", error);
      }
  });
}

//calculate stop times of the route
function calculateTimes(directionsService, addresses, callback) {
    waypts = [];
    addresses.forEach(function(a) {
        waypts.push({location: a, stopover: true});
    });
      //call route on directions service object
      directionsService.route({                                         //pass in DirectionsRequest object literal
        origin: "4000 Kozloski Rd, Freehold, NJ 07728",                 //start location
        destination: "765 Newman Springs Rd, Lincroft, NJ 07738",       //end location
        waypoints: waypts,                                              //array of DirectionsWaypoints, each waypoint is an object literal with location and stopover(bool)
        optimizeWaypoints: true,                                        //returning optimized route specified in waypoint_order field
        travelMode: 'DRIVING'
      }, function(response, status) {                                   //callback function
        if (status === 'OK') {
          
          var route = response.routes[0];
          var stop_times = [];
          var stopTime = new Date();
          stopTime.setHours(7,28);                                      //set start time to 7:28
          
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