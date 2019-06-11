<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    protected $repository;

    public function __construct(CommentRepository $repository) {

        $this->repository = $repository;
    }

    public function index()
    {
        $comments = Comment::with('user', 'replies.user')
                ->orderBy('id', 'desc')
                ->where('parent_id', null)
                ->take(3)
                ->get();
        $totalCommentsCount = Comment::where('parent_id', null)->count();

        return response()->json(compact('comments', 'totalCommentsCount'), Response::HTTP_OK);
    }

    public function getMore()
    {
        $skip = request()->input('skip');
        $comments = Comment::with('user', 'replies.user')
                ->orderBy('id', 'desc')
                ->where('parent_id', null)
                ->skip($skip)
                ->take(3)
                ->get();

        return response()->json($comments, Response::HTTP_OK);
    }

    public function store()
    {
        $rules = $this->repository->getModel()->getRules();
        $this->validate(request(), $rules);

        $comment = new Comment;
        $comment->user_id = Auth::id();
        $comment->content = request()->input('content');
        $comment->parent_id = request()->input('parent_id');
        $comment->save();

        $comment->load('user', 'replies.user');

        return response()->json($comment, Response::HTTP_CREATED);
    }
}
