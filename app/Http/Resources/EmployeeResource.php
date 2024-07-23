<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public $data;
    public $message;
    public $code;

    public function __construct($data, $message, $code)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
