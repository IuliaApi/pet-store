<?php

namespace App\Controllers;

use App\Helpers\FileUploadHelper;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
<<<<<<< Updated upstream
use Override;
=======
use LDAP\Result;
>>>>>>> Stashed changes
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadController extends BaseController
{
<<<<<<< Updated upstream
=======
    //TODO: Add a constructor that calls the parent constructor.
>>>>>>> Stashed changes
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }
<<<<<<< Updated upstream

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = ['title' => 'File Upload'];
        return $this->render($response, 'admin/upload/uploadView.php', $data);
=======
    /**
     * Display the upload form.
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => 'File Upload'
        ];

        // session_destroy();
        return $this->render($response, 'admin/upload/uploadView.php', $data);

        // TODO: Create a $data array with 'title' => 'File Upload'

        // TODO: Render 'admin/upload/uploadView.php' view and pass $data
>>>>>>> Stashed changes
    }

    /**
     * Process file upload.
     */
    public function upload(Request $request, Response $response, array $args): Response
    {
<<<<<<< Updated upstream
        $files = $request->getUploadedFiles();
        // Extract 'myfile' from the array
        $myFile = $files['myfile'];
        $config=[
            'directory' => APP_BASE_DIR_PATH . '/public/uploads/images',
=======
        // TODO: Get uploaded files using $request->getUploadedFiles()
        $uploadedFiles = $request->getUploadedFiles();
        // TODO: Extract 'myfile' from the array
        $myFile = $uploadedFiles['myfile'];

        // TODO: Create $config array with:
        //       - 'directory' => APP_BASE_DIR_PATH . '/public/uploads/images'
        //       - 'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif']
        //       - 'maxSize' => 2 * 1024 * 1024 (2MB in bytes)
        //       - 'filenamePrefix' => 'upload_'

        $config = [
            'directory' => APP_IMAGES_UPLOADS_DIR,
>>>>>>> Stashed changes
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif'],
            'maxSize' => 2 * 1024 * 1024,
            'filenamePrefix' => 'upload_'
        ];
<<<<<<< Updated upstream
        $result = FileUploadHelper::upload($myFile, $config);
        if($result->isSuccess()){
            $filename = $result->getData()['filename'];
            $uploadedFiles = SessionManager::get('uploaded_files') ?? [];
            $uploadedFiles[] = $filename;
            SessionManager::set('uploaded_files', $uploadedFiles);
            FlashMessage::success('You have successfully uploaded '.$filename.'.');
        } else {
            $errorMessage = $result->getMessage();
            FlashMessage::error($errorMessage);
        }
=======

        // TODO: Call FileUploadHelper::upload() with uploaded file and config

        $result = FileUploadHelper::upload($myFile, $config);
        // TODO: Check if result is successful using isSuccess()
        if ($result->isSuccess()) {
            // If successful:
            //   1. Get the filename from the result data
            $data = $result->getData();
            $filename = $data['filename'];
            //   2. Retrieve the existing 'uploaded_files' array from the session (default to [])
            $stored_files =   $_SESSION['uploaded_files'] ?? [];
            //   3. Append the new filename to the array and save it back to the session
            $stored_files[] = $filename;
            $_SESSION['uploaded_files'] = $stored_files;

            //   4. Display a success flash message
            FlashMessage::success("$filename was uploaded successfully");
        } else {
            // If not successful:
            //   1. Get the error message from the result object
            $errorMessage = $result->getMessage();
            //   2. Display an error flash message
            FlashMessage::error($errorMessage);
        }
        // TODO: Redirect back to 'upload.index'
>>>>>>> Stashed changes
        return $this->redirect($request, $response, 'upload.index');
    }
}
