<?php if (count($errors_settings) > 0 ): ?>
    <div class = "error">
        <?php foreach ($errors_settings as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach ?>
    </div>
<?php endif ?>