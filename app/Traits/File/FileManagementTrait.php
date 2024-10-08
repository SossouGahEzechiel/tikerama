<?php

namespace App\Traits\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileManagementTrait
{
	private static string $disk = 'public';

	/**
	 * @param Request $request
	 * @param string $fileKey
	 * @param string $folderName
	 * @param string|null $fileName
	 * @return string
	 */
	private function storeFile(Request $request, string $fileKey, string $folderName, string $fileName = null): string
	{
		$file = $request->file($fileKey);
		$fileFullName = uniqid($fileName ?? '') . '.' . $file->getClientOriginalExtension();
		return Storage::disk(static::$disk)->putFileAs($folderName, $file, $fileFullName);
	}

	/**
	 * @param Request $request
	 * @param string $fileKey
	 * @param string $folderName
	 * @param string $fileOldName
	 * @param string|null $fileName
	 * @return string
	 */
	private function updateFile(Request $request, string $fileKey, string $folderName, string $fileOldName, string $fileName = null): string
	{
		$this->deleteFile($fileOldName);
		return $this->storeFile($request, $fileKey, $folderName, $fileName);
	}


	/**
	 * Supprime un fichier sur le disque 'public' sur le serveur
	 *
	 * @param string $fileName
	 * @return void
	 */
	private function deleteFile(string $fileName): void
	{
		if (Storage::disk(static::$disk)->exists($fileName)) {
			Storage::disk(static::$disk)->delete($fileName);
		}
	}


	/**
	 * Retourne l'Url d'accès à un fichier sur le disque 'public' depuis le serveur
	 *
	 * @param string $file_name
	 * @return string
	 */
	private function getFileUrl(string $file_name): string
	{
		$path =  str(Storage::disk(static::$disk)->url($file_name));
		if(app()->isLocal()) {
			$path = $path->replace('localhost', '192.168.1.72:8000');
		}
		return $path;
	}

	/**
	 * Déplace un fichier en le renommant puis retourne le chemin du nouvel emplacement
	 * @param string $oldLocation
	 * @param string $folderName
	 * @param string $fileNamePrefix
	 * @return string
	 */
	private function moveFile(string $oldLocation, string $folderName, string $fileNamePrefix = ''): string
	{
		$extension = '.' . Str::after($oldLocation, '.'); // .pdf
		$tempName = Str::before($oldLocation, '.') . '-temp'; // folder/file-name-temp
		$newLocation = $tempLocation = $tempName . $extension; // folder/file-name-temp.pdf

		if (Storage::disk(static::$disk)->copy($oldLocation, $tempLocation)) {
			if (Storage::disk(static::$disk)->move($tempLocation, $newLocation = $folderName . '/' . uniqid($fileNamePrefix) . $extension))
				return $newLocation;
		}
		return $newLocation;
	}
}
