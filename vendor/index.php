<?php
    require('../vendor/autoload.php');
    require('../phpqrcode/qrlib.php');
    
    class PDF extends FPDF {
        function AddQRCode($text, $x, $y, $size = 50) {
            $tempDir = sys_get_temp_dir(); // Temporary directory to store the QR code image
    
            // Generate the QR code image using qrlib
            $filename = $tempDir . '/' . uniqid() . '.png';
            QRcode::png($text, $filename, 'H', 10, 2);
    
            // Add the QR code image to the PDF
            $this->Image($filename, $x, $y, $size, $size);
    
            // Delete the temporary QR code image
            unlink($filename);
        }
    
        // Override the Header() method if needed
        function Header() {
            // Add custom header content
        }
    
        // Override the Footer() method if needed
        function Footer() {
            // Add custom footer content
        }
    }
    
    $firstname = "";
    $lastname = "";
    $address = "";
    $phonenumber = "";
    $gender = "";
    $employee = "";
    
    if (isset($_POST['registration'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $phonenumber = $_POST['phonenumber'];
        $gender = $_POST['gender'];
        $employee = $_POST['employee'];
    
        $firstname1 = $firstname;
        $lastname1 = $lastname;
        $address1 = $address;
        $phonenumber1 = $phonenumber;
        $gender1 = $gender;
        $employee1 = $employee;
    
        $firstname = "";
        $lastname = "";
        $address = "";
        $phonenumber = "";
        $gender = "";
        $employee = "";
    
        if (!is_null($firstname1) && !is_null($lastname1) && !is_null($address1) && !is_null($phonenumber1) && !is_null($gender1) && !is_null($employee1)) {
            $connection = mysqli_connect("localhost", "root", "");
            $db = mysqli_select_db($connection, 'group');
    
            $query = "INSERT INTO `users`(`firstname`,`lastname`,`address`,`phonenumber`,`gender`,`employee`) VALUES ('$firstname1','$lastname1','$address1','$phonenumber1','$gender1','$employee1')";
            $query_run = mysqli_query($connection, $query);
    
            if ($query_run) {
                $data = '<h1>Your Details</h1>';
                $data .= '<strong>First Name: </strong>' . $firstname1 .'<br/>';
                $data .= '<strong>Last Name: </strong>' . $lastname1 .'<br/>';
                $data .= '<strong>Address: </strong>' . $address1 .'<br/>';
                $data .= '<strong>Phone Number: </strong>' . $phonenumber1 .'<br/>';
                $data .= '<strong>Gender: </strong>' . $gender1 .'<br/>';
                $data .= '<strong>Employee: </strong>' . $employee1 .'<br/>';
    
                $pdf = new PDF();
                $pdf->AddPage();
    
                // Add data
                $data = '<h1>Your Details</h1><strong>First Name: </strong>Shamsul<br/><strong>Last Name:</strong>Arifeen<br/><strong>Address: </strong>Mirpur-2,Dhaka-1216<br/><strong>Phone Number: </strong>01684251815<br/><strong>Gender: </strong>Male<br/><strong>Employee:</strong>Type-A<br/>';

                $strippedData = strip_tags($data);
                $qrText = $strippedData;
                $pdf->SetFont('Arial', '', 12);
                $pdf->Write(10, $qrText);
                $pdf->Ln(10);
    
                // Add QR code

                
                // Remove HTML tags and extract values
               
                $qrX = $pdf->GetX();
                $qrY = $pdf->GetY();
                $qrSize = 50; // Size of the QR code
                $pdf->AddQRCode($qrText, $qrX, $qrY, $qrSize);
                $pdf->Ln(60);
    
                $pdf->Output('example.pdf', 'D');
            }
        } else {
            echo '<script type="text/javascript">alert("Please Fill Up All Necessary Fields")</script>';
        }
    }
    
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <title>User Registration</title>
</head>
<body>
    <div>
    </div>
    <div>
        <form action="index.php" method="post">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <h1>Registration</h1>
                        <p>Fill Up The Form With Correct Values.</p>
                        <hr class="mb-3">
                        <label for="firstname"><b>First Name</b></label>
                        <input class="form-control" type="text" name="firstname" id="firstname" required>

                        <label for="lastname"><b>Last Name</b></label>
                        <input class="form-control" type="text" name="lastname" id="lastname" required>

                        <label for="address"><b>Address</b></label>
                        <input class="form-control" type="text" name="address" id="address" required>

                        <label for="phonenumber"><b>Phone Number</b></label>
                        <input class="form-control" type="text" name="phonenumber"  id="phonenumber" required>

                       <label for="gender"><b>Gender</b></label>
<select name="gender" class="gender" id="gender" required>
    <option value="">--Select--</option>
    <option value="Male">Male</option>
    <option value="Female">Female</option>
</select>

<label for="employee"><b>Employee</b></label>
<select name="employee" class="employee" id="employee" required>
    <option value="">--Select--</option>
    <option value="Type-A">Type-A</option>
    <option value="Type-B">Type-B</option>
    <option value="Type-C">Type-C</option>
    <option value="Type-D">Type-D</option>
</select>

<hr class="mb-3">
<input class="btn btn-primary" type="submit" name="registration" id="register" value="Registration">
</div>
</div>
</div>
</form>
</div>
</body>
</html>
