<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Resource\ResourceRequest;
use Exception;
use Illuminate\Http\Response;
use App\Http\Resources\ResourceResource;
use App\Models\Resource\Resource;
use App\Repositories\Interfaces\ResourceRepositoryInterface;
use App\Services\FileService;
use App\Services\ResourceService;
use Illuminate\Http\Request;

class ManagementController extends BaseController
{
    private $resourceRepository;
    private $resourceService;

    public function __construct(ResourceRepositoryInterface $resourceRepository, ResourceService $resourceService)
    {
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $resources = $this->resourceRepository->all(['resourceable']);
            return $this->respondWithSuccess('Resources Loaded.', [
                'resources' => ResourceResource::collection($resources)
            ]);
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResourceRequest $request)
    {
        try {
            $resource = $this->resourceService->createResource($request->all());
            return $this->respondWithSuccess('Resource Created.', ['resource' => new ResourceResource($resource)], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        try {
            return $this->respondWithSuccess('Resource Loaded.', ['resource' => new ResourceResource($resource)]);
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResourceRequest $request, Resource $resource)
    {
        try {
            $resource = $this->resourceService->updateResource($request->all(), $resource);
            return $this->respondWithSuccess('Resource Updated.', ['resource' => new ResourceResource($resource)], Response::HTTP_ACCEPTED);
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->resourceService->deleteResource($id);
            return $this->respondWithSuccess('Resource Deleted.');
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function pdfDownload(Resource $resource)
    {
        try {
            if($resource->type == 'pdf' && $resource->resourceable)
            {
                return FileService::download($resource->resourceable->file);
            }
            else
            {
                return $this->respondWithError('Failed Downloading the File');
            }
        } catch (Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
