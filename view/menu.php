<div class=menu>
    <div class=left>
        <h1>Trello!</h1>
    </div>
    <div class=right>
        <!-- code php 
        si user connecté -> fullname + logout
        else login + icone user+ (à définir) -->
        <?php if (isset($user) && $user !== FALSE): ?>
            <p><i class="fas fa-user"></i><?= $user->get_fullName() ?><a href="user/logout"><i class="fas fa-sign-out-alt"></i></a></p>
        <?php else: ?>
            <p><a href="user/login"><i class="fas fa-sign-in-alt"></i></a>&nbsp<i class="fas fa-user-plus"></i></p>
        <?php endif;?>
    </div>
</div>