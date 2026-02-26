<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\Project\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        public ProjectService $service
    ) { }

    public function index(Request $request)
    {
        $projects = $this->service->all($request->all());

        return ProjectResource::collection($projects);
    }

    public function store(ProjectRequest $request)
    {
        $dto = $request->toDto();
        $this->service->create($dto);

        return response()->noContent();
    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $dto = $request->toDto();
        $this->service->update($project, $dto);

        return response()->noContent();
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return response()->noContent();
    }
}
