<!DOCTYPE html>
<html lang="fr"><!---->
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="lib/assets/images/logo.png" />
    <title>Boards "<?= $board->get_title() ?>"</title>
    <base href="<?= $web_root ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b5a4564c07.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
</head>
<body class="boardMain">
	<header>
     <?php include('menu.php'); ?>
	</header>
	<main class="board">
        <article>
            <header>
                <div class="title">
                    <h2>Board "<?= $board->get_title() ?>"</h2>
                    <?php if ($user == $board->get_owner()): ?>
                    <ul class="icons">
                        <li>
                            <form class='link' action='board/edit' method='post'>
                                <input type='text' name='id' value='<?= $board->get_id() ?>' hidden>
                                <input type='submit' value="&#xf044" class="fas fa-edit" style="background:none">
                            </form>
                        </li>
                        <li>
                            <form class='link' action='board/delete' method='post'>
                                <input type='text' name='id' value='<?= $board->get_id() ?>' hidden>
                                <input type='submit' value="&#xf2ed" class="far fa-trash-alt" style="background:none">
                            </form>
                        </li>
                    </ul>
                    <?php endif;?>
                </div>
                <p class="credit">Created <?= $board->get_created_intvl(); ?> by <strong>'<?= $board->get_owner_fullName() ?>'</strong>. <?= $board->get_modified_intvl(); ?>.</p>
            </header>
            <div class="column_display">  
                <?php include("columns.php"); ?>
                <aside class="column_form">
                    <form class="add" action="board/board" method="post">
                        <input type='text' name='id' value='<?= $board->get_id() ?>' hidden>
                        <input type='text' name='column' value='column' hidden>
                        <input type="text" name="title" placeholder="Add a column">
                        <input type="submit" value="&#xf067" class="fas fa-plus">
                    </form>
                    <?php if (count($errors) != 0): ?>
                    <div class='errors'>
                        <ul>
                            <li><?= $errors['error']; ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </aside>     
            </div>
        </article>
    </main>
</body>
</html>