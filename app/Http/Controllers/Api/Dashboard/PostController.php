<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
           try{
            $request->validated();
            $image          = $request->image;
            $file_name      = md5('skybook'.time()). "." .$image->getClientOriginalExtension();
            $user           = User::find(Auth::user()->id);
            $user->posts()->create([
                'caption'   => $request->caption,
                'image'     => $file_name,
            ]);
            $image->storeAs('public/posts', $file_name);
            return ResponseHelper::handleRepsonse(__('message.post_success'));
        }catch(Exception $e){
               return ResponseHelper::handleRepsonse($e->getMessage(),ResponseHelper::ERROR);
        }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_data = Post::find($id);
        if (is_null($post_data)) {
            return ResponseHelper::handleRepsonse('delete post failed because data not found', ResponseHelper::ERROR);
        }
        Post::destroy($id);
        return ResponseHelper::handleRepsonse('delete post success');
    }

 

}
