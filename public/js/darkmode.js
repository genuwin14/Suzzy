document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("darkModeToggle");
    const rootElement = document.documentElement;
    const body = document.body;
    const icon = darkModeToggle.querySelector("i");

    // Function to update the icon
    function updateIcon(isDarkMode) {
        if (isDarkMode) {
            icon.classList.remove("fa-moon");
            icon.classList.add("fa-sun");
        } else {
            icon.classList.remove("fa-sun");
            icon.classList.add("fa-moon");
        }
    }

    // Check local storage for dark mode preference
    const isDarkMode = localStorage.getItem("theme") === "dark";
    if (isDarkMode) {
        rootElement.classList.add("dark-mode");
        body.classList.add("dark-mode");
        updateIcon(true);
    }

    // Toggle dark mode on button click
    darkModeToggle.addEventListener("click", function () {
        const isCurrentlyDarkMode = rootElement.classList.toggle("dark-mode");
        body.classList.toggle("dark-mode");

        // Update local storage
        localStorage.setItem("theme", isCurrentlyDarkMode ? "dark" : "light");

        // Update icon
        updateIcon(isCurrentlyDarkMode);
    });
});
