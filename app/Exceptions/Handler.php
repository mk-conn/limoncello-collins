<?php namespace App\Exceptions;

use \Exception;
use \Psr\Log\LoggerInterface;
use \Illuminate\Http\Request;
use \Illuminate\Http\Response;
use \Neomerx\JsonApi\Document\Error;
use \App\Services\LaravelIntegration;
use \Neomerx\JsonApi\Encoder\Encoder;
use \Neomerx\JsonApi\Responses\Responses;
use \Neomerx\JsonApi\Parameters\MediaType;
use \Neomerx\Limoncello\Errors\RenderContainer;
use \Neomerx\Limoncello\Contracts\IntegrationInterface;
use \Neomerx\JsonApi\Contracts\Codec\CodecContainerInterface;
use \Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Neomerx\JsonApi\Contracts\Exceptions\RenderContainerInterface;
use \Neomerx\JsonApi\Contracts\Parameters\SupportedExtensionsInterface;

use \Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\Eloquent\MassAssignmentException;

use \Symfony\Component\HttpKernel\Exception\GoneHttpException;
use \Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use \Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use \Symfony\Component\HttpKernel\Exception\LengthRequiredHttpException;
use \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use \Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use \Symfony\Component\HttpKernel\Exception\PreconditionRequiredHttpException;
use \Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class Handler extends ExceptionHandler
{
    /**
     * @var RenderContainerInterface
     */
    private $renderContainer;

    /**
     * @var IntegrationInterface
     */
    private $integration;

    /**
     * @param LoggerInterface $log
     */
    public function __construct(LoggerInterface $log)
    {
        parent::__construct($log);

        $this->integration = new LaravelIntegration();

        // Init render container with default 'HTTP code only' render
        $this->renderContainer = new RenderContainer(function ($statusCode) {
            $responses = new Responses($this->integration);

            $content   = null;
            $mediaType = new MediaType(CodecContainerInterface::JSON_API_TYPE);
            $supportedExtensions = app()->resolved(SupportedExtensionsInterface::class) === false ? null :
                app()->make(SupportedExtensionsInterface::class);

            return $responses->getResponse($statusCode, $mediaType, $content, $supportedExtensions);
        });

        $this->registerCustomExceptions();
    }

    /**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
        GoneHttpException::class,
        ConflictHttpException::class,
        NotFoundHttpException::class,
        BadRequestHttpException::class,
        AccessDeniedHttpException::class,
        UnauthorizedHttpException::class,
        NotAcceptableHttpException::class,
        LengthRequiredHttpException::class,
        TooManyRequestsHttpException::class,
        MethodNotAllowedHttpException::class,
        PreconditionFailedHttpException::class,
        PreconditionRequiredHttpException::class,
        UnsupportedMediaTypeHttpException::class,
	];

	/**
	 * Render an exception into an HTTP response.
	 *
     * @param Request   $request
     * @param Exception $exception
     *
	 * @return Response
	 */
	public function render($request, Exception $exception)
	{
        $render = $this->renderContainer->getRender($exception);
		return $render($request, $exception);
	}

    /**
     * Here you can add 'exception -> HTTP code' mapping or custom exception renders.
     */
    private function registerCustomExceptions()
    {
        $this->renderContainer->registerMapping([

            MassAssignmentException::class => Response::HTTP_FORBIDDEN,

        ]);

        //
        // That's an example of how to create JSON API Error response from exception.
        //
        $custom404render = function (/*Request $request, ModelNotFoundException $exception*/) {
            $responses = new Responses($this->integration);

            $supportedExtensions = app()->resolved(SupportedExtensionsInterface::class) === false ? null :
                app()->make(SupportedExtensionsInterface::class);

            $title   = 'Requested item not found';
            $error   = new Error(null, null, null, null, $title);
            $content = Encoder::instance([])->error($error);

            return $responses->getResponse(
                Response::HTTP_NOT_FOUND,
                new MediaType(CodecContainerInterface::JSON_API_TYPE),
                $content,
                $supportedExtensions
            );
        };
        $this->renderContainer->registerRender(ModelNotFoundException::class, $custom404render);
    }
}
