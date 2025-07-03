<?php

namespace App\Services;

class ImageUploadService
{
    protected $uploadPath;
    protected $allowedTypes;
    protected $maxSize;

    public function __construct()
    {
        $this->uploadPath = FCPATH . 'uploads/articles/';
        $this->allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $this->maxSize = 5 * 1024 * 1024; // 5MB
    }

    /**
     * Upload and process image
     */
    public function uploadImage($file, $options = [])
    {
        if (!$file || !$file->isValid()) {
            return ['success' => false, 'message' => 'Invalid file uploaded.'];
        }

        // Check file size
        if ($file->getSize() > $this->maxSize) {
            return ['success' => false, 'message' => 'File size too large. Maximum 5MB allowed.'];
        }

        // Check file type
        $extension = $file->getClientExtension();
        if (!in_array(strtolower($extension), $this->allowedTypes)) {
            return ['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, GIF, WEBP allowed.'];
        }

        // Generate unique filename
        $newName = $this->generateUniqueFilename($extension);
        
        try {
            // Move uploaded file
            if (!$file->move($this->uploadPath, $newName)) {
                return ['success' => false, 'message' => 'Failed to upload file.'];
            }

            $filePath = $this->uploadPath . $newName;

            // Resize image if needed
            if (isset($options['resize']) && $options['resize']) {
                $this->resizeImage($filePath, $options);
            }

            // Compress image
            if (isset($options['compress']) && $options['compress']) {
                $this->compressImage($filePath, $options['quality'] ?? 80);
            }

            return [
                'success' => true,
                'filename' => $newName,
                'path' => 'uploads/articles/' . $newName,
                'url' => base_url('uploads/articles/' . $newName),
                'size' => filesize($filePath)
            ];

        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Upload failed: ' . $e->getMessage()];
        }
    }

    /**
     * Generate unique filename
     */
    private function generateUniqueFilename($extension)
    {
        return 'article_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $extension;
    }

    /**
     * Resize image
     */
    private function resizeImage($filePath, $options)
    {
        $maxWidth = $options['max_width'] ?? 1200;
        $maxHeight = $options['max_height'] ?? 800;

        $imageInfo = getimagesize($filePath);
        if (!$imageInfo) return false;

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $type = $imageInfo[2];

        // Check if resize is needed
        if ($width <= $maxWidth && $height <= $maxHeight) {
            return true;
        }

        // Calculate new dimensions
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = intval($width * $ratio);
        $newHeight = intval($height * $ratio);

        // Create image resource
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($filePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($filePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($filePath);
                break;
            default:
                return false;
        }

        if (!$source) return false;

        // Create new image
        $destination = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG and GIF
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
            $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
            imagefilledrectangle($destination, 0, 0, $newWidth, $newHeight, $transparent);
        }

        // Resize
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save resized image
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($destination, $filePath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($destination, $filePath);
                break;
            case IMAGETYPE_GIF:
                imagegif($destination, $filePath);
                break;
        }

        // Clean up
        imagedestroy($source);
        imagedestroy($destination);

        return true;
    }

    /**
     * Compress image
     */
    private function compressImage($filePath, $quality = 80)
    {
        $imageInfo = getimagesize($filePath);
        if (!$imageInfo) return false;

        $type = $imageInfo[2];

        switch ($type) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($filePath);
                if ($image) {
                    imagejpeg($image, $filePath, $quality);
                    imagedestroy($image);
                }
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($filePath);
                if ($image) {
                    // PNG compression level (0-9)
                    $pngQuality = intval(9 - ($quality / 100) * 9);
                    imagepng($image, $filePath, $pngQuality);
                    imagedestroy($image);
                }
                break;
        }

        return true;
    }

    /**
     * Delete image file
     */
    public function deleteImage($filename)
    {
        $filePath = $this->uploadPath . $filename;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }

    /**
     * Get image info
     */
    public function getImageInfo($filename)
    {
        $filePath = $this->uploadPath . $filename;
        if (!file_exists($filePath)) {
            return false;
        }

        $imageInfo = getimagesize($filePath);
        return [
            'filename' => $filename,
            'path' => 'uploads/articles/' . $filename,
            'url' => base_url('uploads/articles/' . $filename),
            'size' => filesize($filePath),
            'width' => $imageInfo[0] ?? 0,
            'height' => $imageInfo[1] ?? 0,
            'type' => $imageInfo['mime'] ?? 'unknown'
        ];
    }

    /**
     * Create thumbnail
     */
    public function createThumbnail($filename, $width = 150, $height = 150)
    {
        $sourcePath = $this->uploadPath . $filename;
        $thumbName = 'thumb_' . $filename;
        $thumbPath = $this->uploadPath . $thumbName;

        if (!file_exists($sourcePath)) {
            return false;
        }

        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) return false;

        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];
        $type = $imageInfo[2];

        // Create source image
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }

        if (!$source) return false;

        // Create thumbnail
        $thumbnail = imagecreatetruecolor($width, $height);

        // Preserve transparency
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
            $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
            imagefilledrectangle($thumbnail, 0, 0, $width, $height, $transparent);
        }

        // Resize to thumbnail
        imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

        // Save thumbnail
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($thumbnail, $thumbPath, 85);
                break;
            case IMAGETYPE_PNG:
                imagepng($thumbnail, $thumbPath);
                break;
            case IMAGETYPE_GIF:
                imagegif($thumbnail, $thumbPath);
                break;
        }

        // Clean up
        imagedestroy($source);
        imagedestroy($thumbnail);

        return $thumbName;
    }
}
