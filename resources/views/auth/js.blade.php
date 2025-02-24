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
