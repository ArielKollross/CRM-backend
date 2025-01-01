<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProcessRequest;
use App\Http\Resources\ProcessResource;
use App\Models\Process;

class CreateProcessController extends Controller
{
    public function store(StoreProcessRequest $request)
    {
        $data = $request->validated();

        $process = Process::create($data);
        $process->columns()->createMany($data['columns']);

        return new ProcessResource($process);
    }
}
