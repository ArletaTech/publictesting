<!--
    info_form ver1.0
    initial
    upload image form
-->

<?php 
  $user_name = get_post_meta( get_the_ID(), 'name', true);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $targetDirectory = "uploads/"; // Create a directory called "uploads" in the same directory as this script
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = true;

    // Check if the file is an image
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = false;
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, the file already exists.";
        $uploadOk = false;
    }

    // Check file size (optional)
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = false;
    }

    if ($uploadOk) {
        // Upload the file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";

            // Check the file type and resize accordingly
            if (in_array($imageFileType, ['jpg', 'jpeg'])) {
                resizeJPGImage($targetFile, 1024, 1024, 60);
            } elseif ($imageFileType === 'png') {
                resizePNGImage($targetFile, 512, 512);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Invalid request.";
}

function resizeJPGImage($filename, $max_width, $max_height, $quality) {
    list($orig_width, $orig_height) = getimagesize($filename);
    $ratio = min($max_width / $orig_width, $max_height / $orig_height);

    $new_width = $orig_width * $ratio;
    $new_height = $orig_height * $ratio;

    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromjpeg($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

    imagejpeg($image_p, $filename, $quality);
    imagedestroy($image_p);
}

function resizePNGImage($filename, $max_width, $max_height) {
    list($orig_width, $orig_height) = getimagesize($filename);
    $ratio = min($max_width / $orig_width, $max_height / $orig_height);

    $new_width = $orig_width * $ratio;
    $new_height = $orig_height * $ratio;

    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefrompng($filename);

    imagealphablending($image_p, false);
    imagesavealpha($image_p, true);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

    imagepng($image_p, $filename);
    imagedestroy($image_p);
}


?>
<!DOCTYPE html>
<html >
	<head>
	<meta name="info form" content="width=device-width, initial-scale=1">
	<title>info form</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>	
	</head>
	<body>
<div class="form">
    <div style="width:100%;">
		<image src= "https://arlink.arleta.my/wp-content/uploads/2023/09/background-1-150x150.jpg" class="background">	</image>
	</div>

    <div class="form__avatar">
	<image src= "https://arlink.arleta.my/wp-content/uploads/2023/09/user.png" 	class="username">	
	</div>

    <div class="form__title">Fill the form</div>

    <div class="form__subtitle">Information</div>

    <div class="form__wrapper">
        <input type="text" placeholder="Name" id="name_textbox"><br>
        <input type="text" placeholder="Occupation" id="occupation_textbox"><br>
        <textarea required="required" id="shortDesc_textarea"></textarea> 
		<span>short decription..</span><br>
        
        <h2>Upload an Image</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Select an image:</label>
        <input type="file" name="image" id="image" accept="image/*">
        <input type="submit" value="Upload Image">
    </form>

		<div>
			<button type="button" onclick="setData()" class="form__btn">Save</button>
		</div>
		<div class="popup" id="popup">
			<h2>Saved</h2>
			<p>Your data successfully saved!</p>
			<button type="button" onclick="closePopup()">OK</button>
		</div>

		
        <div style="display:flex;">
			<a class="form__btn form__btn-solid" href="https://chat.openai.com/">chatGpt</a>
            <a class="form__btn form__btn-solid" href="https://wa.link/l0wpiw">Whatsapp</a>
		</div>
    </div>
</div>

<script>
		let popup = document.getElementById("popup");
		function openPopup(){
			popup.classList.add("open-popup");
		}
		function closePopup(){
			popup.classList.remove("open-popup");
		}
	</script>
		<?php
		echo $user_name;
	?>
</body>
<script>
function setData() {
  var nameField = document.getElementById("name_textbox").value;
  var occupationField = document.getElementById("occupation_textbox").value;
  var shortDescField = document.getElementById("shortDesc_textarea").value;
  console.log(nameField);
	console.log(occupationField);
	console.log(shortDescField);
  $.ajax({
    type: "POST",
    url: 'https://arlink.arleta.my/resources/info_form.php',
    data: {
        'name': nameField,
        'occupation': occupationField,
        'shortDesc': shortDescField,
    },
    cache: false,
    success: function(data) {
        console.log(data);
        openPopup();
      /*  console.log("name:"+nameField);
        alert('name:'+nameField);*/
		
    }
  });
}
</script>
<style>
.form {
  --main-color: #000;
  --submain-color: #78858F;
  --bg-color: #fff;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  position: relative;
  width: 500px;
  height: 650px;
  display: flex;
  flex-direction: column;
  align-items: center;
  border-radius: 20px;
  background: var(--bg-color);
}

.background {
  height: 192px;
  width: 100%;
	border-radius: 30px;
	
}

.form__img svg {
  height: 100%;
  border-radius: 20px 20px 0 0;
}

.username {
  position: relative;
  width: 114px;
  height: 114px;
  background: var(--bg-color);
  border-radius: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  top: calc(50% -20px);
}


.form__title {
  margin-top: 60px;
  font-weight: 500;
  font-size: 18px;
  color: var(--main-color);
}

.form__subtitle {
  margin-top: 10px;
  font-weight: 400;
  font-size: 15px;
  color: var(--submain-color);
}

.form__btn {
  margin-top: 15px;
  width: 76px;
  height: 31px;
  border: 2px solid var(--main-color);
  border-radius: 4px;
  font-weight: 700;
  font-size: 11px;
  color: var(--main-color);
  background: var(--bg-color);
  text-transform: uppercase;
  transition: all 0.3s;
}

.form__btn-solid {
  background: var(--main-color);
  color: var(--bg-color);
  
}

.form__btn:hover {
  background: var(--main-color);
  color: var(--bg-color);
}

.form__btn-solid:hover {
  background: var(--bg-color);
  color: var(--main-color);
}
input[type="text"] {
  width: 300px; /* Adjust the width as needed */
  padding: 10px;
  margin: 10px;
}
textarea[required="required"]{
  width: 150px; /* Adjust the width as needed */
  padding: 10px;
  margin: 10px
}
.popup{
	width:200px;
	background:#E0E0E0;
	border-radius:6px;
	border-color:#000000;
	position:absolute;
	top:0;
	left:50%;
	transform:translate(-50%, -50%)scale(0.1);
	text-align:center;
	padding: 0 30px 30px;
	color:#333;
	visibility:hidden;
	transition: transform 0.4s,top 0.4s;
}
.open-popup{
	visibility:visible;
	top:50%;
	transform:translate(-50%, -50%)scale(1);
}
.popup h2{
	font-size:38px;
	font-weight:500;
	margin:30px 0 10px;
}
.form__btn {
	display:flex;
	flex: 1;
	justify-content: center;
	font-size: 14px;
	text-align:center;
    padding: 8px;
	text-decoration: none;
	margin:10px;

}
</style>