<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crowdfunding Platform</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const images = [
        "images/women-entrepreneurs.webp",
        "images/women-entrepreneurs2.jpg",
        "images/women-entrepreneurs3.png",
        "images/women-entrepreneurs4.avif"
    ];
    
    let index = 1;  // Start from the second image
    const imgElement = document.querySelector(".about-img");

    function changeImage() {
        imgElement.src = images[index];
        index = (index + 1) % images.length;
    }

    setInterval(changeImage, 2000);
    });

    </script>
   
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php">Crowdfunding</a></li>
            <li><a href="selling_products.php">Selling Products</a></li>
        </ul>
    </nav>

    <header class="hero">
        <h1>Welcome to the PIXELS PIXES Platform</h1>
        <p>Empowering women entrepreneurs through crowdfunding and financial assistance.</p>
    </header>

    <section class="about-box">
        <img src="images/women-entrepreneurs.webp" alt="Women Entrepreneurs" class="about-img">

        <p>
            Our website <strong>Pixels Pixes</strong> was established on <strong>5 March, 2025</strong>. Our main objective is to provide financial assistance to women and help them market their products. We provide a platform where they can find investors for 
            their startups as well as businesses and get information about government schemes and NGOs specifically helping women in business. Additionally, we also help them sell their products.
        </p>
    </section>

    <section class="crowdfunding">
        <h3>CROWDFUNDING</h3>
        <div class="button-group">
            <button onclick="window.location.href='investor_login.php'">Investor</button>
            <button onclick="window.location.href='entrepreneur_form.php'">Entrepreneur</button>
        </div>
    </section>

    <h3>FINANCIAL HELP FROM OTHER SOURCES</h3>
    <div class="financial-container">
        <div class="financial-box">
            <h4>NGOs</h4>
            <div class="details">
                <p>These NGOs offer funding and support for women entrepreneurs.</p>
            </div>
            
                <a href="https://give.do/ngos/gramin-vikas-evam-chetna-sansthan" target="_blank">Gramin Vikas Evam Chetna Sansthan</a><br>
                <a href="https://www.helplocal.in/ngo/sewa-bharat-ngo-delhi" target="_blank">Help Local</a><br>
                <a href="https://manndeshifoundation.org" target="_blank">Manndeshi Foundation</a><br>
                <a href="https://www.womensworldbanking.org" target="_blank">Women's World Banking</a><br>
                <a href="https://growbusiness.org/" target="_blank">Grow Business</a><br>
        </div>

        <div class="financial-box">
            <h4>Government Schemes</h4>
            <div class="details">
                <p>Government schemes providing financial aid for women-led startups.</p>
            </div>
                <a href="https://www.startupindia.gov.in/content/sih/en/women_entrepreneurs.html" target="_blank">Startup India</a><br>
                <a href="https://www.mudra.org.in/" target="_blank">Mudra</a><br>
                <a href="https://wep.gov.in/" target="_blank">WEP</a><br>
                <a href="https://aajeevika.gov.in/" target="_blank">Aajeevika</a><br>
        </div>
    </div>
</body>
</html>
