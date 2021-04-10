<!DOCTYPE html>
<html lang="fr">
<?php $title="Edit a user"; include('head.php'); ?>

<body  class="has-navbar-fixed-top m-4">
        <header id="main_header">
            <?php include('menu.php') ?>
        </header>
        <main>
            <article>
                <section >
                    <h2 class="title">Edit a user</h2>
                    <form action="user/edit" method="post">
                        <input type="text" name="id" value="<?= $member->get_id() ?>" hidden>
                        <input type="text" name="confirm" hidden>
                        <div class="field">
                            <label class="label">Full Name</label>
                            <div class="control">
                                <input class="input" type="text" name="fullName" value="<?= $member->get_fullName() ?>">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="text" name="email" value="<?= $member->get_email() ?>">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Role</label>
                            <div class="select" >
                                <select name="role">
                                    <option value="user" <?= ViewUtils::selected_state($member, "user") ?>>User</option>
                                    <option value="admin" <?= ViewUtils::selected_state($member, "admin") ?>>Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="field mt-4">
                            <label class="checkbox">
                                <input type="checkbox" name="new_password">
                                Generate new Password
                            </label>
                        </div>

                        <div class="is-flex is-flex-direction-row mt-5 mb-5">
                            <a class="button is-light" href="user/manage">Cancel</a>
                            <input class="button is-success ml-3" type='submit' value='Edit this user'>
                        </div>
                    </form>

                </section>
                <?php if ($errors->has_errors()): ?>
                    <?php include('errors.php'); ?>
                <?php endif; ?>
            </article>
        </main>
    </body>
</html>
