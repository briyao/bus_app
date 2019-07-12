/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Handles form to create new driver and delete buttons in each row of table
*/

var del_id_for_modal = "";

/* HANDLE FORM ------------------------------------------------------------ */
$('form.ajax-form').on('submit', function() {
  //get data values from HTML form
  var that = $(this),
      url = that.attr('action'),
      type = that.attr('method'),
      data = {};
  that.find('[name]').each(function(index, value) {
    var that = $(this),
        name = that.attr('name'),
        value = that.val();
    data[name] = value;
  });
  console.log(data);
  
  //send request to add-driver-process.php
  $.ajax({
    url: url,
    type: type,
    data: data,
    success: function(response) {
      //alert user and reload if successful
      console.log(response);
      alert("Successfully added driver.");
      window.location.reload(true);
    },
    error: function(request, error) {
      console.log("Error", error);
    }
  });
  return false;
})

/* HANDLE DELETE BUTTONS -------------------------------------------------- */
$(".delete-driver-btn").click(function() {
    var $row = $(this).closest("tr"),       // Finds the closest row <tr> 
    
    //get driver_id
    $address = $row.find("td:nth-child(1)");  // Finds the 1st <td> element
    
    var id_to_delete = "";

    $.each($address, function() {             // Visits every single <td> element
      id_to_delete = $(this).text();
      console.log($(this).text());            // Prints out the text within the <td>
    });
    
    $.ajax({
      url: './process-php/delete-driver.php',
      type: 'POST',
      data: {'driver_id': id_to_delete},
      success: function(response) {
        if (response != "change driver") {
          //alert user if successful
          console.log(response);
          alert("Successfully deleted driver.");
          window.location.reload(true);
        } else {
          //opens change driver modal if driver to be deleted has route
          var modal = document.getElementById("selectNewDriverModal");
          modal.style.display = "inline";
          del_id_for_modal = id_to_delete;
        }
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
});

//handle buttons that close modal
document.getElementById('delete-modal-close-btn').addEventListener('click', function() {
  var modal = document.getElementById("selectNewDriverModal");
  modal.style.display = "none";
});

document.getElementById('delete-modal-cancel-btn').addEventListener('click', function() {
  var modal = document.getElementById("selectNewDriverModal");
  modal.style.display = "none";
});

document.getElementById('change-driver-btn').addEventListener('click', function() {
  //get selected driver from dropdown
  var dropdown_driver = document.getElementById('driver-select');
  var selected_driver = dropdown_driver.options[dropdown_driver.selectedIndex].text;
  
  //send request to replace-driver.php
  $.ajax({
      url: './process-php/replace-driver.php',
      type: 'POST',
      data: {'selected_driver': selected_driver, 'delete_driver_id': del_id_for_modal},
      success: function(response) {
        console.log(response);
        alert("Successfully replaced driver.");
        window.location.reload(true);
      },
      error: function(request, error) {
        console.log("Error", error);
      }
    });
    
});