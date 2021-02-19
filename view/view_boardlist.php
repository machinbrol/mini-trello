<!---->
<!DOCTYPE html>
<html lang="fr"><!---->
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/png" href="lib/assets/images/logo.png" />
        <title>Boards</title>
        <base href="<?= $web_root ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/b5a4564c07.js" crossorigin="anonymous"></script>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="home">
        <header id="main_header">
        <?php include('menu.php'); ?>
        </header>
        <?php if($user): ?>
        <main class="list">
            <article class="up" id="main_article">
                <h2>Your boards</h2>
                <div class="displayBoards">
                    <ul class="yourBoards">
                    <?php foreach($user->get_own_boards() as $board): ?>
                        <li><a href="board/board/<?= $board->get_id() ?>"><b><?= $board->get_title() ?></b> <?= ViewTools::get_columns_string($board->get_columns()) ?></a></li>
                    <?php endforeach; ?>
                    </ul>
                    <form class="add" action="board/add" method="post">
                        <input type="text" name="title" placeholder="Add a board">
                        <input type="submit" value="&#xf067" class="fas fa-plus">
                        <?php if ($errors->has_errors()): ?>
                            <?php include('errors.php'); ?>
                        <?php endif; ?>
                    </form>
                </div>
            </article>
            <article class="down">
                <h2>Others' boards</h2>
                    <ul class="otherBoards">
                    <?php foreach($user->get_others_boards() as $board): ?>
                        <li><a href="board/board/<?= $board->get_id() ?>"><b><?= $board->get_title() ?></b> <?= ViewTools::get_columns_string($board->get_columns()) ?><br/>by <?= $board->get_owner_fullName() ?></a></li>
                    <?php endforeach; ?>
                    </ul>
            </article>
        </main>
        <?php else:?>
        <main class="welcome">
            <p>Hello guest ! Please <a href="user/login">login</a> or <a href="user/signup">signup</a>.</p>
        </main>
        <?php endif;?>
    </body>
</html>