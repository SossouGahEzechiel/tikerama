<?php

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

if (!function_exists('__200')) {

	/**
	 * Return a standard 200 response with optional data
	 *
	 * @param string $message
	 * @param array|null $data
	 * @return Response|ResponseFactory
	 * @package Tikerama-Test
	 * @author SOSSOU-GAH Ézéchiel
	 * @created 2024-07-10
	 */
	function __200(string $message = 'No special message for this response ', array $data = null): Response|ResponseFactory
	{
		$content = ['message' => $message];

		if ($data) {
			$content[] = $data;
		}

		return response($content, ResponseAlias::HTTP_OK);
	}
}

if (!function_exists('__404')) {

	/**
	 * Return a standard 404 error message response
	 *
	 * @param string $message
	 * @return Response|ResponseFactory
	 * @package Tikerama-Test
	 * @author SOSSOU-GAH Ézéchiel
	 * @created 2024-07-10
	 */
	function __404(string $message = 'Oups, aucune resource n\'a été trouvée'): Response|ResponseFactory
	{
		return response(['message' => $message], ResponseAlias::HTTP_NOT_FOUND);
	}
}

if (!function_exists('__422')) {

	/**
	 * Return a standard 422 error message response after a failed validation
	 *
	 * @param string|array $messages
	 * @return Response|ResponseFactory
	 * @package Tikerama-Test
	 * @author SOSSOU-GAH Ézéchiel
	 * @created 2024-07-10
	 */
	function __422(string|array $messages): Response|ResponseFactory
	{
		return response(
			['message' => is_array($messages) ? $messages[0] : $messages],
			ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
		);
	}
}

if (!function_exists('__500')) {

	/**
	 * Return a standard 500 error message response
	 *
	 * @param array|string|null $message
	 * @return Response|ResponseFactory
	 * @package Tikerama-Test
	 * @author SOSSOU-GAH Ézéchiel
	 * @created 2024-07-10
	 */
	function __500(array|string $message = null): Response|ResponseFactory
	{
		if (!$message) {
			$content['message'] = 'Oups, une erreur inattendue est survenue';
		} else {
			$content['message'] = is_array($message) ? Arr::first($message) : $message;
		}
		return response($content, ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
	}
}
