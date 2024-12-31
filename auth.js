// JavaScript for Showing and Hiding Forms
document.getElementById("login-btn").addEventListener("click", function () {
    document.getElementById("login-form").style.display = "flex";
});

document.getElementById("register-btn").addEventListener("click", function () {
    document.getElementById("register-form").style.display = "flex";
});

document.getElementById("close-login").addEventListener("click", function () {
    document.getElementById("login-form").style.display = "none";
});

document.getElementById("close-register").addEventListener("click", function () {
    document.getElementById("register-form").style.display = "none";
});
