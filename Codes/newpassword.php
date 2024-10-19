<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"integrity="sha512k6RqeWeci5ZR/Lv4MR0sA0FfDOM1M4J63cK6aVNgJkm6x0UAA2gHiR3q3IHcd6jTbtWzHC3DzRFbbKJIF1l3Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">

<title>Reset Password</title>
<link rel="icon" href="MediVault.png" type="image/x-icon">
<style>
     body {
  width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: -webkit-linear-gradient(left, #14ab56, #007bff);
  box-sizing: border-box;

        }
        *, *:before, *:after{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
        }
</style>
</head>
<body>
    <div class="cont">
<div class="forgot-container">
    <form class="forgot-password-form" id="forgot-password-form" action="update_password.php" method="post">
        <div class="form-header">
            <img src="MediVault.png" alt="Profile Picture">
            <span>Welcome To MediVault</span>
        </div>
        <div class="solid-line"></div>
        <h2>Reset Password</h2>
        <div class="input-group">
            <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        </div>
        <div class="input-group">
            <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>
        </div>
        <div class="input-group">
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm new password" required>
        </div>
        <button type="submit" class="submit">Reset Password</button>
        <div class="message"></div>
    </form>
</div>
<div class="sub-cont">
    <div class="img">
        <div class="img-text m-up">
            <h2>New here?</h2>
            <p>Sign up and discover great amount of new opportunities!</p>
          </div>
          <div class="img-btn" id="redirect-btn">
            <span class="m-up">Sign Up</span>
            <span class="m-in">Sign In</span>
          </div>
    </div>
    </div>
</div>
    <script>
        ///////////////////////redirect to the login page 
         document.getElementById("redirect-btn").addEventListener("click", function() {
    window.location.href = "login.html"; // Change this to your actual login page URL
  });
  /////////////////////////////////////////////////////////////
    </script>
</body>
</html>
