<?php

namespace App\GraphQL\Helpers;

trait DeleteWithoutTenant
{
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
            $result = $this->model::where('id', $args['id'] ?? false)->delete();

        elseif ( $args['ids'] ?? false )
            $result = $this->model::whereIn('id', $args['ids'] ?? false)->delete();
        
        return [
            'status' => $result ? 200 : 400,
            'message' => $result ? 'با موفقیت حذف شد' : 'متاسفانه اطلاعاتی حذف نشد'
        ];
    }
}