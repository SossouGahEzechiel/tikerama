<?php

namespace App\Documentation;


use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="EventResource",
 *     type="object",
 *     title="Event Resource",
 *     description="Représentation d'un événement.",
 *     required={"title", "code", "date", "hour", "city", "slug", "image", "category", "lowerPrice", "types"},
 *     @OA\Property(property="title", type="string", example="Concert du 20 août"),
 *     @OA\Property(property="code", type="string", example="767VF"),
 *     @OA\Property(property="date", type="string", format="date", example="ven. 16 août 2024"),
 *     @OA\Property(property="hour", type="string", format="time", example="15:40"),
 *     @OA\Property(property="city", type="string", example="Lomé"),
 *     @OA\Property(property="slug", type="string", example="concert-du-20-aout"),
 *     @OA\Property(property="image", type="string", example="https://example.com/image.jpg"),
 *     @OA\Property(property="description", type="string", example="Un concert exceptionnel au Stade de Lomé."),
 *     @OA\Property(property="category", type="string", example="Musique"),
 *     @OA\Property(
 *         property="types",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TicketTypeResource")
 *     ),
 *     @OA\Property(property="lowerPrice", type="integer|string", example=1000),
 * )
 *
 * @OA\Schema(
 *     schema="IntentResource",
 *     type="object",
 *     title="Intent Resource",
 *     description="Représentation d'une intention de commande.",
 *     required={"slug", "price", "userEmail", "userPhone", "expires_at", "content", "event", "paymentMethod"},
 *     @OA\Property(property="slug", type="string", example="intent-slug-123"),
 *     @OA\Property(property="price", type="number", format="float", example=150.00),
 *     @OA\Property(property="userEmail", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="userPhone", type="string", example="22890000000"),
 *     @OA\Property(property="expires_at", type="string", format="date-time", example="20 août 2024 16:30:00"),
 *     @OA\Property(
 *         property="content",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TicketTypeResource")
 *     ),
 *     @OA\Property(property="event", ref="#/components/schemas/EventResource"),
 *     @OA\Property(property="paymentMethod", type="string", example="Credit Card"),
 *     @OA\Property(property="unComputed", type="string", nullable=true, example="Certains tickets ne sont plus disponibles")
 * )
 */
class OpenApiSchemas
{
}