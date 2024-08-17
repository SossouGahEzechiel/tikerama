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
 *             email="support@tikerama.com"
 *         ),
 *         @OA\License(
 *             name="Apache 2.0",
 *             url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *         )
 *     ),
 *     @OA\Server(
 *         url=L5_SWAGGER_CONST_HOST,
 *         description="Serveur de développement"
 *     )
 * )
 */
abstract class Controller
{
	//
}
