<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Exceptions\UserNotFoundException;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class AccountController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index(Request $request)
    {
        try {
            $params = $request->all();

            return response()->json([
                'message' => 'Dados encontrados!',
                'data' => $this->accountService->index($params)
            ]);
        } catch (UserNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function store(Request $request)
    {
        try {
            $params = $this->toValidate($request);

            $account = $this->accountService->store($params);

            return response()->json([
                'message' => 'Conta cadastrada com sucesso!',
                'data' => $account
            ], 200);
        } catch (InvalidArgumentException | UserNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    protected function toValidate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|numeric',
            'balance' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            if (empty($validator->messages()->messages()) === false) {
                throw new InvalidArgumentException($validator->messages(), 400);
            }
        }

        return $validator->validate();
    }
}
