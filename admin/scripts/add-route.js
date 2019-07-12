/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Initializes and handles displaying stops on preview map, handles API call to display route information, 
handles creation of route by sending info to new-route-process.php
*/

//initialize map
function initMap() {
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer;
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 6,
      center: {lat: 40.33, lng: -74.13}
    });
    
    //if refresh clicked
    document.getElementById('refresh').addEventListener('click', function() {
      //display route
      directionsDisplay.setMap(map);
      displayRoute(directionsService, directionsDisplay, function(stop_times){ //return stop information
      
        //get selected names
        getSelectedDictionary(function(student_names){    //return name and address
        
          //display information
          displayInfo(stop_times, student_names);
        });
      });
    });
    
    
    //create a route
    document.getElementById('create-route-btn').addEventListener('click', function() {
      
      //display route
      directionsDisplay.setMap(map);
      displayRoute(directionsService, directionsDisplay, function(stop_times){
        
        //get selected names
        getSelectedDictionary(function(student_names){
          
          //display information
          displayInfo(stop_times, student_names);
          
          //create dictionary of stops, names, addresses, time
            createTimeAddress(stop_times, student_names, function(student_address_time){
              
              //generate the route, update sql table
              generateNewRoute(student_address_time);
              console.log(student_address_time);
          });
        });
      });
    });
}

//display route on map
function displayRoute(directionsService, directionsDisplay, callback) {
    waypts = [];
    var checkedBoxes = getSelectedAddresses();
    
    if (checkedBoxes != null) {
      checkedBoxes.forEach(function(address) {
          waypts.push({location: address, stopover: true});
      });
      console.log(waypts);
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
  } else {
    alert("Please select 1 or more addresses to add to route.");
  }
}

//display information given stop_times, student_address (name and addresses)
function displayInfo(stop_times, student_address){
  //geocoded address has name, address
  var summaryPanel = document.getElementById('routeinfo');
  summaryPanel.innerHTML = '';
  
  //loop through stop_times array
  for (var i = stop_times.length - 1; i >= 0; i--){
    
    //describe each in html
    summaryPanel.innerHTML += '<b>Stop: ' + stop_times[i]['route_segment'] + '</b><br>';
    var address = '';
    studentloop:
    for (var j = 0; j < student_address.length; j++){
      if (stop_times[i]['address'] === student_address[j]['address']){
        summaryPanel.innerHTML += 'Student: ' + student_address[j]['name'] + '<br>';
        address = student_address[j]['address'];
        break studentloop;
      }
    }
    summaryPanel.innerHTML += 'Address: ' + address + '<br>';
    summaryPanel.innerHTML += 'Stop Time: ' + stop_times[i]['stop_time'] + '<br><br>';
  }
}

//concatenate stop_times and name_address dictionaries
function createTimeAddress(stop_times, student_addresses, callback){
  //geocoded_addresses is name, address, geocoded_address
  var student_address_time = [];
  for (var i = 0; i < stop_times.length; i++){
        studentloop:
        for (var j = 0; j < student_addresses.length; j++){
          if (stop_times[i]['address'] === student_addresses[j]['address']){
            console.log('success');
            student_address_time.push({name: student_addresses[j]['name'], address: student_addresses[j]['address'], stop_time: stop_times[i]['stop_time']});
            break studentloop;
          }
        }
      }
    console.log(student_address_time);
    callback(student_address_time);
}

//get property function for geocoding
function getProperty(property, index_num, address_list, callback){ 
  callback(address_list[index_num][property]);
}

//get addresses to display to user
function getSelectedAddresses() {
  var checkboxes = document.getElementsByName("student-checkbox");
  var checkboxesChecked = [];
  // loop over them all
  for (var i=0; i<checkboxes.length; i++) {
     // And stick the checked ones onto an array...
     if (checkboxes[i].checked) {
        var checkbox_label = getLabel(checkboxes[i].id)
        checkboxesChecked.push(checkbox_label.split(' | ')[1]);
     }
  }
  // Return the array if it is non-empty, or null
  return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}

//get name and address dictionary
function getSelectedDictionary(callback) {
  var checkboxes = document.getElementsByName("student-checkbox");
  var checkboxesChecked = [];
  // loop over them all
  for (var i=0; i<checkboxes.length; i++) {
     // And stick the checked ones onto an array...
     if (checkboxes[i].checked) {
        var checkbox_label = getLabel(checkboxes[i].id);
        var label_contents = checkbox_label.split(' | '); //0 is name, 1 is address
        var student_name = label_contents[0];
        var student_address = label_contents[1];
        checkboxesChecked.push({name: student_name, address: student_address});
     }
  }
  // Return the array if it is non-empty, or null
  callback(checkboxesChecked.length > 0 ? checkboxesChecked : null);
}

function getLabel(id)
{
  return $("#"+id).next("label").html();
}

//generate route, update sql table with route results
function generateNewRoute(student_list) {
  var dropdown = document.getElementById('driver-select');
  var selected_driver = dropdown.options[dropdown.selectedIndex].text;
  console.log(selected_driver);
  
  if (selected_driver !== '-- Select a Driver --'){
    $.ajax({
      url: './process-php/new-route-process.php',
      type: 'POST',
      data: {'driver_name': selected_driver, 'stud_add_list': student_list},
      success: function(response) {
        console.log(response);
        alert('Successfully added route');
        window.location.reload(true); 
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
  }
  else{
    alert('Please select a driver for route.');
  }
}
