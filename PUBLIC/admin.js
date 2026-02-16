console.log("admin.js loaded");

document.addEventListener("DOMContentLoaded", () => {
    fetch("/admin/enquiries")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("enquiryData");
            tbody.innerHTML = "";

            data.forEach(e => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${e.name}</td>
                    <td>${e.email}</td>
                    <td>${e.phone}</td>
                    <td>${e.course}</td>
                    <td>${e.message}</td>
                    <td>
                        <button class="delete-btn" onclick="deleteEnquiry('${e.id}')">
                            Delete
                        </button>
                    </td>
                `;

                tbody.appendChild(row);
            });
        });
});

function deleteEnquiry(id) {
    if (!confirm("Delete this enquiry?")) return;

    fetch(`/admin/enquiry/${id}`, {
        method: "DELETE"
    })
        .then(() => location.reload());
}
