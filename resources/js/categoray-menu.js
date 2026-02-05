// Wrap everything in a DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    // Toggle main menu on mobile
    window.toggleMainMenu = function() {
        const menu = document.getElementById('mainMenu');
        const icon = document.getElementById('mainMenuIcon');
        if (menu && icon) {
            menu.classList.toggle('active');
            icon.textContent = menu.classList.contains('active') ? '▲' : '▼';
        }
    };

    // Unified hover handler for both mobile and desktop
    window.handleHover = function(element, hasChildren) {
        if (hasChildren) {
            const childMenu = element.querySelector('.child-menu');
            if (childMenu) {
                if (window.innerWidth < 768) {
                    // On mobile, show immediately on hover
                    childMenu.style.display = 'flex';
                } else {
                    // On desktop, use the hover behavior
                    element.classList.add('hover-active');
                    childMenu.style.display = 'flex';
                }
            }
        }
    };

    window.handleLeave = function(element, hasChildren) {
        if (hasChildren) {
            const childMenu = element.querySelector('.child-menu');
            if (childMenu) {
                if (window.innerWidth < 768) {
                    // On mobile, don't hide on leave - let click handle it
                    return;
                } else {
                    // On desktop, hide after delay
                    element.classList.remove('hover-active');
                    setTimeout(() => {
                        if (!element.classList.contains('hover-active')) {
                            childMenu.style.display = 'none';
                        }
                    }, 200);
                }
            }
        }
    };

    // Click handler for mobile
    window.handleClick = function(event, hasChildren) {
        if (window.innerWidth < 768 && hasChildren) {
            event.preventDefault();
            const item = event.currentTarget.closest('.category-item');
            if (item) {
                item.classList.toggle('active');
                
                // Toggle child menu display
                const childMenu = item.querySelector('.child-menu');
                if (childMenu) {
                    childMenu.style.display = item.classList.contains('active') ? 'flex' : 'none';
                }
                
                // Close siblings
                const siblings = Array.from(item.parentNode.children).filter(child => child !== item);
                siblings.forEach(sibling => {
                    sibling.classList.remove('active');
                    const siblingChildMenu = sibling.querySelector('.child-menu');
                    if (siblingChildMenu) {
                        siblingChildMenu.style.display = 'none';
                    }
                });
            }
        }
    };

    // Close menus when clicking outside (mobile)
    document.addEventListener('click', function(event) {
        if (window.innerWidth >= 768) return;
        
        if (!event.target.closest('.category-item')) {
            document.querySelectorAll('.category-item').forEach(item => {
                item.classList.remove('active');
                const childMenu = item.querySelector('.child-menu');
                if (childMenu) {
                    childMenu.style.display = 'none';
                }
            });
        }
    });
});