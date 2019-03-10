<?php

namespace App\Http\Controllers\API\v1\Opinion;

use App\Http\Controllers\API\v1\MainController;
use Illuminate\Http\Request;
use App\Helpers\HasUser;

class OpinionBaseController extends MainController
{
    use HasUser;

    /**
     * Instantiate a new MainController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [ 'store', 'update', 'destroy', 'accept' ]
        ]);
    }

    /**
     * Accept or unaccept one or multiple opinions in storage.
     *
     * @param  String $opinions
     * @return Array\JSON
     */
    public function accept(Request $request, $opinions)
    {
        $this->checkPermission("accept-{$this->type}");
        
        $opinions = explode(',', $opinions);

        $result = $this->model::whereIn('id', $opinions )->update(['is_accept' => $request->accept]);

        $status = $this->getStatus($result);        
        
        return response()->json([
            'message' => __("messages.accept.{$status}", [
                'data' => __("types.{$this->type}.title"),
                'type' => __("messages.accept.types.{$request->accept}")
            ])
        ]);
    }
}
