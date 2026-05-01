<?php
namespace App\Repositories;

use App\Models\Post;
use App\Dtos\Result;

class PostRepository {

    public function listAll(): Result {
        $result = new Result;
        $result->objectResult = Post::all();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível listar os objetos";
        } else {
            $result->success = true;
        }

        return $result;
    }

    public function getById($id): Result{
        $result = new Result;
        $result->objectResult = Post::with(['labels', 'categories', 'coverMedia'])->find($id);

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

        $current = new Post();
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

        $current = Post::with(['labels', 'categories', 'coverMedia'])->find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->fill($entity);
        $current->save();
        $result->id = $current->id;
        $result->success = true;

        return $result;
    }

    public function delete($id): Result {
        $result = new Result;

        $current = Post::with(['labels', 'categories', 'coverMedia'])->find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->delete();
        $result->id = $id;
        $result->success = true;

        return $result;
    }


    public function syncRelations($postId, array $labelIds, array $categoryIds): Result {
        $result = new Result;

        $current = Post::find($postId);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->labels()->sync($labelIds);
        $current->categories()->sync($categoryIds);

        $result->id = $current->id;
        $result->success = true;
        return $result;
    }

    //Other methods
    public function listAllPaging($YoutubeGrowth, $size, array $filters = []): Result {
        $result = new Result;

        $query = Post::with(['coverMedia', 'labels', 'categories'])
            ->orderBy('created_at', 'DESC');

        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['category_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category_id']);
            });
        }

        if (!empty($filters['label_id'])) {
            $query->whereHas('labels', function ($q) use ($filters) {
                $q->where('labels.id', $filters['label_id']);
            });
        }

        $result->total = (clone $query)->count();

        $result->objectResult = $query
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