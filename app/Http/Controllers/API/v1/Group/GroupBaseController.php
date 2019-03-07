<?php

namespace App\Http\Controllers\API\v1\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupBaseController extends Controller
{
    /**
     * Display a listing of the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => $this->model::tree(),
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
        $this->checkPermission("create-{$this->type}");

        $subject = $this->model::create( $this->requestWithImage( $request )->all() );
        
        return (new $this->resource( $subject ))->additional([
            'message' => __('messages.create.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Display the specified group with it's breadcrumb.
     *
     * @param  Subject $subject
     * @return SubjectResource
     */
    public function show($group)
    {
        $group = $this->model::whereSlug($group)->firstOrFail();

        return (new $this->resource( $group, $this->model::breadcrumb( $group ) ))->additional([
            'message' => __('messages.return.single', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);;
    }

    /**
     * Update the specified group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group)
    {
        $this->checkPermission("update-{$this->type}");

        $group = $this->model::whereSlug($group)->firstOrFail();

        $group->update( $this->requestWithImage( $request, 'logo', $group )->all() );
        
        return (new $this->resource( $group ))->additional([
            'message' => __('messages.update.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Remove the one or multiple groups from storage.
     *
     * @param  String $groups
     * @return Array\JSON
     */
    public function destroy($groups)
    {
        $groups = explode(',', $groups);

        $this->checkPermission("delete-{$this->type}");

        foreach ( $groups as $group )
        {
            Subject::whereSlug($group)->firstOrfail()->delete();
        }

        $status = count($groups) === 1 ? 'successful' : 'plural';
        
        return response()->json([
            'message' => __("messages.delete.{$status}", [
                'data' => __("types.{$this->type}.title")
            ])
        ]); 
    }
}