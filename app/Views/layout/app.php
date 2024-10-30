<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Dashboard'; ?></title>
    <link rel="stylesheet" href="css/app.css">
    <style>
        /* Flexbox properties to ensure footer stays at the bottom */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Full viewport height */
        }

        #sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 60px; /* Space for the fixed navbar */
            transition: width 0.3s ease;
        }

        #sidebar.collapsed {
            width: 70px; /* Collapsed width */
        }

        #main-content {
            margin-left: 250px;
            flex: 1; /* Allow main content to grow and push footer down */
            transition: margin-left 0.3s ease;
        }

        #main-content.collapsed {
            margin-left: 70px;
        }

        .sidebar-link {
            color: white;
        }

        .sidebar-link:hover {
            color: #adb5bd;
        }

        footer {
            background-color: #343a40; /* Same color as sidebar */
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto; /* Pushes footer to the bottom */
        }
    </style>

</head>
<body>

    <?php include_once "navbar.php"?>

    <?php include_once "sidebar.php"?>

        <!-- Main Content -->
        <div id="main-content">
            <section class="pt-5">
                <div class="container-fluid p-4">
                    <!-- Dynamic content goes here -->
                    <?php if (isset($content)): ?>
                        <?php echo $content; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    <?php include_once "footer.php"?>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    $('#adminLogoutButton').on('click', function() {
        const confirmLogout = confirm("Are you sure you want to logout?");
        if (confirmLogout) {
            $.ajax({
                url: '/logout',
                method: 'GET',
                success: function(response) {
                    alert("You have logged out successfully!");
                    window.location.href = '/login';
                },
                error: function(xhr, status, error) {
                    alert("Logout failed. Please try again.");
                    console.error("Logout error:", error);
                }
            });
        } else {
            alert("Logout cancelled.");
        }
    });
    // Sidebar toggle script
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('main-content').classList.toggle('collapsed');
    });


</script>

</body>
</html>
