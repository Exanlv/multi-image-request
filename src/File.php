<?php

namespace Exan\Mir;

use Mimey\MimeTypes;
use RuntimeException;

class File
{
    public function __construct(public readonly string $filePath)
    {
        if (!file_exists($filePath)) {
            throw new RuntimeException('File does not exist ' . $filePath);
        }
    }

    public function getBase64()
    {
        $path = explode('.', $this->filePath);
        $extension = $path[count($path) - 1];

        $mime = (new MimeTypes())->getMimeType($extension);

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($this->filePath));
    }
}
