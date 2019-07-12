/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Initialize route map, handles API call to display stop information and 
                  route on map, adjusts route based on if students are going/not going
*/

//initialize the map
function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var geocoder = new google.maps.Geocoder();
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: {lat: 40.33, lng: -74.13}
  });
  
  //display the map, calcualte route
  directionsDisplay.setMap(map);
  getRouteAddresses(directionsService, directionsDisplay);
}

function getRouteAddresses(dirSer, dirDis) {
    //1. get route_num
    //2. get addresses of people going in route num
    //3. display route
    //4. display info

    //1. get route_num
    $.ajax({
        url: 'get-route-num.php',
        type: 'GET',
        data: {'driver_id': driver_id},
        success: function(response) {
          console.log(response);
          var route_num = JSON.parse(response); //get route_num

          //2. get addresses of people going in route_num
          $.ajax({
            url: 'get-addresses-for-route.php',
            type: 'GET',
            data: {'route_num': route_num},
            success: function(response) {
              var address_list = JSON.parse(response);
              console.log(address_list);
              //display the route, create dictionary of addresses, stop_times
              displayRoute(dirSer, dirDis, address_list, function(stop_times){
                var summaryPanel = document.getElementById('routeinfo');
                summaryPanel.innerHTML = '';
                var stops_array = [];
                var stopInfo = '';
                console.log(stop_times);
                
                //display information about each stop
                createStopsArray(stop_times, route_num, function(stops_array){
                  orderStopsArray(stops_array, function(ordered_stops){
                    for (var j = 0; j < ordered_stops.length; j++){
                      summaryPanel.innerHTML += ordered_stops[j];
                    }
                  });
                });
              });
            },
            error: function(request, error) {
              console.log("Error", error);
            }
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
function createStopsArray(stop_times, route_num, callback){
  var stops_array = [];
  
  //loop through stops_array
  for (var i = stop_times.length-1; i >= 0; i--){
    
    //get the stop info
    createStopInfo(stop_times, route_num, i, function(stopInfoArray){
      stops_array.push(stopInfoArray);
      if (stops_array.length === stop_times.length){
        //document.getElementById('routeinfo').innerHTML += 'length: ' + stops_array.length;
        callback(stops_array);
      }
    })
  }
}

//return array of route_segment and stop information
function createStopInfo(stop_times, route_num, index, callback){
  $.ajax({
    url: 'get-students-at-stop.php',
    type: 'GET',
    data: {'route_num': route_num, 'address': stop_times[index]['address']},
    success: function(response) {
      //get response
      var students_in_route = JSON.parse(response);
      console.log(students_in_route);
      
      var stopInfo = '';
      //display stop number
      stopInfo += '<b>Stop: ' + stop_times[index]['route_segment'] + '</b><br>';
      
      //display names
      stopInfo += 'Student(s): ';
      
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

//display the route
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

