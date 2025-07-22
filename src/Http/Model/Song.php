<?php

namespace Teardrops\Teardrops\Http\Model;

use PDO;
use Teardrops\Teardrops\Config\QueryBuilder;

class Song extends \Teardrops\Teardrops\Http\Model
{
    private static string $table = 'songs';

    private int $id;
    private string $name;

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function __construct(array $data)
    {
        $this->setId($data['id']);
        $this->setName($data['name']);
    }

    public static function all(): array
    {
        $query = new QueryBuilder();
        $query->select('*')
            ->from(self::$table);
        $s = self::$database->prepare($query);
        $s->execute();
        $res = [];

        while ($row = $s->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $res[] = new self($row);
        }

        return $res;
    }
}
