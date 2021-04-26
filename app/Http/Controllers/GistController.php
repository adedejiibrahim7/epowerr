<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGistRequest;
use App\Http\Requests\UpdateGistRequest;
use App\Models\Gist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GistController extends Controller
{

    public function index()
    {
        $gists = Gist::get(['topic', 'body', 'user_id']);
        return response()->json($gists, 200);
    }
    public function create(CreateGistRequest $request)
    {
        $validated = $request->validated();

//        return response()->json([
//            'validated' => $validated
//        ]);

        $create = Gist::create([
            'topic' => $validated['topic'],
            'body' => $validated['body'],
            'user_id' => Auth::id(),
        ]);

        if($create){
            return response()->json([
                'success' => true,
                'message' => 'The new Gist - '.$validated['topic'].' has been created'
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'An error occurred'
            ], 500);
        }
    }

    public function show(Gist $gist)
    {

        return response()->json([
           'Topic' => $gist->topic,
           'Body' => $gist->body,
        ], 200);
    }

    public function update(UpdateGistRequest $request, Gist $gist)
    {

        $validated = $request->validated();

        if($gist->user_id == Auth::id()){
            $update = $gist->update([
                'topic' => $validated['topic'] ? $validated['topic'] : $gist->topic,
                'body' => request('body') ? $validated['body'] : $gist->body
            ]);

            if($update){
                return response()->json([
                    'success' => true,
                    'message' => 'Gist Updated'
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred'
                ],500);
            }
        }else{
            return abort('403');
        }
    }

    public function delete(Gist $gist){
        if($gist->user_id === Auth::id()){
            if($gist->delete()){
                return response()->json([
                    'success' => true,
                    'message' => 'Gist Deleted'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'An error has occurred'
                ], 500);
            }
        }else{
            return abort('403');
        }
    }
}
