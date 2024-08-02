<?php

namespace App\Http\Exceptions;

use Exception;
use Illuminate\Http\Response;

class NullValueException extends Exception
{
    public function __construct($message = 'Null value found', $code = 0, Exception $previous = null)
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