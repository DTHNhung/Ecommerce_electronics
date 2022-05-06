<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\UpdateRequest;
use App\Http\Requests\Comments\StoreRequest;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Usernotnull\Toast\Concerns\WireToast;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function comment(StoreRequest $request)
    {
        $this->commentRepo->create($request->all());

        return back()->with('message-cmt', __('messages.add-success', ['name' => __('titles.comment')]));
    }

    public function update(UpdateRequest $request, $id)
    {
        $this->commentRepo->update($id, $request->only('content'));

        return back()->with('message-cmt', __('messages.update-success', ['name' => __('titles.comment')]));
    }

    public function destroy($id)
    {
        $this->commentRepo->delete($id);

        return back()->with('message-cmt', __('messages.delete-success', ['name' => __('titles.comment')]));
    }
}
