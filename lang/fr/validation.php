<?php

return [

	"accepted" => ":attribute doit être accepté.",
	"accepted_if" => ":attribute doit être accepté lorsque :other est :value.",
	"active_url" => ":attribute doit être une URL valide.",
	"after" => ":attribute doit être une date postérieure à :date.",
	"after_or_equal" => ":attribute doit être une date postérieure ou égale à :date.",
	"alpha" => ":attribute ne doit contenir que des lettres.",
	"alpha_dash" => ":attribute ne doit contenir que des lettres, des chiffres, des tirets et des underscores.",
	"alpha_num" => ":attribute ne doit contenir que des lettres et des chiffres.",
	"array" => ":attribute doit être un tableau.",
	"ascii" => ":attribute ne doit contenir que des caractères et des symboles alphanumériques à un seul octet.",
	"before" => ":attribute doit être une date antérieure à :date.",
	"before_or_equal" => ":attribute doit être une date antérieure ou égale à :date.",
	"between" => [
		"array" => ":attribute doit contenir entre :min et :max éléments.",
		"file" => ":attribute doit être entre :min et :max kilo-octets.",
		"numeric" => ":attribute doit être entre :min et :max.",
		"string" => ":attribute doit être entre :min et :max caractères.",
	],
	"boolean" => ":attribute doit être vrai ou faux.",
	"can" => ":attribute contient une valeur non autorisée.",
	"confirmed" => "La confirmation de :attribute ne correspond pas.",
	"current_password" => "Le mot de passe est incorrect.",
	"date" => ":attribute doit être une date valide.",
	"date_equals" => ":attribute doit être une date égale à :date.",
	"date_format" => ":attribute doit correspondre au format :format.",
	"decimal" => ":attribute doit avoir :decimal décimales.",
	"declined" => ":attribute doit être refusé.",
	"declined_if" => ":attribute doit être refusé lorsque :other est :value.",
	"different" => ":attribute et :other doivent être différents.",
	"digits" => ":attribute doit être de :digits chiffres.",
	"digits_between" => ":attribute doit être entre :min et :max chiffres.",
	"dimensions" => ":attribute a des dimensions d'image invalides.",
	"distinct" => ":attribute a une valeur en double.",
	"doesnt_end_with" => ":attribute ne doit pas se terminer par l'un des éléments suivants : :values.",
	"doesnt_start_with" => ":attribute ne doit pas commencer par l'un des éléments suivants : :values.",
	"email" => ":attribute doit être une adresse e-mail valide.",
	"ends_with" => ":attribute doit se terminer par l'un des éléments suivants : :values.",
	"enum" => ":attribute sélectionné est invalide.",
	"exists" => ":attribute sélectionné est invalide.",
	"extensions" => ":attribute doit avoir l'une des extensions suivantes : :values.",
	"file" => ":attribute doit être un fichier.",
	"filled" => ":attribute doit avoir une valeur.",
	"gt" => [
		"array" => ":attribute doit avoir plus de :value éléments.",
		"file" => ":attribute doit être supérieur à :value kilo-octets.",
		"numeric" => ":attribute doit être supérieur à :value.",
		"string" => ":attribute doit être supérieur à :value caractères.",
	],
	"gte" => [
		"array" => ":attribute doit avoir :value éléments ou plus.",
		"file" => ":attribute doit être supérieur ou égal à :value kilo-octets.",
		"numeric" => ":attribute doit être supérieur ou égal à :value.",
		"string" => ":attribute doit être supérieur ou égal à :value caractères.",
	],
	"hex_color" => ":attribute doit être une couleur hexadécimale valide.",
	"image" => ":attribute doit être une image.",
	"in" => ":attribute sélectionné est invalide.",
	"in_array" => ":attribute doit exister dans :other.",
	"integer" => ":attribute doit être un entier.",
	"ip" => ":attribute doit être une adresse IP valide.",
	"ipv4" => ":attribute doit être une adresse IPv4 valide.",
	"ipv6" => ":attribute doit être une adresse IPv6 valide.",
	"json" => ":attribute doit être une chaîne JSON valide.",
	"lowercase" => ":attribute doit être en minuscules.",
	"lt" => [
		"array" => ":attribute doit avoir moins de :value éléments.",
		"file" => ":attribute doit être inférieur à :value kilo-octets.",
		"numeric" => ":attribute doit être inférieur à :value.",
		"string" => ":attribute doit être inférieur à :value caractères.",
	],
	"lte" => [
		"array" => ":attribute ne doit pas avoir plus de :value éléments.",
		"file" => ":attribute doit être inférieur ou égal à :value kilo-octets.",
		"numeric" => ":attribute doit être inférieur ou égal à :value.",
		"string" => ":attribute doit être inférieur ou égal à :value caractères.",
	],
	"mac_address" => ":attribute doit être une adresse MAC valide.",
	"max" => [
		"array" => ":attribute ne doit pas avoir plus de :max éléments.",
		"file" => ":attribute ne doit pas être supérieur à :max kilo-octets.",
		"numeric" => ":attribute ne doit pas être supérieur à :max.",
		"string" => ":attribute ne doit pas être supérieur à :max caractères.",
	],
	"max_digits" => ":attribute ne doit pas avoir plus de :max chiffres.",
	"mimes" => ":attribute doit être un fichier de type : :values.",
	"mimetypes" => ":attribute doit être un fichier de type : :values.",
	"min" => [
		"array" => ":attribute doit avoir au moins :min éléments.",
		"file" => ":attribute doit être au moins de :min kilo-octets.",
		"numeric" => ":attribute doit être au moins de :min.",
		"string" => ":attribute doit être au moins de :min caractères.",
	],
	"min_digits" => ":attribute doit avoir au moins :min chiffres.",
	"missing" => ":attribute doit être manquant.",
	"missing_if" => ":attribute doit être manquant lorsque :other est :value.",
	"missing_unless" => ":attribute doit être manquant sauf si :other est :value.",
	"missing_with" => ":attribute doit être manquant lorsque :values est présent.",
	"missing_with_all" => ":attribute doit être manquant lorsque :values sont présents.",
	"multiple_of" => ":attribute doit être un multiple de :value.",
	"not_in" => ":attribute sélectionné est invalide.",
	"not_regex" => "Le format de :attribute est invalide.",
	"numeric" => ":attribute doit être un nombre.",
	"password" => [
		"letters" => ":attribute doit contenir au moins une lettre.",
		"mixed" => ":attribute doit contenir au moins une lettre majuscule et une lettre minuscule.",
		"numbers" => ":attribute doit contenir au moins un chiffre.",
		"symbols" => ":attribute doit contenir au moins un symbole.",
		"uncompromised" => ":attribute a été compromis dans une fuite de données. Veuillez choisir un autre :attribute.",
	],
	"present" => ":attribute doit être présent.",
	"present_if" => ":attribute doit être présent lorsque :other est :value.",
	"present_unless" => ":attribute doit être présent sauf si :other est :value.",
	"present_with" => ":attribute doit être présent lorsque :values est présent.",
	"present_with_all" => ":attribute doit être présent lorsque :values sont présents.",
	"prohibited" => ":attribute est interdit.",
	"prohibited_if" => ":attribute est interdit lorsque :other est :value.",
	"prohibited_unless" => ":attribute est interdit sauf si :other est dans :values.",
	"prohibits" => ":attribute interdit à :other d'être présent.",
	"regex" => "Le format de :attribute est invalide.",
	"required" => ":attribute est obligatoire.",
	"required_array_keys" => ":attribute doit contenir des entrées pour : :values.",
	"required_if" => ":attribute est obligatoire lorsque :other est :value.",
	"required_if_accepted" => ":attribute est obligatoire lorsque :other est accepté.",
	"required_unless" => ":attribute est obligatoire sauf si :other est dans :values.",
	"required_with" => ":attribute est obligatoire lorsque :values est présent.",
	"required_with_all" => ":attribute est obligatoire lorsque :values sont présents.",
	"required_without" => ":attribute est obligatoire lorsque :values n\"est pas présent.",
	"required_without_all" => ":attribute est obligatoire lorsque aucun de :values n\"est présent.",
	"same" => ":attribute doit correspondre à :other.",
	"size" => [
		"array" => ":attribute doit contenir :size éléments.",
		"file" => ":attribute doit être de :size kilo-octets.",
		"numeric" => ":attribute doit être de :size.",
		"string" => ":attribute doit être de :size caractères.",
	],
	"starts_with" => ":attribute doit commencer par l\"un des éléments suivants : :values.",
	"string" => ":attribute doit être une chaîne.",
	"timezone" => ":attribute doit être un fuseau horaire valide.",
	"unique" => ":attribute a déjà été pris.",
	"uploaded" => "Le téléchargement de :attribute a échoué.",
	"uppercase" => ":attribute doit être en majuscules.",
	"url" => ":attribute doit être une URL valide.",
	"ulid" => ":attribute doit être un ULID valide.",
	"uuid" => ":attribute doit être un UUID valide.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Ici, vous pouvez spécifier des messages de validation personnalisés pour
	| les attributs en utilisant la convention "attribute.rule" pour nommer
	| les lignes. Cela permet de spécifier rapidement une ligne de langage
	| personnalisée spécifique pour une règle d'attribut donnée.
	|
	*/

	"custom" => [
		"attribute-name" => [
			"rule-name" => "message personnalisé",
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| Les lignes de langue suivantes sont utilisées pour échanger notre
	| espace réservé d'attribut par quelque chose de plus convivial pour le
	| lecteur tel que "Adresse E-Mail" au lieu de "email". Cela nous aide
	| simplement à rendre notre message plus clair.
	|
	*/

	"attributes" => [],

];
