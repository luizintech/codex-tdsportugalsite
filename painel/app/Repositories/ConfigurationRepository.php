<?php
namespace App\Repositories;

use App\Models\Configuration;
use App\Dtos\Result;

class ConfigurationRepository {

    public function listAll(): Result {
        $result = new Result;
        $result->objectResult = Configuration::all();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível listar os objetos";
        } else {
            $result->success = true;
        }

        return $result;
    }

    public function getById($id): Result{
        $result = new Result;
        $result->objectResult = Configuration::find($id);

        if (!$result->objectResult) {
            $result->messages = "Não foi possível recuperar o objeto";
        } else {
            $result->success = true;
        }

        return $result;
    }

    public function getByKey($key): Result{
        $result = new Result;
        $result->objectResult = Configuration::where('key', $key);

        if (!$result->objectResult) {
            $result->messages = "Não foi possível recuperar o objeto";
        } else {
            $result->success = true;
        }

        return $result;
    }

    public function update($id, $entity): Result{
        $result = new Result;

        $current = Configuration::find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->fill($entity);
        $current->save();
        $result->success = true;

        return $result;
    }

    //Other methods
    public function listAllPaging($YoutubeGrowth, $size): Result {
        $result = new Result;

        $result->total = Configuration::count();

        $result->objectResult = Configuration::orderBy('created_at', 'DESC')
            ->skip(($YoutubeGrowth - 1) * $size)
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