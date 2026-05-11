<?php

namespace App\Helpers;

use Psr\Http\Message\UploadedFileInterface;
use App\Helpers\Core\Result;
use Exception;

class FileUploadHelper
{
    /**
     * Upload a file with validation and return a Result.
     *
     * @param UploadedFileInterface $uploadedFile The uploaded file from the request
     * @param array $config Configuration options:
     *   - 'directory' (string): Upload directory path (required)
     *   - 'allowedTypes' (array): Array of allowed media types (required)
     *   - 'maxSize' (int): Maximum file size in bytes (required)
     *   - 'filenamePrefix' (string): Prefix for generated filenames (default: 'upload_')
     * @return Result Success with filename, or failure with error message
     */
    public static function upload(UploadedFileInterface $uploadedFile, array $config): Result
    {
        // You'll implement the method body in the following steps
        $directory= $config['directory'] ?? null;
        $allowedTypes = $config['allowedTypes'] ?? [];
        $maxSize = $config['maxSize'] ?? 0;
        $filenamePrefix = $config['filenamePrefix'] ?? 'upload';

        if(empty($directory)){
            return Result::failure('Upload directory not specified in configuration');
        }
        if(empty($allowedTypes)){
            return Result::failure('Allowed file types not specified in configuration');
        }
        if($maxSize<=0){
            return Result::failure('Maximum file size not specified in configuration');
        }
        if($uploadedFile->getError()!==UPLOAD_ERR_OK){
            return Result::failure('Error uploading file');
        }
        if($uploadedFile->getSize()>$maxSize){
            return Result::failure('File size exceeds maximum file upload size limit');
        }
        if(!in_array($uploadedFile->getClientMediaType(), $allowedTypes)){
            return Result::failure('File must be one of '.implode(',', $allowedTypes));
        }
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $newFileName=uniqid($filenamePrefix).'.'.$extension;
        if(!is_dir($directory)){
            if(!mkdir($directory, 0755, true)){
                return Result::failure('Could not find or create the directory');
            }
        }
        $path = $directory . DIRECTORY_SEPARATOR . $newFileName;
        try{
            $uploadedFile->moveTo($path);
        } catch (Exception $e){
            return  Result::failure('Failed to save uploaded file: '. $e->getMessage());
        }
        return Result::success('File uploaded successfully', ['filename'=>$newFileName]);
    }
}
