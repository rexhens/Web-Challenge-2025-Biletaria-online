const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
const savedTheme = localStorage.getItem('theme');

// Apply saved theme, or default to dark
if (savedTheme) {
    document.documentElement.setAttribute('data-theme', savedTheme);
    toggleSwitch.checked = savedTheme === 'dark';
} else {
    // Default to dark theme
    document.documentElement.setAttribute('data-theme', 'dark');
    toggleSwitch.checked = true;
    localStorage.setItem('theme', 'dark');
}

// Handle toggle
function switchTheme(e) {
    if (e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
}

toggleSwitch.addEventListener('change', switchTheme, false);