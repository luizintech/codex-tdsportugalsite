<?php
namespace App\Repositories;

use App\Models\PostComment;
use App\Dtos\Result;

class PostCommentRepository {

    public function listAllFromPost($postId, $pageId, $size): Result {
        $result = new Result;

        $result->total = PostComment::count();

        $result->objectResult = PostComment::where('post_id', $postId)
            ->orderBy('created_at', 'DESC')
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

    public function add($entity): Result{
        $result = new Result;

        if (!$entity) {
            $result->messages = "Parâmetro não preenchido.";
            return $result;
        }

        $current = new PostComment();
        $current->fill($entity);
        $current->save();

        if ($current->id > 0)
            $result->success = true;

        return $result;
    }

    public function update($id, $entity): Result{
        $result = new Result;

        $current = PostComment::find($id);
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

        $current = PostComment::find($id);
        if (!$current) {
            $result->messages = "Não encontrado.";
            return $result;
        }

        $current->delete();
        $result->success = true;

        return $result;
    }

    //Other methods
    public function total(): Result {
        $result = new Result;
        $result->total = PostComment::count();
        $result->success = true;
        return $result;
    }

    public function listAllApprovedForPost($postId, $pageId, $size): Result {
        $result = new Result;

        $result->total = PostComment::count();

        $result->objectResult = PostComment::where('approved', 1)
            ->where('post_id', $postId)
            ->orderBy('created_at', 'DESC')
                ->thenBy('id', 'DESC')
            ->get();

        if (!$result->objectResult) {
            $result->messages = "Não foi possível listar os objetos";
        } else {
            $result->success = true;
        }
        return $result;
    }
}