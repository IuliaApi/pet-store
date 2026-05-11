<?php

namespace App\Controllers;

use App\Helpers\FileUploadHelper;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = ['title' => 'File Upload'];
        return $this->render($response, 'admin/upload/uploadView.php', $data);
    }

    /**
     * Process file upload.
     */
    public function upload(Request $request, Response $response, array $args): Response
    {
        $files = $request->getUploadedFiles();
        // Extract 'myfile' from the array
        $myFile = $files['myfile'];
        $config=[
            'directory' => APP_BASE_DIR_PATH . '/public/uploads/images',
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif'],
            'maxSize' => 2 * 1024 * 1024,
            'filenamePrefix' => 'upload_'
        ];
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
        return $this->redirect($request, $response, 'upload.index');
    }
}
