<?php

namespace App\Http\Controllers\API\v1\User;

use App\Role;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\User\Role as RoleResource;
use App\ModelFilters\User\RoleFilter;
use App\Http\Requests\User\v1\RoleRequest;

class RoleController extends MainController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'role';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Role::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        // 'subjects',
        // 'user:id:first_name,last_name'
    ];

    protected $more_relations = [
        'permissions'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = RoleResource::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = RoleFilter::class;

    /**
     * Get the request from url and pass it to storeData method
     * to create a new role in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(RoleRequest $request)
    {
        return $this->storeWithRequest(
            $request->merge([ 'name' => str_slug( $request->display_name ) ])
        );
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $role in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(RoleRequest $request, Role $role)
    {
        return $this->updateWithRequest($request, $role);
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterCreate($request, $role)
    {
        $role->attachPermissions( $request->permissions );        
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterUpdate($request, $role)
    {
        $role->syncPermissions( $request->permissions );
    }

    /**
     * Remove the one or multiple groups from storage.
     *
     * @param  String $features
     * @return Array\JSON
     */
    public function destroy($roles)
    {
        // $this->checkPermission("delete-{$this->type}");
        
        $roles = explode(',', $roles);

        $result = $this->model::whereIn($this->getPrimary(), $roles )->where('name', '!=', 'owner')->delete();

        $status = $this->getStatus($result);

        return response()->json([
            'message' => __("messages.delete.{$status}", [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }
}
