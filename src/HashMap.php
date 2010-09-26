<?php
/**
 * Copyright (c) 2010 Stefan Priebsch <stefan@priebsch.de>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Stefan Priebsch nor the names of contributors
 *     may be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    HashMap
 * @author     Stefan Priebsch <stefan@priebsch.de>
 * @copyright  Stefan Priebsch <stefan@priebsch.de>. All rights reserved.
 * @license    BSD License
 */

namespace spriebsch\HashMap;

/**
 * Wraps an associative array of key/value pairs.
 * Sorts by key to allow diffing of two hash maps.
 *
 * @author Stefan Priebsch <stefan@priebsch.de>
 */
class HashMap implements \Countable, \Iterator
{
    protected $data = array();

    /**
     * Returns the number of elements in the hash map.
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Add a key/value pair to the map.
     *
     * @param mixed $key
     * @param mixed $value
     * @return null
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
        $this->rewind();
    }

    /**
     * Returns a value from the map.
     *
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            throw new Exception('Key "' . $key . '" does not exist');
        }
    
        return $this->data[$key];
    }

    /**
     * Resets the internal pointer and sorts the data by keys.
     *
     * @return null
     */
    public function rewind()
    {
        ksort($this->data);
        reset($this->data);
    }

    /**
     * Returns the current value.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->data);
    }

    /**
     * Returns the current key.
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->data);
    }

    /**
     * Sets the internal pointer to the next element.
     *
     * @return null
     */
    public function next()
    {
        next($this->data);
    }

    /**
     * Checks whether element the internal pointer refers to is valid.
     *
     * @return bool
     */
    public function valid()
    {
        return $this->current() !== false;
    }
}
