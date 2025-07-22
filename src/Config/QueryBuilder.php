<?php

namespace Teardrops\Teardrops\Config;

class QueryBuilder
{
    private array $select;
    private array $from;
    private string $join;
    private array $where = [];
    private string $group;
    private array $order = [];
    private ?int $limit;
    private ?\PDO $pdo;
    private array $params;

    public function __construct(?\PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function select(string ...$fields): self
    {
        $this->select = $fields;
        return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
        if ($alias) {
            $this->from[$alias] = $table;
        } else {
            $this->from[] = $table;
        }

        return $this;
    }

    public function join(string $join): self
    {
        $this->join = $join;
        return $this;
    }

    public function where(?string ...$condition): self
    {
        $condition = array_filter($condition);
        $this->where = array_merge($this->where, $condition);
        return $this;
    }

    public function group(string $group): self
    {
        $this->group = $group;
        return $this;
    }

    public function order(string ...$order): self
    {
        $this->order = array_merge($this->order, $order);
        return $this;
    }

    public function limit(?int $limit = null): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function count(): int
    {
        $this->select("COUNT(*)");
        return $this->execute()->fetchColumn();
    }

    public function params(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function __toString(): string
    {
        $parts = ['SELECT'];
        $parts[] = $this->select ? join(',', $this->select) : "*";

        $parts[] = "FROM";
        $parts[] = $this->buildFrom();

        if (isset($this->join)) {
            $parts[] = "LEFT JOIN {$this->join}";
        }

        if (!empty($this->where)) {
            $parts[] = "WHERE";
            $parts[] = "(". join(') AND (', $this->where) . ")";
        }

        if (isset($this->group)) {
            $parts[] = "GROUP BY {$this->group}";
        }

        if (!empty($this->order)) {
            $parts[] = "ORDER BY";
            $parts[] = join(', ', $this->order);
        }

        if (isset($this->limit)) {
            $parts[] = "LIMIT {$this->limit}";
        }

        return join(' ', $parts);
    }

    private function buildFrom(): string
    {
        $from = [];
        foreach ($this->from as $key => $value) {
            $from[] = is_string($key) ? "$value as $key" : $value;
        }

        return join(', ', $from);
    }

    private function execute(): bool|\PDOStatement
    {
        $query = $this->__toString();

        if ($this->params) {
            $statement = $this->pdo->prepare($query);
            $statement->execute($this->params);
            return $statement;
        }

        return $this->pdo->query($query);
    }
}
