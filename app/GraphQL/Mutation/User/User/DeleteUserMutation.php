<?php

namespace App\GraphQL\Mutation\User\User;

use App\GraphQL\Helpers\DeleteMutation;

class DeleteUserMutation extends BaseUserMutation
{
    use DeleteMutation;
    
    /**
     * Remove the one or multiple groups from storage.
     *
     * @param  String $features
     * @return Array\JSON
     */
    public function destroy($args)
    {
        $result = false;

        $model = $this->model::whereNotNull('tenant_id')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'owner');
        });

        if ( $args['id'] ?? false )
            $result = $model->where('id', $args['id'] ?? false)->delete();

        elseif ( $args['ids'] ?? false )
            $result = $model->whereIn('id', $args['ids'] ?? false)->delete();
        
        return [
            'status' => $result ? 200 : 400,
            'message' => $result ? 'با موفقیت حذف شد' : 'متاسفانه اطلاعاتی حذف نشد'
        ];
    }
}