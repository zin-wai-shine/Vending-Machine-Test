<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Login'; ?></title>
    <link rel="stylesheet" href="../../css/app.css">
    <style>
        .error_text{
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="vh-100 d-flex justify-content-center align-items-center">
    <?php if (isset($content)): ?>
        <?php echo $content; ?>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
