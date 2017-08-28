<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as LumenController;

class BaseController extends LumenController
{
    public function __construct()
    {
        $this->customErrorFormat();
    }

    /**
     * Custom error response format
     *
     * @return Illuminate\Http\Response
     */
    private function customErrorFormat()
    {
        static::$errorFormatter = function ($validator) {
            $arr = [];
            foreach ($validator->errors()->toArray() as $key => $value) {
                $arr[$key] = $value[0];
            }
            return [
                'errors' => $arr,
                'status' => 'failed',
            ];
        };
    }
}
