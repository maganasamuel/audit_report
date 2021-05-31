<?php

namespace App\Actions\Advisers;

use App\Models\Adviser;
use Illuminate\Support\Facades\Validator;

class UpdateAdviser
{
    public function update($input, Adviser $adviser)
    {
        $data = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'fsp_no' => ['required', 'integer', 'min:1', 'max:999999999'],
            'status' => ['required', 'in:Active,Terminated'],
        ], [], [
            'name' => 'Name',
            'fsp_no' => 'FSP Number',
            'status' => 'Status',
        ])->validate();

        $adviser->update($data);

        return $adviser;
    }
}
