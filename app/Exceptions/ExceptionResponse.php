<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

class ExceptionResponse extends JsonResponse {

    /**
     * Constructor.
     *
     * @param  string $message
     * @param  int  $status
     * @param  array  $headers
     * @param  int  $options
     * @param  bool  $json
     * @return void
     */
    public function __construct(string $message = '', int $status = 200, array $headers = [], int $options = 0, bool $json = false)
    {
        $data = ['message' => $message];
        parent::__construct($data, $status, $headers, $json);
    }


    public function setMessage(string $message)
    {
        return Response::json();
    }
}