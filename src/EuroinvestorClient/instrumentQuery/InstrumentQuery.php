<?php

namespace nez\EuroinvestorClient\instrumentQuery;

use Countable;
use ArrayAccess;
use BadMethodCallException;
use InvalidArgumentException;
use Illuminate\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use nez\EuroinvestorClient\enums\Endpoints;

/**
 * Class InstrumentQuery
 *
 * @property-read string $query
 *
 * @package nez\EuroinvestorClient\instrumentQuery
 */
class InstrumentQuery implements ArrayAccess, Countable, \Iterator
{
    /** @var string The query that returned the current InstrumentQuery instance */
    private string $query;

    /** @var InstrumentQueryLine[]|Collection All query lines returned by EuroInvestor */
    private Collection $queryLines;

    /** @var int $iteratorPosition used when using the class as an iterable */
    private int $iteratorPosition = 0;

    /**
     * InstrumentQuery constructor.
     *
     * @param string $query
     * @param InstrumentQueryLine[]|Collection $queryLines
     */
    private function __construct(string $query, Collection $queryLines)
    {
        $this->query = $query;
        $this->queryLines = $queryLines;
    }

    /**
     * Gets the QueryLines where a field is an exact match with the given value, or null
     *
     * @param string $field
     * @param mixed $value
     *
     * @return InstrumentQuery
     */
    public function whereEquals(string $field, $value): self
    {
        return $this->where(function (InstrumentQueryLine $queryLine) use ($field, $value) {
            return $queryLine->$field == $value;
        });
    }

    /**
     * General method for filtering the query lines
     *
     * @param callable $callable
     *
     * @return $this
     */
    public function where(callable $callable): self
    {
        return new static($this->query, $this->queryLines->filter($callable)->values());
    }

    /**
     * Returns the first line for the current query
     *
     * @return InstrumentQueryLine
     */
    public function first(): InstrumentQueryLine
    {
        if ($this->totalLines() === 0) {
            throw new BadMethodCallException('The query is empty');
        }

        return $this[0];
    }

    /**
     * Returns the last line for the current query
     *
     * @return InstrumentQueryLine
     */
    public function last(): InstrumentQueryLine
    {
        if ($this->totalLines() === 0) {
            throw new BadMethodCallException('The query is empty');
        }

        return $this[$this->totalLines() - 1];
    }

    /**
     * Returns the total number of query lines within the query
     *
     * @return int
     */
    public function totalLines(): int
    {
        return count($this->queryLines);
    }

    /**
     * Returns the InstrumentQueryLine at the given index
     *
     * @param int $index
     *
     * @return InstrumentQueryLine
     */
    public function getLine(int $index): InstrumentQueryLine
    {
        return $this->queryLines[$index];
    }

    /**
     * Fetch a query by the given string
     *
     * @param string $query
     *
     * @return static
     *
     * @throws GuzzleException
     * @throws \JsonException
     */
    public static function by(string $query): self
    {
        // If the query is empty, then we already know that the response is gonna be empty
        if (empty($query)) {
            return new static("", []);
        }

        // Otherwise send the request and return the query lines
        return new static($query, self::getQueryLines(urlencode($query)));
    }

    /**
     * Makes a request to the search endpoint, and returns the given data
     * as a list of InstrumentQueryLines
     *
     * @param string $query
     *
     * @return InstrumentQueryLine[]|Collection
     *
     * @throws GuzzleException
     * @throws \JsonException
     */
    private static function getQueryLines(string $query): Collection
    {
        $data = json_decode(Endpoints::searchInstruments($query)->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        return collect($data)->map(function (array $line) {
            return new InstrumentQueryLine($line);
        });
    }

    /**
     * Magic method used to allow for read-only properties
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        if ($name == "query") {
            return $this->query;
        }

        throw new InvalidArgumentException(sprintf("%s: Have no property named '%s'", __CLASS__, $name));
    }

    /**
     * Arrayable interface method for checking if offset exists
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return -1 < $offset && $offset < $this->totalLines();
    }

    /**
     * Arrayable interface method for getting the element at the given offset
     *
     * @param mixed $offset
     *
     * @return mixed|InstrumentQueryLine
     */
    public function offsetGet($offset)
    {
        return $this->getLine($offset);
    }

    /**
     * Arrayable interface method for setting the element at the given index
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException(sprintf('%s is read-only', __CLASS__));
    }

    /**
     * Arrayable interface method for unsetting the element at the given index
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        throw new BadMethodCallException(sprintf('%s is read-only', __CLASS__));
    }

    /**
     * Countable interface method
     *
     * @return int
     */
    public function count(): int
    {
        return $this->totalLines();
    }

    /**
     * Returns the element at the current position
     *
     * @return InstrumentQueryLine
     */
    public function current(): InstrumentQueryLine
    {
        return $this[$this->iteratorPosition];
    }

    /**
     * Steps the position to the next element
     */
    public function next(): void
    {
        ++$this->iteratorPosition;
    }

    /**
     * Returns the key for the current element
     *
     * @return int
     */
    public function key(): int
    {
        return $this->iteratorPosition;
    }

    /**
     * Checks if the current iterator position is valid
     *
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this[$this->iteratorPosition]);
    }

    /**
     * Rewinds the iterator bach to the initial state
     */
    public function rewind()
    {
        $this->iteratorPosition = 0;
    }
}
