<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Department of MCA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'db.php'; ?>

    <!-- HEADER -->
    <header class="header">
        <img src="images/logo33.gif" class="logo">
        <p class="header-text">Department of MCA</p>
    </header>

    <!-- ABOUT COLLEGE -->
    <section class="info-box">

        <section class="gallery-slider">
            <div class="slide active">
                <img src="images/frontcollege.jpg">
            </div>
            <div class="slide">
                <img src="images/aboutcollege.jpg">
            </div>
            <div class="slide">
                <img src="images/lab.png">
            </div>
            <div class="slide">
                <img src="images/lib.jfif">
            </div>
        </section>

        <h2>About College</h2>
        <p>
            The institution is spread over a sprawling campus with calm surroundings, creating a fitting atmosphere for
            study. The
            Institute provides a clean and invigorating environment conducive for higher education. Adhiyamaan College
            of
            Engineering is one of the educational institutions developed by Adhiyamaan Educational & Research
            Institution - a trust,
            which was started in the year 1987-1988 to cater the needs of the nation in the development of technocrats
            and to
            provide facilities for educating and training men and women to meet the entrepreneurial and management
            needs.
            <br>
            <a href="https://adhiyamaan.ac.in/ace/" target="_blank" class="read-btn">
                Read More
            </a>
        </p>

    </section>

    <!-- MCA DEPARTMENT -->
    <section class="info-box">

        <section class="gallery-slider">
            <div class="slide active">
                <img src="images/ACE.png">
            </div>
            <div class="slide">
                <img src="images/highlights.jpg">
            </div>
            <div class="slide">
                <img src="images/dept1.jpg">
            </div>
        </section>

        <h2>MCA Department</h2>
        <p>
            The Master of Computer Applications (MCA) is a postgraduate degree program that focuses on computer science,
            software
            development, and applications of computer technology in various industries. The Department of MCA was
            established in the
            year 1995 -96 with the intake of 60 and it is affiliated to Anna University, Chennai. The department has
            well
            equipped
            laboratory, wi-fi class rooms and dedicated faculty members. It strives hard to develop world-class,
            self-disciplined
            computer professionals who will be responsible for uplifting the economic status of our Nation and humanity.
            <br>
            <a href="https://adhiyamaan.ac.in/ace/mca" target="_blank" class="read-btn">
                Read More
            </a>
        </p>

    </section>

    <!-- ENQUIRY FORM -->
    <section class="form-container">
        <h2>Student Enquiry Form</h2>

        <form id="enquiryForm" onsubmit="return validateForm()">
            <input type="text" id="name" placeholder="Full Name" required>
            <input type="email" id="email" placeholder="Email" required>
            <input type="text" id="phone" placeholder="Mobile Number" required>

            <textarea id="message" placeholder="Your Enquiry" required></textarea>
            <button type="submit">Submit</button>
        </form>

        <p id="msg"></p>
    </section>

    <footer class="footer">
        &copy; <?php echo date("Y"); ?> Department of MCA. All Rights Reserved.
    </footer>

    <script>
        console.log("PHP-based script loaded");
        document.addEventListener("DOMContentLoaded", () => {
            const sliders = document.querySelectorAll(".gallery-slider");
            sliders.forEach(slider => {
                const slides = slider.querySelectorAll(".slide");
                let index = 0;
                setInterval(() => {
                    slides[index].classList.remove("active");
                    index = (index + 1) % slides.length;
                    slides[index].classList.add("active");
                }, 3000);
            });
        });

        function validateForm() {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const phone = document.getElementById("phone").value.trim();
            const message = document.getElementById("message").value.trim();
            const msg = document.getElementById("msg");

            if (!name || !email || !phone) {
                msg.textContent = "Please fill all required fields";
                msg.style.color = "red";
                return false;
            }

            fetch("submit.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone,
                    course: "MCA",
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    msg.textContent = "Enquiry submitted successfully!";
                    msg.style.color = "green";
                    document.getElementById("enquiryForm").reset();
                } else {
                    msg.textContent = "Failed to submit enquiry: " + (data.error || "Unknown error");
                    msg.style.color = "red";
                }
            })
            .catch(error => {
                console.error(error);
                msg.textContent = "Server error. Please try again later.";
                msg.style.color = "red";
            });

            return false;
        }
    </script>
</body>

</html>
