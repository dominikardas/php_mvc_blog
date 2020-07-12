<div id="js-popup">    
</div>

<?php 
    if ($_SESSION['pushMessage']) {
        echo '<div id="push-message">' . $_SESSION['pushMessage'] . '</div>';
        unset($_SESSION['pushMessage']);
    }
?>