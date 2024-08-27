<?php

namespace Exan\Mir;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Mir
{
    private array $images = [];
    private const BOUNDARY = 'EXAN-MIR-BOUNDARY';

    public function addImage(File $image)
    {
        $this->images[] = $image->getBase64();
    }

    public function toResponse(int $status = 200, array $additionalHeaders = []): ResponseInterface
    {
        $body = '--' . self::BOUNDARY . PHP_EOL;
        $body .= implode(PHP_EOL . self::BOUNDARY . PHP_EOL, $this->images);
        $body .= PHP_EOL . self::BOUNDARY . '--';

        $response = new Response(
            $status,
            [
                ...$additionalHeaders,
                'Content-Type' => 'multipart/base64images;boundary=' . self::BOUNDARY,
            ],
            $body,
        );

        return $response;
    }
}
