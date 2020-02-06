<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace Password\Api\V1\Action;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Folder\Api\V1\Facade\FolderFacade;
use Mezzio\Hal\ResourceGenerator;
use Mezzio\Hal\HalResponseFactory;
use Password\Api\V1\Collection\PasswordCollection;
use Password\Api\V1\Facade\PasswordFacade;
use File\Api\V1\Facade\FileFacade;

/**
 * Description of ListPasswordFilesAction
 */

/**
 * @SWG\Get(
 *     path="/v1/passwords/{passwordId}/files",
 *     summary="Get files of specified password",
 *     description="Returns files of the specified password by its id",
 *     operationId="getPasswordFiles",
 *     produces={"application/json"},
 *     tags={"passwords"},
 *     @SWG\Parameter(
 *         description="Password id where to get files",
 *         in="path",
 *         name="passwordId",
 *         required=true,
 *         type="integer",
 *         format="int64"
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="OK"
 *     ),
 *     @SWG\Response(
 *         response=404,
 *         description="Not Found"
 *     ),
 * security={{"bearerAuth": {}}}
 * )
 */
class ListPasswordFilesAction implements RequestHandlerInterface
{
    /**
     *
     * @var FolderFacade
     */
    protected $fileFacade;

    /**
     *
     * @var PasswordFacade
     */
    protected $passwordFacade;

    /**
     *
     * @var ResourceGenerator
     */
    protected $halResourceGenerator;

    /**
     *
     * @var HalResponseFactory
     */
    protected $halResponseFactory;

    /**
     * Constructor
     *
     * @param FileFacade $fileFacade
     * @param PasswordFacade $passwordFacade
     * @param ResourceGenerator $halResourceGenerator
     * @param HalResponseFactory $halResponseFactory
     */
    public function __construct(
        FileFacade $fileFacade,
        PasswordFacade $passwordFacade,
        ResourceGenerator $halResourceGenerator,
        HalResponseFactory $halResponseFactory
    ) {
        $this->fileFacade = $fileFacade;
        $this->passwordFacade = $passwordFacade;
        $this->halResourceGenerator = $halResourceGenerator;
        $this->halResponseFactory = $halResponseFactory;
    }

    /**
     * MiddlewareInterface handler
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $passwordId = $request->getAttribute('id');
        $files = $this->fileFacade->getFiles($passwordId);
        $filesArrayAdapter = new \Laminas\Paginator\Adapter\ArrayAdapter($files);
        $filesCollection = new PasswordCollection($filesArrayAdapter);
        $filesCollection->setDefaultItemCountPerPage(PHP_INT_MAX);
        $resource = $this->halResourceGenerator->fromObject(
            $filesCollection,
            $request
        );
        return $this->halResponseFactory->createResponse($request, $resource);
    }
}
