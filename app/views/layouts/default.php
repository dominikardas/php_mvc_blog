<!DOCTYPE html>
<html lang="en">
<head>
    <?php require (HEADER_PATH); ?>
    <?= $this->getContent('head'); ?>
</head>
<body>
    <div class="c-container">

        <div class="c-container-header">
            <span class="l-logo"><a href="<?= SROOT ?>">The blog</a></span>
            <?php require (NAVBAR_PATH); ?> 
            <?= $this->getContent('newPosts'); ?>
        </div>

        <div class="c-container-content">            
            <?= $this->getContent('body'); ?>
        </div>

        
        <?php require (FOOTER_PATH); ?>
    </div>
</body>
</html>