<?php

use App\Helpers\ViewHelper;
use App\Helpers\FlashMessage;

ViewHelper::loadHeader($title ?? 'Login · Registration');
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center"><?= hs(trans('login.login')) ?></h3>
            </div>
            <div class="card-body">
                <form method="POST" action="<?= APP_BASE_URL ?>/login">
                    <div class="mb-3">
                        <label for="identifier" class="form-label"><?= hs(trans('login.email_label')) ?></label>
                        <input
                            type="text"
                            class="form-control"
                            id="identifier"
                            name="identifier"
                            placeholder=<?= hs(trans('login.email_input')) ?>
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"><?= hs(trans('login.password_label')) ?></label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="<?= hs(trans('login.password_input')) ?>"
                            required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary"><?= hs(trans('login.login')) ?></button>
                    </div>
                </form>

                <div class="mt-3 text-center">
                    <p><?= hs(trans('login.register_label')) ?> <a href="<?= APP_BASE_URL ?>/register"><?= hs(trans('login.register_link')) ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ViewHelper::loadFooter(); ?>
