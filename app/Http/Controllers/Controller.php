<?php namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Services\LaravelIntegration;
use Neomerx\Limoncello\Http\JsonApiTrait;
use Neomerx\JsonApi\Contracts\Document\DocumentLinksInterface;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests, JsonApiTrait;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->integration = new LaravelIntegration();
		$this->initJsonApiSupport();
	}

	/*
	 * If you use Eloquent the following helper method will assist you to
	 * encode database collections and keep your code clean.
	 */

	/**
	 * @param object|array                $data
	 * @param int                         $statusCode
	 * @param DocumentLinksInterface|null $links
	 * @param mixed                       $meta
	 *
	 * @return Response
	 */
	public function getResponse(
		$data,
		$statusCode = Response::HTTP_OK,
		DocumentLinksInterface $links = null,
		$meta = null
	) {
		$data = ($data instanceof Collection ? $data->all() : $data);
		return $this->getContentResponse($data, $statusCode, $links, $meta);
	}
}
