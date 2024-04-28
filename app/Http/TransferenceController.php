<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Services\TransferenceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class TransferenceController extends Controller
{
    private $transferenceService;

    public function __construct(TransferenceService $transferenceService)
    {
        $this->transferenceService = $transferenceService;
    }

    public function send(Request $request)
    {
        try {
            $params = $this->toValidate($request);
            $this->transferenceService->send($params);

            return response()->json(['message' => 'Ok']);
        } catch (InvalidArgumentException $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    protected function toValidate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_payer' => 'required|numeric',
            'id_payee' => 'required|numeric',
            'value' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            if (empty($validator->messages()->messages()) === false) {
                throw new InvalidArgumentException($validator->messages());
            }
        }

        return $validator->validate();
    }
}
