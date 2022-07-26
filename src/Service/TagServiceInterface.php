<?php


namespace App\Service;

use App\Entity\Tag;
use Knp\Component\Pager\Pagination\PaginationInterface;

interface TagServiceInterface{

    public function findOneByTitle(string $title): ?Tag;


}