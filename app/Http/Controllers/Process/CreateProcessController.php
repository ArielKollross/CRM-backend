<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\Process\StoreRequest;
use App\Http\Resources\ProcessResource;
use App\Models\Process;

class CreateProcessController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $process = Process::create($data);
        $process->columns()->createMany($data['columns']);

        return new ProcessResource($process);
    }
}
