console.log("script.js loaded");
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
    // Get form values
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();

    const message = document.getElementById("message").value.trim();
    const msg = document.getElementById("msg");

    // Safety check
    if (!msg) {
        console.error("Message element (#msg) not found");
        return false;
    }

    // Validation
    if (!name || !email || !phone) {
        msg.textContent = "Please fill all required fields";
        msg.style.color = "red";
        return false; // stop submit
    }

    // Send data to backend
    fetch("/enquiry", {
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
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP Error: " + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                msg.textContent = "Enquiry submitted successfully!";
                msg.style.color = "green";
                document.querySelector("form").reset();
            } else {
                msg.textContent = "Failed to submit enquiry";
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
