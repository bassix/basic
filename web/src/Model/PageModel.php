<?php
declare(strict_types=1);

namespace BasicApp\Model;

class PageModel
{
  private int $id;
  private string $titel;
  private string $description;
  private string $content;
  private string $author;
  private \DateTime $created;
  private \DateTime $update;

  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): PageModel
  {
    $this->id = $id;

    return $this;
  }

  public function getTitel(): string
  {
    return $this->titel;
  }

  public function setTitel(string $titel): PageModel
  {
    $this->titel = $titel;

    return $this;
  }

  public function getDescription(): string
  {
    return $this->description;
  }

  public function setDescription(string $description): PageModel
  {
    $this->description = $description;

    return $this;
  }

  public function getContent(): string
  {
    return $this->content;
  }

  public function setContent(string $content): PageModel
  {
    $this->content = $content;

    return $this;
  }

  public function getAuthor(): string
  {
    return $this->author;
  }

  public function setAuthor(string $author): PageModel
  {
    $this->author = $author;

    return $this;
  }

  public function getCreated(): \DateTime
  {
    return $this->created;
  }

  public function setCreated(\DateTime $created): PageModel
  {
    $this->created = $created;

    return $this;
  }

  public function getUpdate(): \DateTime
  {
    return $this->update;
  }

  public function setUpdate(\DateTime $update): PageModel
  {
    $this->update = $update;

    return $this;
  }
}
