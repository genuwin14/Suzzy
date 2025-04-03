document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const navbar = document.getElementById('navbar');
    const content = document.querySelector('.content');
    const toggleIcon = document.getElementById('toggleSidebar').querySelector('i');

    function updateSidebar() {
        const isMobile = window.innerWidth <= 768; // Define mobile breakpoint

        if (isMobile) {
            // Mobile View: Sidebar initially collapsed
            sidebar.classList.add('collapsed');
            navbar.style.width = "100%";
            navbar.style.marginLeft = "0";
            if (content) {
                content.style.marginLeft = "0";
                content.style.width = "100%";
            }
        } else {
            // Desktop View: Sidebar initially collapsed
            sidebar.classList.add('collapsed');
            navbar.style.width = "100%";
            navbar.style.marginLeft = "0";
            if (content) {
                content.style.marginLeft = "0";
                content.style.width = "100%";
            }
        }
    }

    // Initialize sidebar state on page load
    updateSidebar();

    document.getElementById('toggleSidebar').addEventListener('click', function () {
        const isMobile = window.innerWidth <= 768;

        sidebar.classList.toggle('collapsed');
        sidebar.classList.toggle('expanded');

        if (sidebar.classList.contains('collapsed')) {
            navbar.style.width = "100%";
            navbar.style.marginLeft = "0";
            if (content) {
                content.style.marginLeft = "0";
                content.style.width = "100%";
            }
            toggleIcon.classList.remove('fa-xmark');
            toggleIcon.classList.add('fa-bars');
        } else {
            if (isMobile) {
                // Mobile View: Sidebar overlays content
                navbar.style.width = "100%";
                navbar.style.marginLeft = "0";
                if (content) {
                    content.style.marginLeft = "0";
                    content.style.width = "100%";
                }
            } else {
                // Desktop View: Sidebar pushes content
                navbar.style.width = "calc(100% - 250px)";
                navbar.style.marginLeft = "250px";
                if (content) {
                    content.style.marginLeft = "250px";
                    content.style.width = "calc(100% - 250px)";
                }
            }
            toggleIcon.classList.remove('fa-bars');
            toggleIcon.classList.add('fa-xmark');
        }
    });

    // Ensure sidebar adjusts properly on window resize
    window.addEventListener('resize', updateSidebar);
});

// This script is for desktop view only
// document.addEventListener('DOMContentLoaded', function () {
//     const sidebar = document.getElementById('sidebar');
//     const navbar = document.getElementById('navbar');
//     const content = document.querySelector('.content');
//     const toggleIcon = document.getElementById('toggleSidebar').querySelector('i');

//     sidebar.classList.add('collapsed');
//     navbar.style.width = "100%";
//     navbar.style.marginLeft = "0";
//     content.style.marginLeft = "0";
//     content.style.width = "100%";

//     document.getElementById('toggleSidebar').addEventListener('click', function () {
//         sidebar.classList.toggle('collapsed');
//         sidebar.classList.toggle('expanded');

//         if (sidebar.classList.contains('collapsed')) {
//             navbar.style.width = "100%";
//             navbar.style.marginLeft = "0";
//             content.style.marginLeft = "0";
//             content.style.width = "100%";
//             toggleIcon.classList.remove('fa-xmark');
//             toggleIcon.classList.add('fa-bars');
//         } else {
//             navbar.style.width = "calc(100% - 250px)";
//             navbar.style.marginLeft = "250px";
//             content.style.marginLeft = "250px";
//             content.style.width = "calc(100% - 250px)";
//             toggleIcon.classList.remove('fa-bars');
//             toggleIcon.classList.add('fa-xmark');
//         }
//     });
// });


// This script id for responsive or mobile view only
// document.addEventListener('DOMContentLoaded', function () {
//     const sidebar = document.getElementById('sidebar');
//     const navbar = document.getElementById('navbar');
//     const toggleIcon = document.getElementById('toggleSidebar').querySelector('i');

//     sidebar.classList.add('collapsed');
//     navbar.style.width = "100%";
//     navbar.style.marginLeft = "0";

//     document.getElementById('toggleSidebar').addEventListener('click', function () {
//         sidebar.classList.toggle('collapsed');
//         sidebar.classList.toggle('expanded');

//         if (sidebar.classList.contains('collapsed')) {
//             navbar.style.width = "100%";
//             navbar.style.marginLeft = "0";
//             toggleIcon.classList.remove('fa-xmark');
//             toggleIcon.classList.add('fa-bars');
//         } else {
//             navbar.style.width = "calc(100% - 250px)";
//             navbar.style.marginLeft = "250px";  
//             toggleIcon.classList.remove('fa-bars');
//             toggleIcon.classList.add('fa-xmark');
//         }
//     });
// });
