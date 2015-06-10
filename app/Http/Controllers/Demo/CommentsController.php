<?php namespace App\Http\Controllers\Demo;

use \Validator;
use \App\Http\Requests;
use \App\Models\Comment;
use \Symfony\Component\HttpFoundation\Response;
use \App\Http\Controllers\JsonApi\JsonApiController;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CommentsController extends JsonApiController
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->getResponse(Comment::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $content = $this->getDocument();

        $attributes            = array_get($content, 'data.attributes', []);
        $attributes['post_id'] = array_get($content, 'data.links.author.linkage.id', null);

        $rules     = ['body' => 'required', 'post_id' => 'required|integer'];
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $comment = new Comment($attributes);
        $comment->save();

        return $this->getCreatedResponse($comment);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
     *
	 * @return Response
	 */
	public function show($id)
	{
        return $this->getResponse(Comment::findOrFail($id));
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id
     *
	 * @return Response
	 */
	public function update($id)
	{
        $content = $this->getDocument();

        $attributes = array_get($content, 'data.attributes', []);
        $postId     = array_get($content, 'data.links.author.linkage.id', null);
        if ($postId !== null) {
            $attributes['post_id'] = $postId;
        }

        $rules     = ['post_id' => 'sometimes|required|integer'];
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $comment = Comment::findOrFail($id);
        $comment->fill($attributes);
        $comment->save();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
     *
	 * @return Response
	 */
	public function destroy($id)
	{
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
	}
}
