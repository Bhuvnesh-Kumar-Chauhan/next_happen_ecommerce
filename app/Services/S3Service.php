<?php

namespace App\Services;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class S3Service
{
    protected $s3;
    protected $bucket;

    public function __construct()
    {
        $this->bucket = env('AWS_BUCKET');

        $this->s3 = new S3Client([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);
    }

    public function uploadFile($file, $path = '')
    {
        try {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $path . '/' . $fileName;

            $result = $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key' => $filePath,
                'Body' => fopen($file->getPathname(), 'rb'),
                
            ]);

            return [
                'success' => true,
                'url' => $result['ObjectURL'],
                'path' => $filePath
            ];
        } catch (AwsException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function deleteFile($filePath)
    {
        try {
            $this->s3->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $filePath,
            ]);

            return [
                'success' => true,
                'message' => 'File deleted successfully'
            ];
        } catch (AwsException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getFileUrl($filePath)
    {
        try {
            return $this->s3->getObjectUrl($this->bucket, $filePath);
        } catch (AwsException $e) {
            return null;
        }
    }

    public function listFiles($prefix = '')
    {
        try {
            $objects = $this->s3->listObjectsV2([
                'Bucket' => $this->bucket,
                'Prefix' => $prefix
            ]);

            $files = [];
            if (isset($objects['Contents'])) {
                foreach ($objects['Contents'] as $object) {
                    if ($object['Key'] !== $prefix) { // Skip the directory itself
                        $files[] = [
                            'path' => $object['Key'],
                            'url' => $this->getFileUrl($object['Key']),
                            'size' => $object['Size'],
                            'last_modified' => $object['LastModified']
                        ];
                    }
                }
            }

            return $files;
        } catch (AwsException $e) {
            return [];
        }
    }

    public function updateFile($file, $existingPath)
    {
        try {
            // Delete the existing file
            $this->deleteFile($existingPath);

            // Upload the new file with the same path
            $result = $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key' => $existingPath,
                'Body' => fopen($file->getPathname(), 'rb'),
                
            ]);

            return [
                'success' => true,
                'url' => $result['ObjectURL'],
                'path' => $existingPath
            ];
        } catch (AwsException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}