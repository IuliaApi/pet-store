<?php

use App\Helpers\ViewHelper;


ViewHelper::loadHeader($title ?? 'Home · Registration');
$account_info = $data["account_info"] ?? [];
?>



<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center"><?= hs(trans('register.title')) ?></h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= APP_BASE_URL ?>/register">
                    <div class="mb-3">
                        <label for="first_name" class="form-label"><?= hs(trans('register.first_name')) ?></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required
                            value="<?= $account_info['first_name'] ?? '' ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label"><?= hs(trans('register.last_name')) ?></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required
                            value="<?= $account_info['last_name'] ?? '' ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label"><?= hs(trans('register.username')) ?></label>
                        <input type="text" class="form-control" id="username" name="username" required
                            value="<?= $account_info['username'] ?? '' ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><?= hs(trans('register.email')) ?></label>
                        <input type="email" class="form-control" id="email" name="email" required
                            value="<?= $account_info['email'] ?? '' ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"><?= hs(trans('register.password')) ?></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text">
                            <?= hs(trans('register.password_warning')) ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label"><?= hs(trans('register.confirm_password')) ?></label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= hs(trans('register.register')) ?></button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <p><?= hs(trans('register.login_label')) ?> <a href="<?= APP_BASE_URL ?>/login"><?= hs(trans('register.login_link')) ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
