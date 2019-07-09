<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UniqueUserPhoneAddress implements Rule
{
    private $table;

    private $id;

    private $singular;

    private $field;

    private $has_translation;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $id = null, $field = null)
    {
        $this->table = $table;
        $this->id = $id;
        $this->singular = Str::singular( $table );
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
        $result = DB::table( $this->table );
        
        if ( $this->id )
            $result->where("{$this->table}.id", '!=', $this->id);

        $result->where($this->field ?? $attribute, $value)
            ->where('tenant_id', $this->getTenant() )
            ->where("deleted_at", null)
            ->where('user_id', auth()->id() );

        return $result->count() === 0;
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
        return trans('validation.unique');
    }
}
