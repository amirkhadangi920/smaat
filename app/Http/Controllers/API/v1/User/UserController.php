<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\API\v1\MainController;
use App\ModelFilters\User\UserFilter;
use App\User;
use App\Http\Requests\User\v1\UserRequest;
use App\Http\Resources\User\User as UserResource;
use App\Http\Resources\User\Permission as PermissionResource;
use App\Permission;
use App\Http\Requests\User\v1\PasswordResetRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserCollection;

class UserController extends MainController
{
    /**
     * Instantiate a new MainController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [ 'index', 'show', 'update', 'destroy', 'permissions' ]
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
    protected $model = User::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'roles:id,name,display_name',
    ];

    protected $more_relations = [
        'permissions'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = UserResource::class;
    
    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = UserCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = UserFilter::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'avatar';

    /**
     * Get the request from url and pass it to updateData method
     * to update the $role in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(UserRequest $request, User $user)
    {   
        return $this->updateWithRequest($request, $user);
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterUpdate($request, $user)
    {
        $user->syncPermissions( $request->permissions ?? [] );
        $user->syncRoles( $request->roles ?? [] );
    }
    
    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        $result = $request->only(
            'city_id',
            'first_name',
            'last_name',
            'phones',
            'social_links',
            'email',
            'avatar',
            'address',
            'postal_code'
        );

        return gettype( $result ) === 'array' ? $result : $result->all();
    }

    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        $this->checkPermission("read-user");

        return $this->model::select(
            'id', 'first_name', 'last_name', 'phones', 'email', 'avatar', 'address', 'created_at', 'updated_at'
        )
            ->filter( request()->all(), $this->filter )
            ->latest()
            ->paginate( $this->getPerPage() );
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
        $this->checkPermission("read-user");

        $this->relations = array_merge( $this->relations, $this->more_relations );

        return $this->model::with( $this->relations )->findOrFail($data);
    }

    /**
     * return all the permissions of the logged in user
     *
     * @return void
     */
    public function permissions()
    {
        return PermissionResource::collection( auth()->user()->allPermissions() )->additional([
            'message' => __('messages.return.all', [
                'data' => __("types.permission.plural")
            ])
        ]);
    }

    /**
     * Attach a specific permission to specific user
     *
     * @param [type] $permission
     * @return void
     */
    public function attach_permission(User $user, Permission $permission)
    {
        if ( $user->can( $permission->name ) )
        {
            return response()->json([
                'message' => __('messages.permission.attach.before', [
                    'permission' => $permission,
                    'user' => $user->full_name
                ])
            ]);
        } else {
            $user->attachPermission($permission);
    
            return response()->json([
                'message' => __('messages.permission.attach.successful', [
                    'permission' => $permission,
                    'user' => $user->full_name
                ])
            ]);
        }
    }

    /**
     * Detach a specific permission from specific user
     *
     * @param [type] $permission
     * @return void
     */
    public function detach_permission(User $user, $permission)
    {
        $user->detachPermission($permission);

        return response()->json([
            'message' => __('messages.permission.detach', [
                'permission' => $permission,
                'user' => $user->full_name
            ])
        ]);
    }

    /**
     * Reset a password of specific user
     *
     * @param User $user
     * @return void
     */
    public function password_reset(PasswordResetRequest $request, User $user)
    {
        $user->update([ 'passwrod' => Hash::make( $request->password ) ]);

        return response()->json([
            'message' => __('messages.9', [
                'user' => $user->full_name
            ])
        ]);
    }
}
