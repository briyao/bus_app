/*
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Gets form values from feedback.php and sends to save-feedback.php to process
*/

//send feedback
document.getElementById("submit-feedback-btn").addEventListener("click", function() {
    
    var fname = document.getElementById('fname-text').value;
    var lname = document.getElementById('lname-text').value;
    var email = document.getElementById('email-text').value;
    var comment = document.getElementById('comment-text').value;
    
    $.ajax({
        url: 'save-feedback.php',
        type: 'POST',
        data: {'fname': fname, 'lname': lname, 'email': email, 'comment': comment},
        success: function(response) {
          console.log(response);
          alert ('Thank you for giving us your feedback!');
          //reload page
          window.location.reload(true);
        },
        error: function(request, error) {
          console.log("Error", error);
        }
    });
    
});
