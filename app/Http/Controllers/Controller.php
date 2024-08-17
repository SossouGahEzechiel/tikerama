<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="API Tikerama",
 *         description="Documentation de l'API pour le projet Tikerama.",
 *         @OA\Contact(
 *             email="ezecsossougah@gmail.com"
 *         ),
 *         @OA\License(
 *             name="Apache 2.0",
 *             url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *         )
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="Serveur de développement"
 *     ),
 *   @OA\Components(
 *    @OA\SecurityScheme(
 *         securityScheme="ApiKeyAuth",
 *         type="apiKey",
 *         in="header",
 *         name="Api-Key",
 *         description="Clé d'API pour accéder aux endpoints"
 *     ),
 *     @OA\SecurityScheme(
 *         securityScheme="ApiKeyNameAuth",
 *         type="apiKey",
 *         in="header",
 *         name="Api-Key-Name",
 *         description="Nom de la clé d'API"
 *     ),
 *   )
 * )
 */
abstract class Controller
{
	//
}
