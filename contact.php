<div class="contact">
        <div class="contactImg">
            <img src="pointing.png" alt="Not Found">
        </div> 
        <form action="" method="POST">
            <h2>Get In Touch</h2>
            <div class="fromAddress">
                <div class="detail">   
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <p>Address: <span>Puducherry</span></p>
                </div>
                <div class="detail">
                <i class="fas fa-envelope-open" aria-hidden="true"></i>
                <p>Email Id: <span>nived01@gmail.com</span></p>
                </div>
                <div class="detail">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <p>Phone No: <span>8304918055</span></p>
                </div>
            </div>
            <input type="text" class="fromField" placeholder="Name" name="name">
            <input type="text" class="fromField" placeholder="Phone No" name="phone">
            <input type="email" class="fromField" placeholder="Email Id" name="email">
            <input type="text" class="fromField" placeholder="Subject" name="subject">
            <textarea name="message" placeholder="Message" class="fromField"></textarea>
            <div class="fromBtn">
                <input type="submit" class="fbtn" value="Submit" name="contactSubmit">
                <!-- <input type="reset" class="fbtn" value="Reset" name="reset"> -->
            </div>
        </form>
        <?php
          if(isset($_POST['contactSubmit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];
          
            $query = "INSERT INTO contact (name, email, phone, subject, message) VALUES ('$name', '$email', '$phone', '$subject', '$message')";
            $result = mysqli_query($conn, $query);
            
            if($result) {
                echo '<script>alert("Message sent successfully!")</script>';
            } else {
                echo '<script>alert("Error sending message. Please try again later.")</script>';
            }  
            
        }
                ?>
    </div>