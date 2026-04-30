<?php
namespace App\Repositories;

use App\Models\Media;
use App\Dtos\Result;

class MediaRepository {

    public function listAll(): Result {
        $result = new Result;
        $result->objectResult = Media::all();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível listar os objetos";
        } else {
            $result->success = true;
        }

        return $result;
    }

    public function getById($id): Result{
        $result = new Result;
        $result->objectResult = Media::find($id);

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

        $current = new Media();
        $current->fill($entity);
        $current->save();

        if ($current->id > 0)
            $result->success = true;

        return $result;
    }

    public function update($id, $entity): Result{
        $result = new Result;

        $current = Media::find($id);
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

        $current = Media::find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->delete();
        $result->success = true;

        return $result;
    }

    //Other methods
    public function listAllPaging($YoutubeGrowth, $size): Result {
        $result = new Result;

        $result->total = Media::count();

        $result->objectResult = Media::with('youtube')
            ->orderBy('created_at', 'DESC')
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