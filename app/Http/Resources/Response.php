<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Response extends JsonResource
{
    public string $status;
    public string $message;
    const SUCCESS = 'SUCCESS';
    const ERROR = 'ERROR';

    public function __construct(string $status, string $message, mixed $resource=[])
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }

    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->resource,
        ];
    }
}
