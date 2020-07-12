<?php $this->setTitle($this->data['title']); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <div class="c-post_container">    
        <span class="l-post-title"><?= $this->data['title'] ?></span>
        <span class="l-post-small_desc"><?= $this->data['smallDesc']; ?></span>
        
        <div class="l-post-info">
            <span class="l-post-publish_date">Published: <span><?= $this->data['publishedAt'] ?></span></span>
            <div class="l-post-author">
                <span class="l-author-image"></span>
                <span class="l-author-name"><?= $this->data['authorName'] ?></span>
            </div>
        </div>
        
        <div class="l-post-image">    
            <img src="<?= SROOT .  $this->data['image'] ?>">
        </div>

        <div class="l-post-content">   
            <?= $this->data['content'] ?>                             
        </div>
    </div>

<?php $this->end(); ?>