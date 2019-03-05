<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ImageTools;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ImageTools;

    public function requestWithImage ($request, $field_name = 'logo' )
    {
        return collect( array_merge( $request->except($field_name), [
            $field_name => $this->upload_image( $request->file( $field_name ) )
        ]) );
    }
}
