<?php
$servername = "sql107.infinityfree.com";
$dBUsername = "if0_34931116";
$dBPassword = "";
$dBName = "if0_34931116_yortechdb";
$barangaycount = 0;
$provincialcount = 0;
$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $complaint = $_POST['complaint'];
    $radiobutton = $_POST['radiobutton'];
    $type = $radiobutton;

    if ($radiobutton == "barangay") {
        $query = "INSERT INTO barangay_logs VALUES ('','$name','$email','$complaint','$type')";
    } else {
        $query = "INSERT INTO provincial_logs VALUES ('','$name','$email','$complaint','$type')";
    }
    mysqli_query($conn, $query);
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Resume</title>
</head>

<body>
    <header>
        <a href="#" class="logo">YORTECH</a>
        <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#complaints">Complaints</a></li>
            <li><a href="#logs">Logs</a></li>
            <li><a href="#info">Information</a></li>
        </ul>
    </header>
    <section id="home">
        <div id="main">
            <h1>Welcome to <span id="title">Suggest-Iot</span>
            </h1>
            <p>Your website for complaints and suggestion for community improvement</p>
            <div>
                <a href="#complaints"><button><span></span>Get Started</button></a>
            </div>

        </div>
    </section>
    
    <section id="complaints">

        <form id="complaintform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Suggestion And Complaint Box</h2>
            <input type="text" name="name" id="name" placeholder="Your Name" required />
            <input type="email" name="email" id="email" placeholder="Email Address" required />
            <textarea id="message" rows="4" placeholder="Suggestion/Complaint" name="complaint"></textarea>
            <div id="radiodiv">
                <div>
                    <input type="radio" id="barangay" name="radiobutton" value="barangay" required>
                    <label for="barangay">Barangay</label>
                </div>
                <div>
                    <input type="radio" id="provincial" name="radiobutton" value="provincial" required>
                    <label for="provincial">Provincial</label>
                </div>
            </div>
            <button type="submit" id="submit" name="submit">Submit</button>
        </form>
    </section>
    <section id="logs">
        <div id="logscontainer">
            <div id="barangaylogs">
                <h2>Barangay Logs</h2>

                <?php
                $sql = "SELECT * FROM barangay_logs;";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $barangaycount++;
                        echo '<div class="complaint">' .
                            "Count: " . $barangaycount . "<br>" .
                            "Name: " . $row['name'] . "<br>" .
                            "Email: " . $row['email'] . "<br>" .
                            "Complaint: " . '<br>' . '<textarea rows="5" cols="40" readonly>' . $row['complaint'] . '</textarea>' . "<br>" .
                            "<hr>" .
                            '</div>';
                    }
                } else {
                    echo "No records found.";
                }
                ?>

            </div>
            <hr>
            <div id="provinciallogs">
                <h2>Provincial Logs</h2>

                <?php
                $sql = "SELECT * FROM provincial_logs;";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $provincialcount++;
                        echo '<div class="complaint">' .
                            "Count: " . $provincialcount . "<br>" .
                            "Name: " . $row['name'] . "<br>" .
                            "Email: " . $row['email'] . "<br>" .
                            "Complaint: " . '<br>' . '<textarea rows="5" cols="40" readonly>' . $row['complaint'] . '</textarea>' . "<br>" .
                            "<hr>" .
                            '</div>';
                    }
                } else {
                    echo "No records found.";
                }
                ?>

            </div>
        </div>
    </section>
    <section id="info">
        <div id="footer">
            <div><img src="Media/Icon.png"></img></div>
            <p>@Copyright reserves 2023</p>
        </div>
    </section>

    <script type="text/javascript">
        window.addEventListener("scroll", function() {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 830)
            console.log(scrollY);
        })
    </script>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
