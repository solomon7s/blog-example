<?php
declare(strict_types=1);

namespace App\DataTransferObjects\Blog;


use App\Models\Blog\Comment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class CommentPaginationDTO
 * @package App\DataTransferObjects\Account
 * @OA\Schema()
 */
final class CommentPaginationDTO extends DataTransferObject
{
    /**
     * @var int
     * @OA\Property(type="int", property="total")
     */
    public int $total;

    /**
     * @var int
     * @OA\Property(type="int", property="current_page")
     */
    public int $current_page;

    /**
     * @var int
     * @OA\Property(type="int", property="last_page")
     */
    public int $last_page;

    /**
     * @var int
     * @OA\Property(type="int", property="per_page")
     */
    public int $per_page;

    /**
     * @var Collection
     * @OA\Property(type="array", property="data", @OA\Items(type="object", ref="#/components/schemas/CommentDTO"))
     */
    public Collection $data;


    /**
     * @param LengthAwarePaginator $paginatedData
     * @return static
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function createFromPagination(LengthAwarePaginator $paginatedData): self
    {
        $data = $paginatedData->map(
            fn(Comment $post) => CommentDTO::createFromModel($post)
        );
        return new self( [
            'current_page'  => $paginatedData->currentPage(),
            'total'         => $paginatedData->total(),
            'per_page'      => $paginatedData->perPage(),
            'last_page'     => $paginatedData->lastPage(),
            'data'          => $data
        ] );
    }
}
