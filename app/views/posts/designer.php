<?php $this->setTitle('Designer'); ?>

<?php $this->start('head'); ?>
    <script type="text/javascript" src="<?=SROOT?>js/designer.js"></script>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="c-container-form">

    <h1 class="h1-animated">Post designer</h1>

    <div class="c-form c-form-designer">    

        <?= $this->displayErrors; ?>

        <form class="l-form l-form-designer" method="post" action="<?=SROOT?>posts/preview" target="_blank" enctype="multipart/form-data">

            <div class="c-form_input">
                <label for="post_title">Post title</label>
                <input type="text" name="post_title" class="post_title" value="<?= $_POST['post_title']; ?>">
            </div>

            <div class="c-form_input">
                <label for="post_desc">Small description</label>
                <input type="text" name="post_desc" class="post_desc" value="<?= $_POST['post_desc']; ?>">
            </div>

            <div class="c-form_input">
                <label for="upload_image">Image (preview is not available in designer)</label>
                <input type="file" name="upload_image" class="upload_image">
            </div>

            <div class="c-form_input">
                <label for="categoryName">Category</label>
                <select name="categoryName">
                    <?php
                        foreach($this->data['categories'] as $category) {
                            $category = (array)$category;
                            echo sprintf('<option value="%s">%s</option>', $category['categoryName'], $category['categoryDisplay']);
                        }
                    ?>
                </select>
            </div>

            <div class="c-form_input">
                <label for="post_content">Post HTML content</label>
                <div class="c-post-content">

                    <div class="c-designer_buttons">

                        <div class="c-designer_buttons-undo">
                            <a href="#" data-command="undo" title="Undo"><span class="ico ico-undo ico-l"></span></a>
                            <a href="#" data-command="redo" title="Redo"><span class="ico ico-redo ico-l"></span></a>
                        </div>

                        <div class="c-designer_buttons-text">
                            <a href="#" data-command="bold" title="Bold"><span class="ico ico-bold ico-l"></span></a>
                            <a href="#" data-command="italic" title="Italic"><span class="ico ico-italic ico-l"></span></a>
                            <a href="#" data-command="underline" title="Underline"><span class="ico ico-underline ico-l"></span></a>
                        </div>

                        <div class="c-designer_buttons-links">
                            <a href="#" data-command="createlink" title="Create link"><span class="ico ico-link ico-l"></span></a>
                            <a href="#" data-command="insertimage" title="Insert image"><span class="ico ico-image ico-l"></span></a>
                        </div>

                        <div class="c-designer_buttons-align">
                            <a href="#" data-command="justifyLeft" title="Align left"><span class="ico ico-align-left ico-l"></span></a> 
                            <a href="#" data-command="justifyCenter" title="Align center"><span class="ico ico-align-center ico-l"></span></a> 
                            <a href="#" data-command="justifyRight" title="Align right"><span class="ico ico-align-right ico-l"></span></a>
                        </div>

                        <div class="c-designer_buttons-lists">
                            <a href="#" data-command="insertUnorderedList" title="Unordered list"><span class="ico ico-list-ul ico-l"></span></a>
                            <a href="#" data-command="insertOrderedList" title="Ordered list"><span class="ico ico-list-ol ico-l"></span></a>
                        </div>

                        <div class="c-designer_buttons-headers">
                            <a href="#" data-command="h1" title="Header 1"><span class="ico ico-heading ico-l"></span></a>
                            <a href="#" data-command="h2" title="Header 2"><span class="ico ico-heading ico-m"></span></a>
                            <a href="#" data-command="h3" title="Header 3"><span class="ico ico-heading ico-s"></span></a>
                            <a href="#" data-command="p" title="Paragraph"><span class="ico ico-paragraph ico-l"></span></a>
                        </div>

                    </div>

                    <div id="editable_post_content" contenteditable="true"><?= $_POST['post_content']; ?></div>

                    <input type="hidden" name="post_content" class="post_content">

                    <div class="c-form_buttons">
                        <button id="js-designer-btn" type="submit" class="l-btn l-btn-preview">Preview the post</button>
                        <button id="js-publish-btn" type="submit" class="l-btn l-btn-publish">Publish the post</button>
                    </div>
                </div>
            </div>

        </form> 

    </div>

    <div class="popup-publish">
        <h3>Are you sure you want to publish this post?</h3>
        <div class="c-popup-btn">
            <button id="js-publish-confirm-btn" type="submit" class="l-btn l-btn-confirm">Publish</button>        
            <button id="js-popup-close-btn" type="submit" class="l-btn l-btn-reject">Cancel</button>
        </div>
    </div>

</div>

<?php $this->end(); ?>