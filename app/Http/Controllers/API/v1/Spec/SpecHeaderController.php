<?php

namespace App\Http\Controllers\API\v1\Spec;

use App\Models\Spec\SpecHeader;
use Illuminate\Http\Request;
use App\Http\Resources\Spec\SpecHeader as SpecHeaderResource;
use App\Http\Controllers\API\v1\MainController;
use App\Http\Requests\v1\Spec\SpecificationHeaderRequest;

class SpecHeaderController extends MainController
{
    /**
     * Instantiate a new MainController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [ 'store', 'update', 'destroy', 'copy' ]
        ]);
    }

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'spec_header';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = SpecHeader::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'spec:id,title,description'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SpecHeaderResource::class;

    /**
     * Get the request from url and pass it to storeData method
     * to create a new spec_header in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(SpecificationHeaderRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $spec_header in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(SpecificationHeaderRequest $request, SpecHeader $spec_header)
    {
        return $this->updateWithRequest($request, $spec_header);
    }

    /**
     * Make a copy of all the spec header rows
     * to another spec header and create it
     *
     * @param Request $request
     * @param SpecHeader $spec_header
     * @return void
     */
    public function copy(Request $request, SpecHeader $spec_header)
    {
        $this->checkPermission("copy-{$this->type}");

        $new_header = $this->model::create( $this->getRequest( $request ) );

        $new_header->rows()->saveMany(
            $spec_header->rows->map( function ($row) {
                return $row->replicate();
            })
        );
        
        return (new $this->resource( $new_header->load('rows') ))->additional([
            'message' => __('messages.copy_header_row', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }
}
