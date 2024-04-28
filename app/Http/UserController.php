<?php

namespace App\Http;

use App\Core\Support\Controller;
use App\Exceptions\UserNotFoundException;
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

    public function index(Request $request)
    {
        try {
            $params = $request->all();

            return response()->json([
                'message' => 'Dados encontrados!',
                'data' => $this->userService->index($params)
            ]);
        } catch (UserNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
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

    public function update(Request $request, int $id)
    {
        try {
            $params = $this->toValidate($request, true, $id);

            $user = $this->userService->update($params, $id);

            return response()->json([
                'message' => 'Usuário atualizado com sucesso!',
                'data' => $user
            ], 200);
        } catch (InvalidArgumentException | UserNotFoundException  $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function delete(int $id)
    {
        try {
            $this->userService->delete($id);

            return response()->json([
                'message' => 'Usuário excluído com sucesso',
            ]);
        } catch (UserNotFoundException $e) {
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
