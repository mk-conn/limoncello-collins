<?php namespace App\Http\Controllers\Demo;

use \Validator;
use \App\Http\Requests;
use \App\Models\Post;
use \App\Http\Controllers\Controller;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PostsController extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->getResponse(Post::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $content    = $this->getDocument();
        $attributes = array_get($content, 'data.attributes', []);

        $attributes['author_id'] = array_get($content, 'data.links.author.linkage.id', null);
        $attributes['site_id']   = array_get($content, 'data.links.site.linkage.id', null);

        $rules = [
            'title'     => 'required',
            'body'      => 'required',
            'author_id' => 'required|integer',
            'site_id'   => 'required|integer'
        ];
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $comment = new Post($attributes);
        $comment->save();

        return $this->getCreatedResponse($comment);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return $this->getResponse(Post::findOrFail($id));
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $content = $this->getDocument();
        $attributes = array_get($content, 'data.attributes', []);

        $attributes['author_id'] = array_get($content, 'data.links.author.linkage.id', null);
        $attributes['site_id']   = array_get($content, 'data.links.site.linkage.id', null);
        $attributes = array_filter($attributes, function ($value) {return $value !== null;});

        $rules = [
            'title'     => 'sometimes|required',
            'body'      => 'sometimes|required',
            'author_id' => 'sometimes|required|integer',
            'site_id'   => 'sometimes|required|integer'
        ];
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $comment = Post::findOrFail($id);
        $comment->fill($attributes);
        $comment->save();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $comment = Post::findOrFail($id);
        $comment->delete();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
	}
}
