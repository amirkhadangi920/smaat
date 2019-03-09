<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\MainControllerHelper;

class MainController extends Controller
{
    use MainControllerHelper;

    /**
     * Display a listing of the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->resource::collection( $this->getAllData() )->additional([
            'message' => __('messages.return.all', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->checkPermission("create-{$this->type}");

        $data = $this->storeWithImageOrNot( $request );

        if ( method_exists($this, 'afterCreate') )
            $this->afterCreate($request, $data);
        
        return (new $this->resource( $data ))->additional([
            'message' => __('messages.create.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Display the specified group with it's breadcrumb.
     *
     * @param  Model $feature
     * @return ModelResource
     */
    public function show($data)
    {
        $data = $this->getSingleData( $data );

        return (new $this->resource( $data ))->additional([
            'message' => __('messages.return.single', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);;
    }

    /**
     * Update the specified group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $data)
    {
        // $this->checkPermission("update-{$this->type}");
        
        $data = $this->getModel( $data);

        $this->updateWithImageOrNot( $request, $data );

        if ( method_exists($this, 'afterUpdate') )
            $this->afterUpdate( $request, $data );
        
        return (new $this->resource( $data ))->additional([
            'message' => __('messages.update.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Remove the one or multiple groups from storage.
     *
     * @param  String $features
     * @return Array\JSON
     */
    public function destroy($features)
    {
        // $this->checkPermission("delete-{$this->type}");
        
        $features = explode(',', $features);

        foreach ( $features as $feature )
        {
            $this->getModel( $feature )->delete();
        }

        $status = count($features) === 1 ? 'successful' : 'plural';
        
        return response()->json([
            'message' => __("messages.delete.{$status}", [
                'data' => __("types.{$this->type}.title")
            ])
        ]); 
    }
}