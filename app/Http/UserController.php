<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        try {
            $params = $this->toValidate($request);

            $user = $this->userService->store($params);

            return response()->json([
                'message' => 'Usuário cadastrado com sucesso!',
                'data' => $user
            ], 200);
        } catch (InvalidArgumentException  $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    protected function toValidate(
        Request $request,
        bool $isUpdate = false,
        ?int $id = null
    )
    {
        $passwordField = ($isUpdate ? 'nullable' : 'required');

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'document' => 'required|min:11|max:14|unique:users,document,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'password' => $passwordField . '|min:8'
        ]);

        if ($validator->fails()) {
            if (empty($validator->messages()->messages()) === false) {
                throw new InvalidArgumentException($validator->messages(), 400);
            }
        }

        return $validator->validate();
    }
}
