document.getElementById('studentForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const age = document.getElementById('age').value.trim();

    if (!name || !email || !age) {
        alert("All fields are required!");
        e.preventDefault();
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        alert("Please enter a valid email address!");
        e.preventDefault();
    } else if (isNaN(age) || age <= 0) {
        alert("Please enter a valid age!");
        e.preventDefault();
    }
});
