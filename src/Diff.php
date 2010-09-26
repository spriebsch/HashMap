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
 * Calculates the differences between two hash maps.
 *
 * @author Stefan Priebsch <stefan@priebsch.de>
 */
class Diff
{
    /**
     * @var HashMap
     */
    protected $left;

    /**
     * @var HashMap
     */
    protected $right;
    
    /**
     * @var array
     */
    protected $new = array();

    /**
     * @var array
     */
    protected $deleted = array();

    /**
     * @var array
     */
    protected $modified = array();

    /**
     * Compares two hash maps and populates new, modified, and deleted.
     *
     * @param HashMap $left
     * @param HashMap $right
     * @return null
     */
    public function compare(HashMap $left, HashMap $right)
    {
        $this->left = $left;
        $this->right = $right;

        $this->left->rewind();
        $this->right->rewind();

        while ($this->left->valid() || $this->right->valid()) {

            if (($this->left->valid() && !$this->right->valid()) ||
                (($this->left->valid() && $this->right->valid()) && ($this->left->key() < $this->right->key()))) {
                $this->deleted[] = $this->left->key();
                $this->left->next();
            }

            if ((!$this->left->valid() && $this->right->valid()) ||
                (($this->left->valid() && $this->right->valid()) && ($this->left->key() > $this->right->key()))) {
                $this->new[] = $this->right->key();
                $this->right->next();
            }

            if ($this->left->key() == $this->right->key()) {
                if ($this->left->current() != $this->right->current()) {
                    $this->modified[] = $this->right->key();
                }

                $this->left->next();
                $this->right->next();
            }
        }
    }

    /**
     * Returns array of new IDs.
     *
     * @return array
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * Returns array of modified IDs.
     *
     * @return array
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Returns array of deleted IDs.
     *
     * @return array
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
