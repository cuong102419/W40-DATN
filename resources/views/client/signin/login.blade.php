
  <title>Login/Signin</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: rgb(252, 252, 252);
      position: relative;
    }

    .wrapper {
      position: relative;
      width: 800px;
      height: 500px;
      display: flex;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 5px;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }

    .form-container {
      width: 50%;
      height: 100%;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: white;
      transition: opacity 0.5s ease-in-out;
      z-index: 2;
    }

    .form-container1 {
      width: 50%;
      height: 100%;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: rgb(255, 255, 255);
      transition: opacity 0.5s ease-in-out;
      z-index: 2;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 50%;
      width: 50%;
      height: 100%;
      background: orange;
      transition: transform 0.5s ease-in-out;
      z-index: 3;
    }

    .show-signup .overlay {
      transform: translateX(-100%);
      background: rgb(76, 76, 217);
      /* Đổi sang màu xanh khi chuyển sang Sign Up */
    }

    .show-signup #signup-container {
      opacity: 1;
      pointer-events: auto;
    }

    .form-container h2 {
      color: #322dc7;
      font-size: 24px;
      margin-bottom: 15px;
    }

    .form-container1 h2 {
      color: #f33535;
      font-size: 24px;
      margin-bottom: 15px;
    }

    .form-container input {
      width: 90%;
      padding: 12px;
      margin: 10px 0;
      border: 2px solid #3473cc;
      border-radius: 8px;
      font-size: 16px;
    }

    .form-container1 input {
      width: 90%;
      padding: 12px;
      margin: 10px 0;
      border: 2px solid #de5318;
      border-radius: 8px;
      font-size: 16px;
    }

    .form-container1 button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(45deg, #e4dc43, #ff3300);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
      transition: 0.3s;
    }

    .form-container button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(45deg, #284cc2, #4fbcb3);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 18px;
      font-weight: bold;
      transition: 0.3s;
    }

    .form-container1 button:hover {
      background: linear-gradient(45deg, #fa3503, #cc0000);
    }

    .form-container button:hover {
      background: linear-gradient(45deg, #5e53db, #650efb);
    }

    .remember-container {
      display: flex;
      align-items: center;
      /* Căn giữa theo chiều dọc */
      justify-content: space-between;
      width: 90%;
    }

    .remember-container label {
      display: flex;
      align-items: center;
      gap: 5px;
      /* Tạo khoảng cách giữa checkbox và văn bản */
    }

    .remember-container a {
      text-decoration: none;
      color: rgb(105, 105, 248);
    }
    a{
      text-decoration: none;
      color: white;
    }
    .btn {
      border: #c2a628;
      background: #d26420;
      width: 100px;
      height: 40px;
    }
    .btn:hover{
      background: #be2113;
    }
  </style>
</head>
<button class="btn"><div class=""><a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Home</a></button>
<body>
  <div class="wrapper" id="form-wrapper">
    <div class="form-container1" id="login-container">
      
      <h2>Sign in</h2>
      <input type="text" id="login-username" placeholder="Username">
      <input type="password" id="login-password" placeholder="Password">
      <div class="remember-container">
        <label><input type="checkbox" id="remember-me"> Remember</label>
        <a href="#" class="toggle-link">Forgot Password?</a>
      </div>
      <button onclick="login()">Sign In</button>
      <p class="toggle-link" onclick="showSignup()">Don't have an account? Sign Up</p>
    </div>

    <div class="form-container" id="signup-container">
      <h2>Create an Account</h2>
      <input type="email" id="signup-email" placeholder="Email">
      <input type="text" id="signup-username" placeholder="Username">
      <input type="password" id="signup-password" placeholder="Password">
      <input type="password" id="signup-confirm-password" placeholder="Confirm Password">
      <div class="remember-container">
        <label><input type="checkbox" id="remember-me"> Remember</label>
        <a href="#" class="toggle-link">Forgot Password?</a>
      </div>
      <button onclick="signup()">Sign Up</button>
      <p class="toggle-link" onclick="showLogin()">Already have an account? Sign In</p>
    </div>

    <div class="overlay overlay-default"></div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" crossorigin="anonymous"></script>
  <script>
    function showSignup() {
      document.getElementById("form-wrapper").classList.add("show-signup");
    }

    function showLogin() {
      document.getElementById("form-wrapper").classList.remove("show-signup");
    }

    function login() {
      let username = document.getElementById('login-username').value;
      let password = document.getElementById('login-password').value;

      if (!username || !password) {
        alert("Please fill in all fields.");
        return;
      }
      alert("Login successful! Welcome to the Shoe Store.");
    }

    function signup() {
      let email = document.getElementById('signup-email').value;
      let username = document.getElementById('signup-username').value;
      let password = document.getElementById('signup-password').value;
      let confirmPassword = document.getElementById('signup-confirm-password').value;

      if (!email || !username || !password || !confirmPassword) {
        alert("Please fill in all fields.");
        return;
      }

      if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return;
      }
      alert("Account created successfully! You can now log in.");
    }
  </script>
</body>
