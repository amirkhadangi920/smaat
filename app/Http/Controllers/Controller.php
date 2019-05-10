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

    /**
     * Get a request with a file and upload it's file,
     * then return the same request with uploaded file names
     *
     * @param Request $request
     * @param string $field_name
     * @param Model $model
     * @return Request
     */
    public function requestWithImage($request, $field_name = 'logo', $model = null)
    {
        if ( !$request->hasFile($field_name) )
            return $request;

        /** ! TODO */
        // if ( $model && file_exists( public_path($model->$field_name) ) )
        //         unlink( public_path($model->$field_name) );

        return collect( array_merge( $request->except($field_name), [
            $field_name => $this->upload_image( $request->file( $field_name ) )
        ]) );
    }

    /**
     * Get a request with a file and upload it's file,
     * then return the same request with uploaded file names
     *
     * @param Request $request
     * @param string $field_name
     * @param Model $model
     * @return Request
     */
    public function requestWithGallery($request, $field_name = 'gallery', $model = null)
    {
        $gallery = [];
                
        if ( $model->$field_name ?? false )
            $gallery = array_merge( $gallery, $model->$field_name );

        if ($request->deleted_images)
        {
            foreach ($request->deleted_images as $item )
            {
                foreach ( $gallery[$item] ?? [] as $image )
                {
                    if( file_exists( public_path( $image ) ) )
                        unlink( public_path( $image ) );
                
                    if ( isset( $gallery[$item] ) ) unset( $gallery[$item] );
                }
            }
        }

        if ( $request->has($field_name) )
        {
            foreach ( $request->$field_name as $file )
                $gallery[] = $this->upload_image( $file );
        }

        return collect( array_merge( $request->except($field_name), [
            $field_name => $gallery
        ]) );
    }

    /**
     * Check the user permision to access a request,
     * abort 403 status code or access deny if hadn't
     *
     * @param string $permission
     * @return void
     */
    public function checkPermission(string $permission)
    {
        if ( !auth()->check() || !auth()->user()->can($permission) )
            return abort(403);
    }
}
