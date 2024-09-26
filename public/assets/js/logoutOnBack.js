document.addEventListener('DOMContentLoaded', function () {
    if (performance.navigation.type === 2) { // Check if the page is loaded from the back/forward cache
        // Log the user out by submitting the logout form
        document.getElementById('logout-form').submit();
    }
});