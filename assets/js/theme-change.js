const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
const savedTheme = localStorage.getItem('theme');
const moonIcon = document.querySelector('.moon-icon');
const sunIcon = document.querySelector('.sun-icon');

function updateIcons(theme) {
    if (theme === 'dark') {
        moonIcon.style.display = 'none';
        sunIcon.style.display = 'block';
    } else {
        moonIcon.style.display = 'block';
        sunIcon.style.display = 'none';
    }
}

if (savedTheme) {
    document.documentElement.setAttribute('data-theme', savedTheme);
    toggleSwitch.checked = savedTheme === 'dark';
    updateIcons(savedTheme);
} else {
    document.documentElement.setAttribute('data-theme', 'dark');
    toggleSwitch.checked = true;
    localStorage.setItem('theme', 'dark');
    updateIcons('dark');
}

const elementsToToggle = [
    document.body,
    document.querySelector('.navbar'),
    document.querySelector('.navbar-title'),
    document.querySelector('.navbar-toggle'),
    document.querySelector('.navbar-toggle i'),
    document.querySelector('.navbar-links'),
    document.querySelector('.profile-icon i'),
    document.querySelector('.theme-switch'),
    ...document.querySelectorAll('.navbar-links li a'),
    document.querySelector('.map-container'),
    document.querySelector('.search-container'),
    document.querySelector('.filter-container'),
    ...document.querySelectorAll('.review'),
    document.querySelector('.form-container'),
    document.querySelector('.review-form')
];

const logoImg = document.querySelector('.logo-img');

function applyLightTheme(apply) {
    elementsToToggle.forEach(el => {
        if (el) {
            el.classList.toggle('light', apply);
        }
    });

    if (logoImg) {
        logoImg.src = apply
            ? '/biletaria_online/assets/img/metropol_iconblack.png'
            : '/biletaria_online/assets/img/metropol_icon.png';
    }
}

const themeToggleCheckbox = document.querySelector('.theme-switch input[type="checkbox"]');
applyLightTheme(savedTheme === 'light');

function switchTheme(e) {
    const newTheme = e.target.checked ? 'dark' : 'light';
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateIcons(newTheme);
}

toggleSwitch.addEventListener('change', switchTheme, false);
themeToggleCheckbox.addEventListener('change', function (e) {
    const isDark = e.target.checked;
    const newTheme = isDark ? 'dark' : 'light';
    localStorage.setItem('theme', newTheme);
    applyLightTheme(!isDark);
});