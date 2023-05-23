<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JComponent Registration Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
    <h1 class="heading">J COMPONENT REGISTRATION</h1>

    <h2>Team  Details</h2>


    <form action="test.php" method="post" onsubmit="return validate()" enctype="multipart/form-data">
    <label for="regno">Registration Number:</label>
    <input type="text" name="regno[]" id="reg_no" required><br>

    <label for="name">Name:</label>
    <input type="text" name="name[]" id="name" required><br>

    <label for="Phone_no">Phone Number:</label>
    <input type="phone" name="phone[]" id="phone_no" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email[]" id="email_id" required><br>


    <div id="members">
			
	</div>

    
	<button type="button" onclick="addTeamMember()">Add Team Member</button>


    <h2>Project Details</h2>

    <label for="title">Project Title:</label>
    <input type="text" id="title" name="title" required><br>

    <label for="abstract">Project Abstract:</label>
    <textarea id="abstract" name="abstract" required></textarea><br>

    <label for="functionalities">Project Functionalities:</label>
    <textarea id="functionalities" name="functionalities" required></textarea><br>

    <label for="resources">Resources Required:</label>
    <textarea id="resources" name="resources" required></textarea><br>

    <label for="data_model">Data Model (JPG only):</label>
    <input type="file" id="data_model" name="data_model" accept="image/jpeg" ><br>
    
    



	<button type="submit" name="submit">Submit</button>

    </form>

    </div>

    <script>
    var memberCount = 1;
    var membersDiv = document.getElementById("members");
    var addMemberButton = document.getElementById("add-member");
    function addTeamMember(){
      memberCount++;
      var memberDiv = document.createElement("div");
      memberDiv.classList.add("member");
      memberDiv.innerHTML = `
        <label for="regno">Registration Number:</label>
        <input type="text" id="reg_no" name="regno[]" required><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name[]" required><br>
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone_no" name="phone[]" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email_id" name="email[]" required><br>
      `;
      membersDiv.appendChild(memberDiv);
    };

    function validateRegistrationNumber(registrationNumber) {
			
			var pattern = /^\d{2}[A-Za-z]{3}\d{4}$/;
			return pattern.test(registrationNumber);
		}

		
    function validatePhoneNumber(phoneNumber) {
			
			var pattern = /^\+91\d{10}$/;
			return pattern.test(phoneNumber);
		}

	function validateEmail(email) {
			
			var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
			return pattern.test(email);
		}

function validate(){
    let registrationNumbers = document.getElementsByName('regno[]');
	let phoneNumbers = document.getElementsByName('phone[]');
	let emails = document.getElementsByName('email[]');

    for (var i = 0; i < registrationNumbers.length; i++) {
				if (!validateRegistrationNumber(registrationNumbers[i].value)) {
					alert('Invalid registration number format!');
					return false;
				}

				if (!validatePhoneNumber(phoneNumbers[i].value)) {
					alert('Invalid phone number format!');
					return false;
				}

				if (!validateEmail(emails[i].value)) {
					alert('Invalid email format!');
					return false;
				}
			}

			return true;



}
</script>

<?php 

if (isset($_POST['submit'])) {
	$reg_num = $_POST['regno'];
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
    $project_title = $_POST['title'];
    $abstract = $_POST['abstract'];
    $functionalities = $_POST['functionalities'];
    $resources = $_POST['resources'];
    $data_model_name = $_FILES['data_model']['tmp_name'];
    
    echo "data was submitted successfully ";

    function openconnection(){
    $dbhost = 'localhost';
    $dbuser = 'root';
    $password = '';
    $db = 'neha';
    $conn = new mysqli($dbhost,$dbuser,$password,$db) or die ("connection failed".$conn->error);
    return $conn;
}

function closeconnection($conn)
{
    $conn->close();
}

$conn = openconnection();
echo "connected successfully"; 

foreach ($reg_num as $value) {
    $stmt = $conn->prepare("INSERT INTO table_name (regno) VALUES (?)");
    $stmt->bind_param("s", $value);
    $stmt->execute();
}
foreach ($name as $value) {
    $stmt = $conn->prepare("INSERT INTO table_name (name) VALUES (?)");
    $stmt->bind_param("s", $value);
    $stmt->execute();
}

foreach ($phone as $value) {
    $stmt = $conn->prepare("INSERT INTO table_name (phone) VALUES (?)");
    $stmt->bind_param("s", $value);
    $stmt->execute();
}
foreach ($email as $value) {
    $stmt = $conn->prepare("INSERT INTO table_name (email) VALUES (?)");
    $stmt->bind_param("s", $value);
    $stmt->execute();
}
//$image = $_FILES['data_model']['tmp_name'];
$image_data = file_get_contents($image);
$sql = 'INSERT INTO project_details values (?,?,?,?,?)';
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssb',$project_title,$abstract,$functionalities,$resources,$image_data);
$stmt->execute();

echo "Record inserted successfully in the database";

closeconnection($conn);
}



?>

</body>
</html>
