document.addEventListener('DOMContentLoaded', () => {
    const layoutWrapper = document.getElementById('appLayoutWrapper');
    const toggleBtn = document.getElementById('sidebarToggleBtn');
    const expandBtn = document.getElementById('sidebarExpandBtn');

    if (!layoutWrapper) return;

    // Restore saved sidebar collapse state
    const isCollapsed = localStorage.getItem('coronado_sidebar_collapsed') === 'true';
    if (isCollapsed) {
        layoutWrapper.classList.add('sidebar-collapsed');
    }

    // Hide sidebar action (Click collapse button on sidebar header)
    if (toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            layoutWrapper.classList.add('sidebar-collapsed');
            localStorage.setItem('coronado_sidebar_collapsed', 'true');
        });
    }

    // Show/Re-expand sidebar action (Click expand button on top navbar header)
    if (expandBtn) {
        expandBtn.addEventListener('click', (e) => {
            e.preventDefault();
            layoutWrapper.classList.remove('sidebar-collapsed');
            localStorage.setItem('coronado_sidebar_collapsed', 'false');
        });
    }
});
