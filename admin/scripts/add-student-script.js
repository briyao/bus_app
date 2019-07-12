/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Handles geocoding student’s address, handles student add form and delete buttons
*/

/* GOOGLE MAPS AUTO COMPLETE FUNCTIONS ------------------------------------- */
var autocomplete;
function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
  document.getElementById('autocomplete'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components..
  autocomplete.setFields(['address_component']);
  
  var geocoder = new google.maps.Geocoder();
  
  //handle add student form
  document.getElementById("add-button").addEventListener("click", function() {
    //get data from HTML to send in AJAX request
    var data = {};
    var name = document.getElementById("name").value;
    data['name'] = name;
    var address = document.getElementById('autocomplete').value;
    var geocoded_address = '';
    
    if (geocoder) {
        //gecode student's address
        geocoder.geocode({'address':address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              geocoded_address = results[0].formatted_address;
              data['address'] = geocoded_address;
              console.log(data);
              
              //send sql query to update table
              $.ajax({
                url: "./process-php/add-student-process.php",
                type: "POST",
                data: data,
                success: function(response) {
                  //alert user if successful and reload
                  console.log(response);
                  alert("Successfully added student!");
                  window.location.reload(true); 
                },
                error: function(request, error) {
                  console.log("Error", error);
                }
              });
            }
            else {
                throw('No results found: ' + status);
            }
          });
    }
    
  });
  
}

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

/* HANDLE DELETE BUTTONS -------------------------------------------------- */
$(".delete-student-btn").click(function() {
    var $row = $(this).closest("tr"),       // Finds the closest row <tr> 
    
    //get student_id
    $address = $row.find("td:nth-child(1)");  // Finds the 1st <td> element
    
    var id_to_delete = "";

    $.each($address, function() {             // Visits every single <td> element
      id_to_delete = $(this).text();
      console.log($(this).text());            // Prints out the text within the <td>
    });
    
    $.ajax({
      url: './process-php/delete-student.php',
      type: 'POST',
      data: {'student_id': id_to_delete},
      success: function(response) {
        console.log(response);
        alert("Successfully deleted student.");
        window.location.reload(true); 
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
});