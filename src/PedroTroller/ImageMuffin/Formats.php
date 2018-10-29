<?php

declare(strict_types=1);

namespace PedroTroller\ImageMuffin;

use Exception;

final class Formats
{
    public const BMP  = 'bmp';
    public const GIF  = 'gif';
    public const JPEG = 'jpeg';
    public const JPG  = 'jpg';
    public const PNG  = 'png';
    public const WBMP = 'wbmp';
    public const WEBP = 'webp';
    public const XBM  = 'xbm';

    private function __construct()
    {
    }

    public static function all(): array
    {
        return [
            self::BMP,
            self::GIF,
            self::JPEG,
            self::JPG,
            self::PNG,
            self::WBMP,
            self::WEBP,
            self::XBM,
        ];
    }

    public static function mimeType(string $format): string
    {
        self::assertValid($format);

        $mimeTypes = [
            self::JPEG => 'image/jpeg',
            self::JPG  => 'image/jpeg',
            self::GIF  => 'image/gif',
            self::PNG  => 'image/png',
            self::WBMP => 'image/vnd.wap.wbmp',
            self::XBM  => 'image/xbm',
            self::WEBP => 'image/webp',
            self::BMP  => 'image/bmp',
        ];

        return $mimeTypes[$format];
    }

    public static function assertValid(string $format)
    {
        if (\in_array($format, self::all())) {
            return;
        }

        throw new Exception(sprintf(
            '"%s" is an unkown image format. Only "%s" supported.',
            $format,
            implode('" or "', self::all())
        ));
    }
}
