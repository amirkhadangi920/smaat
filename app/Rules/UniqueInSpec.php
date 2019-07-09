<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UniqueInSpec implements Rule
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
    public function __construct($table, $args = null, $field = null)
    {
        $this->table = $table;
        $this->args = $args;
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

        $result->join("{$this->singular}_translations", "{$this->table}.id", '=', "{$this->singular}_translations.{$this->singular}_id");
        
        if ( isset( $this->args['id'] ) )
            $result->where("{$this->table}.id", '!=', $this->args['id']);

        $result->where($attribute, $value)
            ->where($this->field, $this->args[ $this->field ] ?? false)
            ->where("{$this->table}.deleted_at", null);

        return $result->count() === 0;
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
