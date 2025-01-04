<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\Process\UpdateRequest;
use App\Http\Resources\ProcessResource;
use App\Models\Process;

class UpdateProcessController extends Controller
{
    public function update(UpdateRequest $request, string $uuid)
    {
        $data = $request->validated();

        $process = Process::where('uuid', $uuid)->firstOrFail();

        $process->update([
            'name'        => $data['name'],
            'description' => $data['description'],
        ]);

        $columnsData = $data['columns'];

        $columnsToKeep = [];
        foreach ($columnsData as $column) {
            if (isset($column['uuid'])) {
                // Update existing column
                $process->columns()->where('uuid', $column['uuid'])->update([
                    'name' => $column['name'],
                    // 'order' => $column['order'],
                ]);
                $columnsToKeep[] = $column['uuid'];

                continue;
            }

            $newColumn = $process->columns()->create($column);
            $columnsToKeep[] = $newColumn->uuid;
        }

        $process->columns()->whereNotIn('uuid', $columnsToKeep)->delete();

        return new ProcessResource($process);
    }
}
