<?php

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NotAthorizedException extends Exception
{
    public function __construct($message = 'Not authorized', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }
}