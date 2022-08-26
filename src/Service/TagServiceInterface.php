<?php

namespace App\Service;

use App\Entity\Tag;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface TagServiceInterface
{
    public function findOneByTitle(string $title): ?Tag;

    public function save(Tag $atg): void;

    public function delete(Tag $tag): void;

    public function getPaginatedList(int $page): PaginationInterface;

    public function canBeDeleted(Tag $tag): bool;

    public function findOneById(int $id): ?Tag;
}
