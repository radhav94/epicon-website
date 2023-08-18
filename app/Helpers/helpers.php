<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\UTCDateTime;


if (! function_exists('JSONResponse')) {
    function JSONResponse(int $statusCode, string $message, array $data = []): JsonResponse
    {
        return response()->json(
            data: [
                'message' => $message,
                'payload' => $data,
            ],
            status: $statusCode,
        );
    }
}

if (! function_exists('d')) {

    function d($data, $die = false)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($die) {
            exit;
        }
    }
}

function CurlAPI($context, $method = 'GET', $data = null)
{
    if (empty($context)) return;

    return ApiHelper::api($context, $method, $data);
}

