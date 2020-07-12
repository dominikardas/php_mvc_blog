<?php $this->setTitle('Register'); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <div class="c-container-form">

        <h2>Register to The Blog</h2>
    
        <div class="c-form">    

            <?= $this->displayErrors; ?>
            <?= $this->displaySuccess; ?>

            <form class="l-form l-form-register" method="post" action="<?=SROOT?>register/check">

                <div class="c-form_input">
                    <label for="first_name">First name</label>
                    <input type="text" name="first_name" class="first_name" value="<?= $_POST['first_name']; ?>">
                </div>

                <div class="c-form_input">
                    <label for="last_name">Last name</label>
                    <input type="text" name="last_name" class="last_name" value="<?= $_POST['last_name']; ?>">
                </div>

                <div class="c-form_input">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="username" value="<?= $_POST['username']; ?>">
                </div>

                <div class="c-form_input">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="password">
                </div>

                <div class="c-form_input">
                    <label for="password_r">Repeat password</label>
                    <input type="password" name="password_r" class="password_r">
                </div>

                <div class="l-form_links">
                    <a href="<?=SROOT?>login">Already have an account? Login here</a>
                </div>

                <button id="js-form-btn" type="submit" class="l-btn l-btn-register">Register</button>

            </form> 

        </div>

    </div>

<?php $this->end(); ?>