<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class MainRequest extends FormRequest
{
    protected $method = 'CREATE';

    public function requiredOrFilled()
    {
        if ( $this->method === 'CREATE' )
            return 'required';

        elseif ( $this->method === 'UPDATE' )
            return 'filled';
    }
}
 
 