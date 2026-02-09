<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(public UserService $service) { }

    public function index(Request $request)
    {
        $users = $this->service->all($request->all());
        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(UserRequest $request)
    {
        $dto = $request->toDto();
        $this->service->create($dto);

        return response()->noContent();
    }

    public function update(UserRequest $request, User $user)
    {
        $dto = $request->toDto();
        $this->service->update($user, $dto);

        return response()->noContent();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
