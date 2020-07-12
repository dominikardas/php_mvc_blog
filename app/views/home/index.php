<?php $this->setTitle('Home') ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('newPosts'); ?>
    
    <div class="l-new-posts">
        <div class="l-top-post l-top-post__big">
            <?= getTopPostHtml($this->data[0]); ?>
        </div>
        <div class="c_top-post_small">
            <div class="l-top-post l-top-post__small">
                <?= getTopPostHtml($this->data[1]); ?>                
            </div>
            <div class="l-top-post l-top-post__small">
                <?= getTopPostHtml($this->data[2]); ?>                
            </div>
        </div>
    </div>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <div class="c-container-posts">
    <?php 
        echo getPostsHtml($this->data);
    ?>
    </div>
    <button type="submit" id="js-load-more" data-curr-page="1">Load more posts</button>
<?php $this->end(); ?>