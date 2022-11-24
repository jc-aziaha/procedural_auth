<?php $theme = extends_of("themes/base_admin.html.php"); ?>

<?php $title = "Accueil"; ?>

<h1 class="text-center my-3 display-5">Hello <?= $_SESSION['auth']['first_name']; ?>!</h1>

<?php if( isset($_SESSION['success']) && !empty($_SESSION['success']) ) : ?>
    <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif ?>