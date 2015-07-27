<?php

/**
 * This file is part of the GuzzleStereo package
*
* (c) Christophe Willemsen <willemsen.christophe@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*
*/

namespace Ikwattro\GuzzleStereo;

use Ikwattro\GuzzleStereo\Exception\RecorderException;

class Mixer
{
    protected $filters = [];

    public function getFilters()
    {
        return $this->filters;
    }

    public function hasFilter($name)
    {
        return array_key_exists($name, $this->filters);
    }

    public function addFilter($filter)
    {
        if ($this->hasFilter($filter::getName())) {
            throw new RecorderException(sprintf('A filter with the name "%s" is already registered', $filter::getName()));
        }
        $this->filters[$filter::getName()] = $filter;
    }

    public function getFilter($name)
    {
        if (!array_key_exists($name, $this->filters)) {
            throw new RecorderException(sprintf('The filter with name "%s" is not registered', $name));
        }
        return $this->filters[$name];
    }

    public function createFilter($name, $args)
    {
        $filter = $this->getFilter($name);
        $arguments = is_array($args) ? $args : array($args);

        return new $filter(...$arguments);
    }
}
