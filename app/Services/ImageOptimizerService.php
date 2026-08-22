<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Optimize and store an uploaded image with automatic WebP conversion and max dimension capping (1600px).
     *
     * @param UploadedFile $file
     * @param string $folder Relative folder in public_path (e.g. 'images/packages' or 'images/destinations')
     * @param string $prefix Name prefix slug
     * @param int $maxWidth Max width/height in pixels
     * @param int $quality Compression quality (1-100)
     * @return string Public URL path (e.g. '/images/packages/xyz.webp')
     */
    public static function storeOptimized(
        UploadedFile $file,
        string $folder = 'images/packages',
        string $prefix = 'image',
        int $maxWidth = 1600,
        int $quality = 82
    ): string {
        $targetDir = public_path($folder);
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $slugPrefix = Str::slug($prefix);
        $filename = time() . '_' . uniqid() . '_' . $slugPrefix;

        // Check if PHP GD extension with WebP support is available
        $hasGd = extension_loaded('gd') && function_exists('imagecreatefromstring');
        $hasWebp = $hasGd && function_exists('imagewebp');

        if ($hasWebp) {
            $webpFilename = $filename . '.webp';
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $webpFilename;

            $sourceImage = @imagecreatefromstring(file_get_contents($file->getRealPath()));
            if ($sourceImage !== false) {
                $origWidth = imagesx($sourceImage);
                $origHeight = imagesy($sourceImage);

                // Resize if exceeding max dimensions
                if ($origWidth > $maxWidth || $origHeight > $maxWidth) {
                    $ratio = min($maxWidth / $origWidth, $maxWidth / $origHeight);
                    $newWidth = (int) round($origWidth * $ratio);
                    $newHeight = (int) round($origHeight * $ratio);

                    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

                    // Preserve transparency for PNG/GIF
                    imagealphablending($resizedImage, false);
                    imagesavealpha($resizedImage, true);
                    $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
                    imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);

                    imagecopyresampled(
                        $resizedImage,
                        $sourceImage,
                        0, 0, 0, 0,
                        $newWidth,
                        $newHeight,
                        $origWidth,
                        $origHeight
                    );

                    imagewebp($resizedImage, $targetPath, $quality);
                    imagedestroy($resizedImage);
                } else {
                    imagealphablending($sourceImage, false);
                    imagesavealpha($sourceImage, true);
                    imagewebp($sourceImage, $targetPath, $quality);
                }

                imagedestroy($sourceImage);
                return '/' . trim($folder, '/') . '/' . $webpFilename;
            }
        }

        // Fallback: standard file move
        $ext = $file->getClientOriginalExtension() ?: 'jpg';
        $fallbackFilename = $filename . '.' . $ext;
        $file->move($targetDir, $fallbackFilename);

        return '/' . trim($folder, '/') . '/' . $fallbackFilename;
    }
}
