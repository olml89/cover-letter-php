<?php

declare(strict_types=1);

namespace olml89\CoverLetter\PDFCreator;

use olml89\CoverLetter\ErrorHandling\Exceptions\ValidationException;
use olml89\CoverLetter\Utils\DatetimeImmutable;
use olml89\CoverLetter\Utils\LoadableFromPath;

final readonly class Metadata
{
    use LoadableFromPath;

    /**
     * @throws ValidationException
     */
    public function __construct(
        public ?DateTimeImmutable $creationDate,
        public ?string $creator,
        public ?string $keywords,
        public ?DateTimeImmutable $modDate,
        public ?string $producer,
        public ?string $description,
    ) {
        if (!is_null($this->creationDate) && !is_null($this->modDate)) {
            return new ValidationException(sprintf(
        'modDate date \'%s\' cannot be earlier in time than creationDate \'%s\'',
                $this->modDate,
                $this->creationDate,
            ));
        }
    }

    public static function fromArray(array $data): static
    {
        return new self(
            creationDate: DatetimeImmutable::create($data['creationDate']),
            creator: $data['creator'],
            keywords: $data['keywords'],
            modDate: DatetimeImmutable::create($data['modDate']),
            producer: $data['producer'],
            description: $data['description'],
        );
    }
}