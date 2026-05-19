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
        $directory = $config['directory'] ?? null;
        $allowedTypes = $config['allowedTypes'] ?? [];
        $maxSize = $config['maxSize'] ?? 0;
        $filenamePrefix = $config['filenamePrefix'] ?? 'upload_';

        if (!is_null($directory) === false) {
            return Result::failure('Upload directory not specified in configuration');
        }


        if (count($allowedTypes) === 0) {
            return Result::failure('Allowed file types not specified in configuration');
        }

        if ($maxSize <= 0) {
            return Result::failure('Maximum file size not specified in configuration');
        }

        if (!$uploadedFile->getError() === UPLOAD_ERR_OK) {
            return Result::failure('Error uploading file');
        }

        // if ($uploadedFile->getSize() > round($maxSize / (1024 * 1024), 1)) {
        //     return Result::failure('Error exceeded file size');
        // }
        if ($uploadedFile->getSize() > round($maxSize, 1)) {
            return Result::failure('Error exceeded file size');
        }
        // dd($config);
        if (!in_array($uploadedFile->getClientMediaType(), $allowedTypes)) {
            return Result::failure('Error with the file type');
            //will change later, you told us to skip validation
        }

        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $filename = uniqid($filenamePrefix) . '.' . $extension;

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0755, true)) {
                return Result::failure('Error could not make directory');
            }
        }

        $destination = $directory . DIRECTORY_SEPARATOR . $filename;

        try {
            $uploadedFile->moveTo($destination);
        } catch (Exception $e) {
            Result::failure('Failed to save uploaded file: ' . $e->getMessage());
        }

        return Result::success("File uploaded successfully", ['filename' => $filename]);
    }
}
