<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Group\Category;
use App\Models\Spec\Spec;

class CategoryWithoutSpec implements Rule
{
    private $id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id = null)
    {
        $this->id = $id;
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
        $result = Category::whereDoesntHave('spec')
            ->whereIn('id', $value)
            ->where('tenant_id', $this->getTenant() );

        if ( $this->id )
            $result->orWhereIn('id', Spec::findOrFail($this->id)->load('categories:id')->categories->pluck('id') );
            
        return $result->count() === count($value);
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
