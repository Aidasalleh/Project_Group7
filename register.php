<?php
include("connection.php");

    if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $user = $_POST['username'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    // Password policy checks
    if ($user == "" || $name == "" || $email == "") {
        echo "All fields should be filled. Either one or many fields are empty.";
        echo "<br/>";
        echo "<a href='register.php'>Go back</a>";
    } elseif (strlen($password) < 8) {
        echo "Password should be at least 8 characters long.";
        echo "<br/>";
        echo "<a href='register.php'>Go back</a>";
    } elseif ($password != $repassword) {
        echo "Passwords do not match.";
        echo "<br/>";
        echo "<a href='register.php'>Go back</a>";
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*()_+{}|:;<>,.?~\-=[\]\\\']/',$password)) {
        echo "Password should include at least one uppercase letter, one lowercase letter, one number, and one special character.";
        echo "<br/>";
        echo "<a href='register.php'>Go back</a>";
    } else {
        // Use SHA-256 for hashing
        $pass = hash('sha256', $password);

        mysqli_query($mysqli, "INSERT INTO login(name, email, username, password) VALUES('$name', '$email', '$user', '$pass')")
            or die("Could not execute the insert query.");

        echo "PLEASE WAIT FOR APPROVAL FROM ADMINISTRATOR";
        echo "<a href='register.php'>Go back</a>";
    }
} 
?>
<html>

<head>
    <title>Register</title>

    <style>
        body {
            background-color:rgb(232, 240, 173);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        #header {
            color:rgb(49, 100, 255);
            font-size: 24px;
            padding: 20px;
            background-color: rgb(243, 249, 74);
        }

        a {
            color: #9B59B6;
            text-decoration: none;
        }

        #content {
            padding: 20px;
        }

        form {
            width: 75%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border: 0;
        }

        table td {
            padding: 10px;
        }

        .valid {
            color: green;
        }

        .invalid {
            color: red;
        }

        #passwordCriteria {
            display: none; /* Initially hidden */
        }
    </style>
</head>

<body>

    <div id="header">
        <img src="logosekolah.jpg" alt="School Logo"style="width:100px;height:100px;">
        <h1>STUDENT REGISTRATION SYSTEM</h1>
    </div>

    <div id="content">
        <a href="index.php">Home</a> <br />

        <p><font size="+2">Register</font></p>
        <form name="form1" id="registrationForm" method="post" action="">
            <table>
                <tr>
                    <td width="10%">Full Name</td>
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" id="password" name="password"></td>
                </tr>
                <tr>
                    <td>Reconfirm Password</td>
                    <td><input type="password" name="repassword"></td>
                </tr>
                <tr>
                    <td>Password Rules</td>
                    <td>
                        <div id="passwordCriteria" class="password-advice">
                            <p>Password must meet the following criteria:</p>
                            <ul>
                                <li id="length" class="invalid">At least 8 characters</li>
                                <li id="lowercase" class="invalid">At least one lowercase letter</li>
                                <li id="uppercase" class=" invalid">At least one uppercase letter</li>
                                <li id="digit" class="invalid">At least one number</li>
                                <li id="special" class="invalid">At least one special character</li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>

    <div id="footer">
        <p>© 2025 Group7sec1. All Rights Reserved.</p>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const passwordCriteria = document.getElementById('passwordCriteria');

        const lengthCriteria = document.getElementById('length');
        const lowercaseCriteria = document.getElementById('lowercase');
        const uppercaseCriteria = document.getElementById('uppercase');
        const digitCriteria = document.getElementById('digit');
        const specialCriteria = document.getElementById('special');

        // Show password criteria when the user starts typing
        passwordInput.addEventListener('input', () => {
            const value = passwordInput.value;

            passwordCriteria.style.display = 'block';

            // Check for length
            if (value.length >= 8) {
                lengthCriteria.classList.add('valid');
                lengthCriteria.classList.remove('invalid');
            } else {
                lengthCriteria.classList.add('invalid');
                lengthCriteria.classList.remove('valid');
            }

            // Check for lowercase
            if (/[a-z]/.test(value)) {
                lowercaseCriteria.classList.add('valid');
                lowercaseCriteria.classList.remove('invalid');
            } else {
                lowercaseCriteria.classList.add('invalid');
                lowercaseCriteria.classList.remove('valid');
            }

            // Check for uppercase
            if (/[A-Z]/.test(value)) {
                uppercaseCriteria.classList.add('valid');
                uppercaseCriteria.classList.remove('invalid');
            } else {
                uppercaseCriteria.classList.add('invalid');
                uppercaseCriteria.classList.remove('valid');
            }

            // Check for digit
            if (/\d/.test(value)) {
                digitCriteria.classList.add('valid');
                digitCriteria.classList.remove('invalid');
            } else {
                digitCriteria.classList.add('invalid');
                digitCriteria.classList.remove('valid');
            }

            // Check for special character
            if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
                specialCriteria.classList.add('valid');
                specialCriteria.classList.remove('invalid');
            } else {
                specialCriteria.classList.add('invalid');
                specialCriteria.classList.remove('valid');
            }
        });

        // Prevent form submission if criteria aren't met
        const form = document.getElementById('registrationForm');
        form.addEventListener('submit', (event) => {
            const allValid = document.querySelectorAll('.password-advice .invalid').length === 0;
            if (!allValid) {
                event.preventDefault();
                alert('Please ensure the password meets all criteria.');
            }
        });
    </script>
</body>

</html>