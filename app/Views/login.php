<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script>
    function login() {
      let email = document.getElementById("email").value;
      let password = document.getElementById("password").value;
      if (!email || !password) {
        alert("Please fill in all fields");
        return;
      }

      fetch("http://localhost:8080/login", {
          method: "POST",
          body: new FormData(document.querySelector("form"))
        })
        .then(response => response.json())
        .then(data => {
          if (data.message === "Login successful") {
            localStorage.setItem("user_id", data.user_id); // Store user ID in localStorage
            window.location.href = "/chat"; // Redirect to chat page
          } else {
            alert("Invalid email or password");
          }
        })
        .catch(error => console.error("Error:", error));
    }
  </script>
</head>

<body>
  <h2>Login</h2>
  <form onsubmit="event.preventDefault(); login();">
    <label>Email:</label>
    <input type="email" id="email" required name="email"><br><br>
    <label>Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <button type="submit">Login</button>
  </form>
</body>

</html>