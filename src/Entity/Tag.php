<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private $tag_info;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTagInfo(): ?string
    {
        return $this->tag_info;
    }

    public function setTagInfo(string $tag_info): self
    {
        $this->tag_info = $tag_info;

        return $this;
    }
}
