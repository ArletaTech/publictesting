<!--
    info_form ver1.0
    initial
    upload image
    add hidden button
-->

<?php 
  $user_name = get_post_meta( get_the_ID(), 'name', true);

?>
<!DOCTYPE html>
<html >
	<head>
	<meta name="info form" content="width=device-width, initial-scale=1">
	<title>info form</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>	
	</head>
	<body>
<div class="form">
    <div style="width:100%;">
		<image src= "https://arlink.arleta.my/wp-content/uploads/2023/09/background-1-150x150.jpg" class="background">	</image>
		

	</div>

    <div class="form__avatar">
		<image src= "https://arlink.arleta.my/wp-content/uploads/2023/09/user.png" 	class="username"></image></div>
			<div class="form__title">Fill the form</div>
            <div class="form__subtitle">Information</div><div class="edit-form-container">
    <button id="edit-button"> 
        <i class="fas fa-pencil-alt"></i> 
    </button>
    <form id="hidden-form" style="display: none;">
   
       <div class="form__wrapper" >
        <input type="text" placeholder="Name" id="name_textbox"><br>
        <input type="text" placeholder="Occupation" id="occupation_textbox"><br>
        <textarea required="required" id="shortDesc_textarea"></textarea> 
		<span>short decription..</span><br>
		
		<form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Select an image:</label><br>
        <input type="file" name="image" id="image" accept="image/*"><br>
        <input type="submit" value="Upload Image">
    </form>
 </form>
		<div>
			<button type="button" onclick="setData()" class="form__btn">Save</button>
		</div>
		<div class="popup" id="popup">
			<h2>Saved</h2>
			<p>Your data successfully saved!</p>
			<button type="button" onclick="closePopup()">OK</button>
		</div>
	
		
			
		</div></form>
    </form>
</div><br>
		<div style="display: flex;">
			<a class="form__btn form__btn-solid" href="https://chat.openai.com/">chatGpt</a>
            <a class="form__btn form__btn-solid" href="https://wa.link/l0wpiw">Whatsapp</a>
		</div><br>
	</div>
</div><br><br>

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
    const fileInput = document.querySelector('input[type="file"]');
    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, or GIF).');
            fileInput.value = ''; // Clear the file input
        }
    });
	
document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('edit-button');
    const hiddenForm = document.getElementById('hidden-form');

    editButton.addEventListener('click', function() {
        if (hiddenForm.style.display === 'none' || hiddenForm.style.display === '') {
            hiddenForm.style.display = 'block';
        } else {
            hiddenForm.style.display = 'none';
        }
    });
});


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

/*.form__avatar svg {
  width: 100px;
  height: 100px;
}*/

.form__title {
  /*margin-top: 60px;*/
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
	border-radius: 5%;
	margin: 10px;
}
	.edit-form-container {
    position: relative;
}

#edit-button {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: #007bff;
    display: relative;
    align-items: center;
}

#edit-button i.fa-pencil {
    margin-right: 5px;
}

#hidden-form {
    display: none;
    position: relative;
    top: 0;
    right: 0;
    background-color: #fff;
    padding: 10px;
    border: 1px solid #ccc;
}

</style><br><br><br>