<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcessResource;
use App\Models\Process;

class ListProcessesController extends Controller
{
    public function index()
    {
        $processes = Process::all();

        return ProcessResource::collection($processes);
    }
}
