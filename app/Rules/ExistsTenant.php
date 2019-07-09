<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsTenant implements Rule
{
    private $table;

    private $field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table = null, $field = 'id')
    {
        $this->table = $table;
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = DB::table( $this->table ? $this->table : $attribute );

        if ( gettype($value) === 'array' )
            $result->whereIn($this->field, $value);
            
        else
            $result->where($this->field, $value);

        $result->where(function($query) {
            $query->where('tenant_id', $this->getTenant())->orWhere('tenant_id', null);
        });

        if ( gettype($value) === 'array' )
            return $result->count() === count($value);
            
        else
            return $result->count() === 1;
    }

    public function getTenant()
    {
        return cache()->rememberForever(request()->getHost(), function () {
            return Hostname::whereDomain( request()->getHost() )->first()->tenant_id ?? abort(404);
        });
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.exists');
    }
}
