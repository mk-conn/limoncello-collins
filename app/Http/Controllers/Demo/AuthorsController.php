<?php namespace App\Http\Controllers\Demo;

use \Validator;
use \App\Models\Author;
use \App\Http\Requests;
use \Symfony\Component\HttpFoundation\Response;
use \App\Http\Controllers\JsonApi\JsonApiController;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthorsController extends JsonApiController
{
    /**
     * JSON API extensions supported by this controller.
     *
     * NOTE: Here it's declared for illustration/testing purposes only.
     * This controller does not support these JSON API extensions.
     *
     * If you do not use API extensions do not forget to remove this line in real application.
     *
     * @var string
     */
    protected $extensions = 'ext1,ex3';

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->getResponse(Author::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $attributes = array_get($this->getDocument(), 'data.attributes', []);

        $rules     = ['first_name' => 'required|alpha_dash', 'last_name' => 'required|alpha_dash'];
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $author = new Author($attributes);
        $author->save();

        return $this->getCreatedResponse($author);
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
        return $this->getResponse(Author::findOrFail($id));
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
        $attributes = array_get($this->getDocument(), 'data.attributes', []);

        $rules     = ['first_name' => 'sometimes|required|alpha_dash', 'last_name' => 'sometimes|required|alpha_dash'];
        $validator = Validator::make($attributes, $rules);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $author = Author::findOrFail($id);
        $author->fill($attributes);
        $author->save();

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
        $author = Author::findOrFail($id);
        $author->delete();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
	}
}
