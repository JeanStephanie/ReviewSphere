// Function to toggle dropdown visibility
// Category dropdown toggle
document.querySelectorAll('.category').forEach(function(category) {
    category.addEventListener('click', function(event) {
        // Prevent the event from bubbling up only for category click
        event.stopPropagation();

        // Get the dropdown menu inside the clicked category
        const dropdownMenu = category.querySelector('.dropdown-menu');

        // Toggle visibility of the dropdown menu
        dropdownMenu.style.display = (dropdownMenu.style.display === 'block' ? 'none' : 'block');
    });
});

// Close all dropdowns if the user clicks anywhere outside the categories
document.addEventListener('click', function(event) {
    // Check if the click was outside the category dropdowns or login dropdown
    const isCategoryClick = event.target.closest('.category');
    const isLoginClick = event.target.closest('.nav-item.dropdown');

    if (!isCategoryClick && !isLoginClick) {
        document.querySelectorAll('.dropdown-menu').forEach(function(dropdown) {
            dropdown.style.display = 'none';
        });
    }
});

function closeQueryModal() {
    const modal = document.getElementById("queryModal");
    if (modal) {
        modal.classList.remove("show");
        modal.style.display = "none";
    }

    // Reset the contact form
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.reset();
    }

    // Remove query parameter from URL
    if (history.pushState) {
        const url = new URL(window.location);
        url.searchParams.delete('query');
        window.history.replaceState({}, document.title, url);
    }
}

// Optional: Automatically reset form on page load if modal is shown
window.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("queryModal");
    if (modal && modal.classList.contains("show")) {
        const contactForm = document.querySelector('.contact-form');
        if (contactForm) {
            contactForm.reset();
        }
    }
});
