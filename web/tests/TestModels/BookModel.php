<?php
declare(strict_types=1);

namespace BasicApp\Tests\TestModels;

class BookModel
{
  private string $bookTitle;
  private \DateTime $dateTime;

  public function getBookTitle(): string
  {
    return $this->bookTitle;
  }

  public function setBookTitle(string $bookTitle): self
  {
    $this->bookTitle = $bookTitle;

    return $this;
  }

  public function getDateTime(): \DateTime
  {
    return $this->dateTime;
  }

  public function setDateTime(\DateTime $dateTime): self
  {
    $this->dateTime = $dateTime;

    return $this;
  }
}
