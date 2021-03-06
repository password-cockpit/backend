<?php


/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host=SWAGGER_API_HOST,
 *     basePath="/api",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Password Cockpit - RESTful API Server",
 *         description="This is a sample server.",
 *         termsOfService="http://swagger.io/terms/",
 *         @SWG\License(
 *             name="Apache 2.0",
 *             url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about Swagger",
 *         url="http://swagger.io"
 *     ),
 *
 * )
 */

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="bearerAuth",
 *   type="apiKey",
 *   name="Authorization",
 *   in="header"
 * )
 */

