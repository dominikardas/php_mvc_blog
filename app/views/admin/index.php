<?php $this->setTitle('Admin Page'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body') ?>

    <div class="c-container-posts-admin">
        <?php
            foreach($this->data['posts'] as $post) {

                $post = (array)$post;
                $path = SROOT . 'posts' . '/' . $post['categoryName'] . '/' . $post['slug'];
                $isPublished = $post['published'];

                echo sprintf(
                    '<div class="l-post-admin %s">

                        <span><a href="%s" target="_blank">%s</a></span>

                        <div class="l-post-admin_buttons">
                            <a href="%s" class="l-buttons_publish">Publish</a>
                            <a href="%s" class="l-buttons_unpublish">Unpublish</a>
                            <a href="%s" class="l-buttons_remove">Remove</a>
                        </div>

                    </div>
                    ', (!$isPublished ? 'l-post-not_published' : ''), $path, $post['title'], SROOT . 'admin/publish/'   . $post['postId'],
                                                                                             SROOT . 'admin/unpublish/' . $post['postId'],
                                                                                             SROOT . 'admin/delete/'    . $post['postId']);
            }
        ?>    
    </div>

    <nav class="l-pagination">

        <ul>

            <?php
                $page = (empty($_GET['page'])) ? 1 : $_GET['page'];
                $link = SROOT . 'admin/?page=';
                $prevPage = ($page > 1) ? $link . ($page - 1) : '';
                $nextPage = ($page < $this->data['pages']) ? $link . ($page + 1) : '';
            ?>

            <li>
                <a href="<?=$prevPage?>">Prev</a>
            </li>

            <?php 
                
                for ($i = 0; $i < $this->data['pages']; $i++) {
                    echo sprintf('<li class="%s"><a href="%sadmin?page=%s">%s</a></li>', ($page == $i + 1) ? 'is_active' : '', SROOT, $i + 1, $i + 1);
                }
            ?>

            <li>
                <a href="<?=$nextPage?>">Next</a>
            </li>
        </ul>

    </nav>

<?php $this->end(); ?>