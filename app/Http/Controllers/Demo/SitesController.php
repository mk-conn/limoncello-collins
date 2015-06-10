<?php namespace App\Http\Controllers\Demo;

use \Validator;
use \App\Models\Site;
use \App\Http\Requests;
use \Symfony\Component\HttpFoundation\Response;
use \App\Http\Controllers\JsonApi\JsonApiController;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SitesController extends JsonApiController
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return $this->getResponse(Site::all());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $attributes = array_get($this->getDocument(), 'data.attributes', []);

        $validator = Validator::make($attributes, ['name' => 'required|min:5']);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $site = new Site($attributes);
        $site->save();

        return $this->getCreatedResponse($site);
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
        return $this->getResponse(Site::findOrFail($id));
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

        $validator = Validator::make($attributes, ['name' => 'sometimes|required|min:5']);
        if ($validator->fails()) {
            throw new BadRequestHttpException();
        }

        $site = Site::findOrFail($id);
        $site->fill($attributes);
        $site->save();

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
        $site = Site::findOrFail($id);
        $site->delete();

        return $this->getCodeResponse(Response::HTTP_NO_CONTENT);
	}
}
