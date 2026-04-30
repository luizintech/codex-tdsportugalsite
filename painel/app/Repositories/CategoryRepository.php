<?php
namespace App\Repositories;

use App\Models\Category;
use App\Dtos\Result;

class CategoryRepository {

    public function listAll(): Result {
        $result = new Result;
        $result->objectResult = Category::all();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível listar os objetos";
        } else {
            $result->success = true;
        }

        return $result;
    }

    public function getById($id): Result{
        $result = new Result;
        $result->objectResult = Category::find($id);

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

        $current = new Category();
        $current->fill($entity);
        $current->save();

        if ($current->id > 0)
            $result->success = true;

        return $result;
    }

    public function update($id, $entity): Result{
        $result = new Result;

        $current = Category::find($id);
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

        $current = Category::find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->delete();
        $result->success = true;

        return $result;
    }

    //Other methods
    public function listAllPaging($pageId, $size): Result {
        $result = new Result;

        $result->total = Category::count();

        $result->objectResult = Category::orderBy('created_at', 'DESC')
            ->skip(($pageId - 1) * $size)
            ->take($size)
            ->get();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível listar os objetos";
        } else {
            $result->success = true;
        }
        return $result;
    }
}