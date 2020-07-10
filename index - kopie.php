<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martin Růžek</title>

    <link rel="stylesheet" href="styles/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico">

    <script src="https://kit.fontawesome.com/868ac28d90.js" crossorigin="anonymous"></script>
</head>

<body>
    <section id="first">
        <div id="bgimg">
            <div id="socials">
                <a href="https://www.twitter.com/maruzek" target="_blank"><i class="fab fa-twitter" onmouseover="twttr()" onmouseout="twttrOut()"></i></a>
                <a href="https://www.instagram.com/martin_ruzek" target="_blank"><i class="fab fa-instagram" onmouseover="ig()" onmouseout="igOut()"></i></a>
            </div>
            <h1 id="martin">MARTIN <span style="color: #bb0000">R</span>ŮŽEK</h1>
            <p>Work in progress</p>
        </div>
    </section>

    <script>
        function twttr() {
            document.getElementById("martin").innerHTML = "<span style='color: #bb0000'>@</span>maruzek";
        }

        function twttrOut() {
            document.getElementById("martin").innerHTML = "MARTIN <span style='color: #bb0000'>R</span>ŮŽEK";
        }

        function ig() {
            document.getElementById("martin").innerHTML = "<span style='color: #bb0000'>@</span>martin_ruzek";
        }

        function igOut() {
            document.getElementById("martin").innerHTML = "MARTIN <span style='color: #bb0000'>R</span>ŮŽEK";
        }
    </script>
</body>

</html>