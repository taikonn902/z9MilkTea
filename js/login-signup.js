const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');
const registerForm = document.querySelector('.form-container.sign-up form');
const loginForm = document.querySelector('.form-container.sign-in form');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
    // Xoá giá trị của thuộc tính name trong tất cả các trường của form đăng nhập
    loginForm.querySelectorAll('[name]').forEach(input => {
        input.name = '';
    });
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
    // Xoá giá trị của thuộc tính name trong tất cả các trường của form đăng ký
    registerForm.querySelectorAll('[name]').forEach(input => {
        input.name = '';
    });
});
