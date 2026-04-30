<?php
namespace App\Repositories;

use App\Models\User;
use App\Dtos\Result;

class UserRepository {
    
    public function listAll(): Result {
        $result = new Result;
        $result->objectResult = User::all();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível listar os objetos";
        } else {
            $result->success = true;
        }
        return $result;
    }

    public function getById($id): Result{
        $result = new Result;
        $result->objectResult = User::find($id);

        if (!$result->objectResult) {
            $result->messages = "Não foi possível recuperar o objeto";
        } else {
            $result->success = true;
        }
        return $result;
    }

    public function add($entity): Result{
        $result = new Result;
        if (!$entity) {
            $result->messages = "Parâmetro não preenchido.";
            return $result;
        }

        $current = new User();
        $current->fill($entity);
        $current->save();

        if ($current->id > 0) {
            $result->id = $current->id;
            $result->success = true;
        }
        return $result;
    }

    public function update($id, $entity): Result{
        $result = new Result;
        $current = User::find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->fill($entity);
        $current->save();
        $result->success = true;
        return $result;
    }

    public function delete($id): Result {
        $result = new Result;
        $current = User::find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->delete();
        $result->success = true;
        return $result;
    }

    //Other methods
    public function getByEmail($email): Result{
        $result = new Result;
        $result->objectResult = User::where('email', $email)
            ->first();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível recuperar o objeto";
        } else {
            $result->success = true;
        }
        return $result;
    }

}