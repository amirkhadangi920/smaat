<?php

namespace App\Http\Controllers\API\v1\User;

use App\Role;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Resources\User\Role as RoleResource;
use App\ModelFilters\User\RoleFilter;
use App\Http\Requests\User\v1\RoleRequest;
use App\Http\Resources\User\RoleCollection;

class RoleController extends MainController
{
    /**
     * Instantiate a new MainController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [ 'index', 'show', 'store', 'update', 'destroy' ]
        ]);
    }

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
        'permissions:id'
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
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = RoleCollection::class;

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
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        $this->checkPermission("read-role");

        return $this->model::filter( request()->all(), $this->filter )->with($this->relations)->withCount('permissions')->latest()->get();
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getSingleData($data)
    {
        $this->checkPermission("read-role");
        
        return $this->model::with( $this->more_relations )->findOrFail($data);
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
