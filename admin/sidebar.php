<!-- sidebar.php -->
<style>
    .sidebar {
        width: 240px;
        height: 100vh;
        position: fixed;
        top: 0; left: 0;
        background: #212529;
        padding-top: 70px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        overflow-x: hidden;
        z-index: 999;
    }
    .sidebar.collapsed {
        width: 70px;
    }
    .sidebar a {
        color: #adb5bd;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s;
    }
    .sidebar a:hover {
        background: #343a40;
        color: #fff;
    }
    .sidebar a.active {
        background: #f5945c;
        color: #fff;
        font-weight: bold;
    }
    .sidebar i {
        font-size: 18px;
        margin-right: 12px;
        transition: margin 0.3s;
    }
    .sidebar.collapsed a span {
        display: none;
    }
    .sidebar.collapsed a i {
        margin-right: 0;
        text-align: center;
        width: 100%;
    }
    .content {
        margin-left: 260px;
        padding: 20px;
        transition: margin-left 0.3s;
    }
    .collapsed ~ .content {
        margin-left: 90px;
    }
    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 15px;
        font-size: 22px;
        background: #f5945c;
        border: none;
        color: #fff;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        z-index: 1000;
        transition: background 0.3s;
    }
    .toggle-btn:hover {
        background: #e85c1f;
    }
</style>

<!-- Toggle Button -->
<button class="toggle-btn" id="sidebarToggle"><i class="bi bi-list"></i></button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i><span> Dashboard</span></a>
    <a href="posts.php"><i class="bi bi-file-earmark-text"></i><span> Posts</span></a>
    <a href="component_add.php"><i class="bi bi-plus-square"></i><span> Add Component</span></a>
    <!-- <a href="component_edit.php"><i class="bi bi-pencil-square"></i><span> Edit Component</span></a> -->
    <a href="component_delete.php"><i class="bi bi-trash"></i><span> Delete Component</span></a>
    <a href="components.php"><i class="bi bi-box"></i><span> All Components</span></a>
</div>

<script>
document.getElementById("sidebarToggle").addEventListener("click", function() {
    document.getElementById("sidebar").classList.toggle("collapsed");
    document.querySelector(".content").classList.toggle("collapsed");
});
</script>
