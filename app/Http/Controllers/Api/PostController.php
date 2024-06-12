<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use App\Models\Post;
use Exception;
use http\Env\Response;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        try {
            $query = Post::query();
            $perPage = 5;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if ($search){
                $query->whereRaw("titre LIKE '%" .$search. "%'");
            }

            $total = $query->count();
            $result = $query->offset(($page-1) * $perPage)->limit($perPage)->get();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'La liste des Posts',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ]);
        }catch (Exception $e){
            return response()->json($e);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        //dd($request);
        try {
            $post = new Post();
            $post->titre = $request->titre;
            $post->description = $request->description;
            $post->user_id = auth()->user()->id;
            $post->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Le Post a ete cree avec succes',
                'data' => $post
            ]);

        }catch (Exception $e){
            return Response()->json($e);
        }
   }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditPostRequest $request, Post $post)
    {

        //$post = Post::find($id);

        try {
            $post->titre = $request->titre;
            $post->description = $request->description;

            if ($post->user_id === auth()->user()->id){
                $post->save();
            }else{
                return response()->json([
                    'status_code' => 422,
                    'Status_message' => 'Vous n\'etes pas l\'auteur de ce post',
                    'data' => $post,
                ]);
            }


            return response()->json([
                'status_code' => 200,
                'Status_message' => 'Le Post a ete modifie avec succes',
                'data' => $post,
            ]);
        }catch (Exception $e){
            return response()->json($e);
        }




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            if ($post->user_id === auth()->user()->id){
                $post->delete();
            }else{
                return response()->json([
                    'status_code' => 422,
                    'Status_message' => 'Vous n\'etes pas l\'auteur de ce post. Suppression non autorisee',
                    'data' => $post,
                ]);
            }

            return response()->json([
                'status_code' => 200,
                'Status_message' => 'Le Post a ete supprime',
                'data' => $post,
            ]);

        }catch (Exception $e){
            return response()->json($e);
        }


    }
}
