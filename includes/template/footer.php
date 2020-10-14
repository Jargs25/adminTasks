<script src="js/sweetalert2.all.min.js"></script>

<?php
    $page = getCurrentPage();
    
    if ($page === 'crear_cuenta' || $page === 'login') {
        echo '<script src="js/formulario.js"></script>';
    } else {
        echo '<script src="js/scripts.js"></script>';
    }
?>

</body>
</html>