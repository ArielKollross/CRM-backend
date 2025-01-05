<?php

namespace App\Http\Controllers\Card;

use App\Http\Controllers\Controller;
use App\Http\Requests\Card\StoreRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Models\Customer;
use App\Models\Process;
use App\Models\ProcessColumn;

class CreateCardController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $card = $this->create($data);

        return new CardResource($card);
    }

    private function create(array $data)
    {
        $card = Card::create($data);

        if (isset($data['process_uuid'])) {
            $process = Process::whereUuid($data['process_uuid'])->firstOrFail();

            $card->update([
                'process_id' => $process->id,
            ]);
        }

        if (isset($data['column_uuid'])) {
            $column = ProcessColumn::whereUuid($data['column_uuid'])->firstOrFail();

            $card->update([
                'process_column_id' => $column->id,
            ]);
        }

        if (isset($data['customer_uuid'])) {
            $customer = Customer::where('uuid', $data['customer_uuid'])->firstOrFail();

            $card->update([
                'customer_id' => $customer->id,
            ]);
        }

        return $card;
    }
}
