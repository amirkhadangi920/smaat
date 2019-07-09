<?php

namespace App\GraphQL\Mutation;

use Rebing\GraphQL\Support\Mutation;
use App\Traits\ImageTools;
use App\Traits\CheckPermissions;

class MainMutation extends Mutation
{
    use ImageTools, CheckPermissions;

    protected $incrementing = true;

    protected $acceptable = true;

    protected $acceptable_field = 'is_active';

    public function store($args)
    {
        $args = collect($args);

        $data = $this->storeData( $args );

        if ( method_exists($this, 'afterCreate') )
            $this->afterCreate($args, $data);
        
        return $data;
    }

    public function update($args)
    {
        $args = collect($args);

        $data = $this->getModel( $args->get('id') );

        $this->updateData( $args, $data );

        if ( method_exists($this, 'afterUpdate') )
            $this->afterUpdate( $args, $data );
        
        return $data;
    }

    /**
     * Remove the one or multiple groups from storage.
     *
     * @param  String $features
     * @return Array\JSON
     */
    public function destroy($args)
    {
        $result = false;

        if ( $args['id'] ?? false )
            $result = $this->model::whereNotNull('tenant_id')->where('id', $args['id'] ?? false)->delete();

        elseif ( $args['ids'] ?? false )
            $result = $this->model::whereNotNull('tenant_id')->whereIn('id', $args['ids'] ?? false)->delete();
        
        return [
            'status' => $result ? 200 : 400,
            'message' => $result ? 'با موفقیت حذف شد' : 'متاسفانه اطلاعاتی حذف نشد'
        ];
    }

    /**
     * Remove the one or multiple groups from storage.
     *
     * @param  String $features
     * @return Array\JSON
     */
    public function active($args)
    {
        $result = false;

        if ( $args['id'] ?? false )
            $model = $this->model::whereNotNull('tenant_id')->where('id', $args['id'] ?? false);

        elseif ( $args['ids'] ?? false )
            $model = $this->model::whereNotNull('tenant_id')->whereIn('id', $args['ids'] ?? false);


        if ( $model ?? false )
        {
            $result = $model->update([
                $this->acceptable_field => $args['status']
            ]);
        }
        
        return [
            'count'     => $result ? $result : 0,
            'status'    => $result ? 200 : 400,
            'message'   => $result
                ? 'با موفقیت '.( $args['status'] ? 'تایید' : 'رد' ).' '.( $result === 1 ? 'شد' : 'شدند' )
                : 'متاسفانه اطلاعاتی حذف نشد'
        ];
    }

    /**
     * Check the request to it'has image or not,
     * then create a data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function storeData($request)
    {
        $model = $this->createNewModel( $this->getRequest( $request ) );

        if ( isset($this->image_field) && $request->get( $this->image_field ) )
        {
            $model->addMedia( $request->get( $this->image_field ) )
                  ->toMediaCollection( $this->image_field );
        }

        return $model;
    }

    /**
     * Check the request to it'has image or not,
     * then update the data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function updateData($request, $model)
    {
        $model->update( $this->getRequest( $request ) );

        if ( isset($this->image_field) && $request->get( $this->image_field ) )
        {
            $model->clearMediaCollection( $this->image_field );
            
            $model->addMedia( $request->get( $this->image_field ) )
                  ->toMediaCollection( $this->image_field );
        }
        elseif ( isset($this->image_field) && $request->get('is_deleted_image') )
            $model->clearMediaCollection( $this->image_field );

        return $model;
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function createNewModel($data)
    {   
        return $this->model::create( $data );
    }
    
    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getModel($data)
    {
        return $this->model::whereNotNull('tenant_id')->findOrFail($data);
    }

    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        return $request->all();
    }
}