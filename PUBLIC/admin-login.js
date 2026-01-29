function adminLogin() {
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();
    const msg = document.getElementById("loginMsg");

    if (!username || !password) {
        msg.innerHTML = "Enter username and password";
        msg.style.color = "red";
        return false;
    }

    fetch("/admin/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            window.location.href = "/admin.html";
        } else {
            msg.innerHTML = "Invalid login credentials";
            msg.style.color = "red";
        }
    });

    return false;
}
