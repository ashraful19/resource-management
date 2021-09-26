<?php

namespace App\Services;

use DB;
use App\Repositories\Interfaces\HtmlResourceRepositoryInterface;
use App\Repositories\Interfaces\LinkResourceRepositoryInterface;
use App\Repositories\Interfaces\PdfResourceRepositoryInterface;
use App\Repositories\Interfaces\ResourceRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResourceService
{
    private $resourceRepository;
    private $pdfResourceRepository;
    private $linkResourceRepository;
    private $htmlResourceRepository;

    public function __construct(ResourceRepositoryInterface $resourceRepository, PdfResourceRepositoryInterface $pdfResourceRepository, HtmlResourceRepositoryInterface $htmlResourceRepository, LinkResourceRepositoryInterface $linkResourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
        $this->pdfResourceRepository = $pdfResourceRepository;
        $this->linkResourceRepository = $linkResourceRepository;
        $this->htmlResourceRepository = $htmlResourceRepository;
    }

    public function createResource(array $requestData)
    {
        DB::beginTransaction();
        try 
        {
            $resourceable = $this->createResourceable($requestData);
            $resource = $this->resourceRepository->create(array_merge($requestData, [
                'resourceable_type' => $resourceable->getMorphClass(),
                'resourceable_id' => $resourceable->id,
            ]));
            DB::commit();
            return $resource;
        } 
        catch (Exception $e) 
        {
            DB::rollback();
            throw $e;
        }
    }

    public function createResourceable($requestData)
    {
        $type = $requestData['type'];
        $resourceableRepository = $this->getResourceableRepository($type);
        if($type == 'pdf')
        {
            $uploadedFile = FileService::upload($requestData[$type]['fileRaw'], 'public/resources/pdfs');
            $requestData[$type]['file'] = $uploadedFile;
        }
        return $resourceableRepository->create($requestData[$type]);
    }

    public function updateResource(array $requestData, $idOrResource)
    {
        DB::beginTransaction();
        try 
        {
            $resource = $this->resourceRepository->update($requestData, $idOrResource);
            $this->updateResourceable($requestData, $resource->type, $resource->type_id);   
            DB::commit();
            return $resource;
        }
        catch (Exception $e) 
        {
            DB::rollback();
            throw $e;
        }
    }

    public function updateResourceable($requestData, $type, $id)
    {
        $resourceableRepository = $this->getResourceableRepository($type);
        if($type == 'pdf' && !empty($requestData[$type]['fileRaw']))
        {
            $uploadedFile = FileService::upload($requestData[$type]['fileRaw'], 'public/resources/pdfs');
            if(isset($requestData[$type]['file']))
            {
                FileService::delete($requestData[$type]['file']); //Old File
            }
            $requestData[$type]['file'] = $uploadedFile;
        }
        return $resourceableRepository->update($requestData[$type], $id);
    }

    public function deleteResource($id)
    {
        DB::beginTransaction();
        try {
            $resource = $this->resourceRepository->find($id);
            $this->resourceRepository->delete($resource);
            if($resource->type == 'pdf'){
                $pdfResourceable = $this->getResourceableRepository($resource->type)->find($resource->type_id);
                FileService::delete($pdfResourceable->file); //Old File
            }
            $this->getResourceableRepository($resource->type)->delete($resource->type_id);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    private function getResourceableRepository($type)
    {
        switch ($type) 
        {
            case 'pdf':
                return $this->pdfResourceRepository;
                break;
            case 'html':
                return $this->htmlResourceRepository;
                break;
            case 'link':
                return $this->linkResourceRepository;
                break;
            default:
                throw new Exception('Invalid Type.', 400);
                break;
        }
    }
}
