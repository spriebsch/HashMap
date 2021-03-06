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
 * Unit tests for the HashMap class.
 *
 * @author Stefan Priebsch <stefan@priebsch.de>
 * @covers spriebsch\HashMap\HashMap
 */
class HashMapTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->hashMap = new HashMap();
    }

    protected function tearDown()
    {
        unset($this->hashMap);
    }

    /**
     * @expectedException spriebsch\HashMap\Exception
     */
    public function testGetThrowsExceptionWhenKeyDoesNotExist()
    {
        $this->hashMap->get('nonsense');
    }

    public function testHashMapIsInitiallyEmpty()
    {
        $this->assertEquals(0, count($this->hashMap));
    }

    public function testSetAndGetStoreAndRetrieveValues()
    {
        $this->hashMap->set(1, 'a');
        
        $this->assertEquals(1, count($this->hashMap));
        $this->assertEquals('a', $this->hashMap->get(1));
    }

    public function testSortsKeysOnIteration()
    {
        $this->hashMap->set(2, 'b');
        $this->hashMap->set(1, 'a');

        $data = array();
        foreach ($this->hashMap as $key => $value) {
            $data[$key] = $value;
        }
        
        $this->assertEquals(array(1 => 'a', 2 => 'b'), $data);
    }
}
