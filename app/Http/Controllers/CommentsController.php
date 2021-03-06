<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Rules\FreeSpam;
use App\Thread;
use App\Comment;

class CommentsController extends Controller
{

    public function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
    }


    /**
     * @param Thread $thread
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Thread $thread)
    {
        return $thread->comments()->latest()->paginate(15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Thread $thread, CreateCommentRequest $request)
    {
        return $request->persist($thread);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);
//        $this->authorize('create', new $comment);

        $data = request()->validate([
            'body' => ['required', 'string', 'max:1000', new FreeSpam()]
        ]);

        $comment->body = $data['body'];
        $comment->save();

        if(request()->expectsJson()){
            return response([], 204);
        }

        return back();
    }


    /**
     * @param Comment $comment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        if(request()->expectsJson()){
            return response([], 204);
        }

        return back();
    }
}
