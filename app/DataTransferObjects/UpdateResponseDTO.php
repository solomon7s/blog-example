<?php
declare(strict_types=1);


namespace App\DataTransferObjects;


use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class UpdateResponseDTO
 * @package App\DataTransferObjects
 * @OA\Schema()
 */
final class UpdateResponseDTO extends DataTransferObject
{
    /**
     * @var string
     * @OA\Property(type="string", property="message")
     */
    public string $message;

    /**
     * @var bool
     * @OA\Property(type="boolean", property="success")
     */
    public bool   $success;


    public static function create(string $message, $success): self
    {
        return new self(
            message: $message,
            success: $success
        );
    }
}
