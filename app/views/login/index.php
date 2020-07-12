<?php $this->setTitle('Login'); ?>
<?php $this->start('head'); ?>
<?php $this->end(); ?>
<?php $this->start('body'); ?>

    <div class="c-container-form">

        <h2>Login to The Blog</h2>
    
        <div class="c-form">    

            <?= $this->displayErrors; ?>

            <form class="l-form l-form-login" method="post" action="<?=SROOT?>login/check">

                <div class="c-form_input">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="username" value="<?= $_POST['username']; ?>">
                </div>

                <div class="c-form_input">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="password">
                </div>

                <div class="l-form_links">
                    <a href="<?=SROOT?>register">Don't have an account? Register here</a>
                </div>

                <button id="js-form-btn" type="submit" class="l-btn l-btn-login">Log in</button>

            </form> 

        </div>

    </div>

<?php $this->end(); ?>