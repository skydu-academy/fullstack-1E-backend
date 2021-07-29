<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CommentRequest;
use App\Models\CommentPost;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ResponseHelper;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

      $comment = Post::where('id',4)->with('comment_posts')->with('user')
        ->get();
    //   $comment = CommentPost::Where('post_id',4)->join('posts', 'posts.id', '=', 'comment_posts.post_id')
    //     ->join('users', 'users.id', '=', 'posts.user_id')
    //     ->get(['users.name', 'users.profil_picture','comment_posts.comment']);
 return ResponseHelper::handleRepsonse($comment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $request->validated();
        $user_id      = Auth::user()->id;
        $post_id      = $request->post_id;
        $user = User::find($user_id);
        $user->post_comment_users()->attach($post_id, ['comment' => $request->comment]);
        $post = Post::find($post_id);
        $lastId = CommentPost::where([['user_id',"=",$user_id], ["comment", "=", $request->comment], ["post_id", "=", $post_id]])->first();
        $user->notifications()->create([
            'action_user_id'       => $post->user_id,
            'action_id'            => $lastId->id,
            'action'               => 'comment',
            'status'               => 'waiting to be seen',
        ]);
        return ResponseHelper::handleRepsonse('Comment Post success insert in db');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commentPost_data = CommentPost::find($id);
        return ResponseHelper::handleRepsonse($commentPost_data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(['comment' => 'required|max:250']);
        if(is_null(CommentPost::find($id))){
            return ResponseHelper::handleRepsonse('Update post comment failed because data not found');
        }
        CommentPost::where('id',$id)
                    ->update(['comment'=>$request->comment]);
        return ResponseHelper::handleRepsonse('Update post comment success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment_post_data = CommentPost::find($id);
        if (is_null($comment_post_data)) {
            return ResponseHelper::handleRepsonse('delete comment post failed because data not found', ResponseHelper::ERROR);
        }
        CommentPost::destroy($id);
        $notif = Notification::where([["user_id","=",Auth::user()->id], ["action_id","=", $id]])->first();
        Notification::destroy($notif->id);
        return ResponseHelper::handleRepsonse('delete post comment success');
    }

    public function commentByPostId($post_id)
    {
        $post = Post::find($post_id);
        $data = $post->user_comment_posts()->orderBy('comment_posts.created_at', 'ASC')->get()->toArray();
        $dataA = CommentPost::whereIn('post_id',[$post_id])->orderBy('comment_posts.created_at', 'ASC')->get(['id']);
        for ($i=0; $i < count($data); $i++) {
            $data[$i]['pivot']['comment_id'] = $dataA[$i]->id;
        }
        return ResponseHelper::handleRepsonse($data);
    }

    public function totalComment($post_id)
    {
        $total_like =  CommentPost::where('post_id', [$post_id])->count();
        return ResponseHelper::handleRepsonse($total_like);
    }
}
