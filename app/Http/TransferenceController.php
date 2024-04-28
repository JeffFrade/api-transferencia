<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Exceptions\AccountNotFoundException;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\IsShopkeeperException;
use App\Exceptions\UnauthorizedTransferException;
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
            $message = $this->transferenceService->send($params);
            $code = 200;
        } catch (
            AccountNotFoundException |
            InsufficientBalanceException |
            InvalidArgumentException |
            IsShopkeeperException |
            UnauthorizedTransferException $e
        ) {
            $code = $e->getCode();
            $message = [
                'error' => $e->getMessage()
            ];
        } finally {
            $message = $message ?? 'Erro interno, favor consultar a TI';

            return response()->json($message, $code ?? 500);
        }
    }

    protected function toValidate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'payer' => 'required|numeric',
            'payee' => 'required|numeric',
            'value' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            if (empty($validator->messages()->messages()) === false) {
                throw new InvalidArgumentException($validator->messages(), 400);
            }
        }

        return $validator->validate();
    }
}
