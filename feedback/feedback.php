<!--
Project Name: Bus App
Team Members: Katrina Florendo, Laura Futamura, Brianna Yao
Date: 6/11/19
Task Description: Includes HTML elements for feedback page
-->

<!DOCTYPE html>
<html>
    <head>
        <link href="../css/sb-admin-2.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    
    <title>Feedback Form</title>
    
    <body>
        <div class="container contact feedback-body">
        	<div class="row">
        		<div class="feedback-col-md-3 col-md-3">
        			<div class="contact-info">
        			    <br>
    			        <i class="material-icons icon-button">mail_outline</i>
        				<h2>Give us your feedback</h2>
        				<h4>Let us know what we could improve!</h4>
        			</div>
        		</div>
        		<div class="feedback-col-md-9 col-md-9">
        		    <!-- start submit feedback form -->
                    <form class="ajax-form">
                        <div class="form-group">
                            
                            <!-- first name -->
        				  <label class="control-label col-sm-2" for="fname">First Name:</label>
        				  <div class="col-sm-10">          
        					<input type="text" class="form-control" placeholder="Enter First Name" id="fname-text" name="fname-text">
        				  </div>
        				</div>
        				<div class="form-group">
        				    
        				     <!-- last name -->
        				  <label class="control-label col-sm-2" for="lname">Last Name:</label>
        				  <div class="col-sm-10">          
        					<input type="text" class="form-control" placeholder="Enter Last Name" id="lname-text" name="lname-text">
        				  </div>
        				</div>
        				<div class="form-group">
        				     <!-- email -->
        				  <label class="control-label col-sm-2" for="email">Email:</label>
        				  <div class="col-sm-10">          
        					<input type="text" class="form-control" placeholder="Enter Email" id="email-text" name="email-text">
        				  </div>
        				</div>
        				
        				<div class="form-group">
        				     <!-- comment -->
        				  <label class="control-label col-sm-2" for="comment">Comment:</label>
        				  <div class="col-sm-10">
        					<textarea class="form-control" rows="5" placeholder="Enter Comment" id="comment-text" name="comment-text"></textarea>
        				  </div>
        				</div>
        				
        				<div class="form-group">  
        				 <!-- submit -->
        				  <div class="col-sm-offset-2 col-sm-10">
        					<button type="button" class="btn btn-primary" id="submit-feedback-btn">Submit</button>
        				  </div>
        				</div>
                    </form>
                    <!-- end submit feedback form -->
                    <a href="../index.html" class='col-sm-2'>Go back to homepage</a>
        		</div>
        	</div>
        </div>
        <script src="../vendor/jquery/jquery.min.js"></script>
        
        <script src="./feedback-script.js"></script>
        
    </body>
</html>