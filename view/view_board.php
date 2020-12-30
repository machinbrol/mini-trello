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
                    <?php if ($user == $board->get_owner()): ?>
                    <ul class="icons">
                        <li>
                            <form class='editTitle' action='board/board/<?= $board->get_id() ?>' method='post'>
                                <input type='text' name='id' value='<?= $board->get_id() ?>' hidden>
                                <input type='text' name='instance' value='board' hidden>
                                <input type ="checkbox" id="toggle">
                                <label for="toggle"><i class="fas fa-edit"></i></label>
                                <input class="control" type="text" name="title" value="<?= $board->get_title() ?>">
                                <input class="fas fa-paper-plane" type="submit" value="&#xf1d8">
                                <button class="control"><i class="fas fa-arrow-left"></i></button>
                                <h2>Board "<?= $board->get_title() ?>"</h2>
                            </form>
                        </li>
                        <li>
                            <form class='link' action='board/delete' method='post'>
                                <input type='text' name='id' value='<?= $board->get_id() ?>' hidden>
                                <input type='submit' value="&#xf2ed" class="far fa-trash-alt" style="background:none">
                            </form>
                        </li>
                    </ul>
                    <?php endif; ?>
                    <?php if (count($errors) != 0 && $errors['instance'] == "board"): ?>
                    <div class='errors'>
                        <ul>
                            <li><?= $errors['error']; ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <p class="credit">Created <?= $board->get_created_intvl(); ?> by <strong>'<?= $board->get_owner_fullName() ?>'</strong>. <?= $board->get_modified_intvl(); ?>.</p>
            </header>
            <div class="column_display">  
                <?php include("columns.php"); ?>
                <aside class="column_form">
                    <form class="add" action="board/board/<?= $board->get_id() ?>" method="post">
                        <input type='text' name='id' value='<?= $board->get_id() ?>' hidden>
                        <input type='text' name='instance' value='column' hidden>
                        <input type='text' name='action' value='add' hidden>
                        <input type="text" name="title" placeholder="Add a column">
                        <input type="submit" value="&#xf067" class="fas fa-plus">
                    </form>
                    <?php if (count($errors) != 0 && $errors['instance'] == "column" && $errors['action'] == "add"): ?>
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