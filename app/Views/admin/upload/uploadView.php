<?php

use App\Helpers\ViewHelper;

ViewHelper::loadAdminHeader($title ?? 'File Upload');
?>

<div class="card mb-4">
    <div class="card-header">
        <h5>Upload an Image</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="<?= APP_BASE_URL ?>/admin/upload" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="myfile" class="form-label">Choose a file:</label>
                <input
                    type="file"
                    class="form-control"
                    id="myfile"
                    name="myfile"
                    accept="image/*"
                    required>
                <div class="form-text">
                    Select an image file to upload (JPEG, PNG, GIF).
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Upload File</button>
        </form>
    </div>
</div>

<?php ViewHelper::loadAdminFooter(); ?>
