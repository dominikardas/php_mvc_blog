<?php 
    // oof 
    $this->setTitle((string)((array)$this->data[0])['categoryName']);
?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <div class="c-container-posts">
    <?php 
        echo getPostsHtml($this->data);
    ?>
    </div>
    <button type="submit" id="js-load-more" data-curr-page="1">Load more posts</button>
<?php $this->end(); ?>