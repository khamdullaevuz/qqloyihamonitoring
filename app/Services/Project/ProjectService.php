<?php

namespace App\Services\Project;

use App\DTO\ProjectDto;
use App\Models\Project;

class ProjectService
{
    public function all(array $data)
    {
        return Project::query()->paginate();
    }

    public function create(ProjectDto $dto)
    {
        Project::create($dto->toArray());
    }

    public function update(Project $project, ProjectDto $dto)
    {
        $project->update($dto->toArray());
    }
}
