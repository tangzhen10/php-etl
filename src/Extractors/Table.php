<?php

namespace Marquine\Etl\Extractors;

use Marquine\Etl\Database\Manager as DB;

class Table implements ExtractorInterface
{
    /**
     * The connection name.
     *
     * @var string
     */
    public $connection = 'default';

    /**
     * Extractor columns.
     *
     * @var array
     */
    public $columns;

    /**
     * The array of where clause.
     *
     * @var array
     */
    public $where = [];

    /**
     * Extract data from the given source.
     *
     * @param  string  $table
     * @return \Generator
     */
    public function extract($table)
    {
        if (is_string($this->columns)) {
            $this->columns = [$this->columns];
        }

        if (empty($this->columns)) {
            $this->columns = ['*'];
        }

        $statement = DB::connection($this->connection)
                        ->query()
                        ->select($table, $this->columns)
                        ->where($this->where)
                        ->execute();

        while ($row = $statement->fetch()) {
            yield $row;
        }
    }
}
