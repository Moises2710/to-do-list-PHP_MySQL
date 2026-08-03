<?php if (isset($_SESSION['user_id'])): ?>
<aside id="appSidebar" class="app-sidebar bg-white border-end d-flex flex-column flex-shrink-0">
    <div class="sidebar-header-wrapper d-flex align-items-center justify-content-between px-3 border-bottom position-relative" style="height: 65px;">
        <a href="/dashboard" class="d-flex align-items-center gap-2 text-decoration-none text-dark fw-bold me-2">
            <span class="fs-5 brand-text text-truncate">Coronado To do List</span>
        </a>
        <button id="sidebarToggleBtn" class="btn btn-sm btn-outline-secondary rounded-circle sidebar-collapse-btn d-flex align-items-center justify-content-center" title="Hide Sidebar">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>
    <div class="sidebar-body py-3 px-2 flex-grow-1 overflow-y-auto">
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link active d-flex align-items-center gap-2 rounded-3 py-2 px-3 fw-semibold">
                    <i class="bi bi-check2-square fs-5"></i>
                    <span>To Do List</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<?php endif; ?>
