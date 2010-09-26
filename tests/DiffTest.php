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
 * Unit tests for the Diff class.
 *
 * @author Stefan Priebsch <stefan@priebsch.de>
 * @covers spriebsch\HashMap\Diff
 */
class DiffTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->left  = new HashMap();
        $this->right = new HashMap();
        $this->diff  = new Diff();
    }

    protected function tearDown()
    {
        unset($this->left);
        unset($this->right);
        unset($this->diff);
    }

    public function testDoesNotReportAnythingOnEqualData()
    {
        $this->left->set(1, 'a');
        $this->left->set(2, 'b');
        $this->left->set(3, 'c');

        $this->right->set(1, 'a');
        $this->right->set(2, 'b');
        $this->right->set(3, 'c');

        $this->diff->compare($this->left, $this->right);

        $this->assertEquals(array(), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsNewWhenLeftIsEmpty()
    {
        $this->right->set(1, 'a');
        $this->right->set(2, 'b');
        $this->right->set(3, 'c');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(1, 2, 3), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsDeletedWhenRightIsEmpty()
    {
        $this->left->set(1, 'a');
        $this->left->set(2, 'b');
        $this->left->set(3, 'c');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(1, 2, 3), $this->diff->getDeleted());
    }

    public function testDetectsDeleted()
    {
        $this->left->set(1, 'a');
        $this->left->set(2, 'b');
        $this->left->set(3, 'c');
        $this->left->set(4, 'd');

        $this->right->set(1, 'a');
        $this->right->set(4, 'd');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(2, 3), $this->diff->getDeleted());
    }

    public function testDetectsDeletedAtEnd()
    {
        $this->left->set(1, 'a');
        $this->left->set(2, 'b');
        $this->left->set(3, 'c');
        $this->left->set(4, 'd');

        $this->right->set(1, 'a');
        $this->right->set(2, 'b');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(3, 4), $this->diff->getDeleted());
    }

    public function testDetectsNewAtBeginning()
    {
        $this->right->set(1, 'a');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(1), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsNew()
    {
        $this->left->set(1, 'a');
        $this->left->set(3, 'c');

        $this->right->set(1, 'a');
        $this->right->set(2, 'b');
        $this->right->set(3, 'c');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(2), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsNewAtEnd()
    {
        $this->left->set(1, 'a');

        $this->right->set(1, 'a');
        $this->right->set(2, 'b');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(2), $this->diff->getNew());
        $this->assertEquals(array(), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsModifiedAtBeginning()
    {
        $this->left->set(1, 'a');
        $this->right->set(1, 'x');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(), $this->diff->getNew());
        $this->assertEquals(array(1), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsModified()
    {
        $this->left->set(1, 'a');
        $this->left->set(2, 'b');
        $this->left->set(3, 'c');

        $this->right->set(1, 'a');
        $this->right->set(2, 'x');
        $this->right->set(3, 'c');

        $this->diff->compare($this->left, $this->right);
        
        $this->assertEquals(array(), $this->diff->getNew());
        $this->assertEquals(array(2), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsModifiedAtEnd()
    {
        $this->left->set(1, 'a');
        $this->left->set(2, 'b');

        $this->right->set(1, 'a');
        $this->right->set(2, 'x');

        $this->diff->compare($this->left, $this->right);

        $this->assertEquals(array(), $this->diff->getNew());
        $this->assertEquals(array(2), $this->diff->getModified());
        $this->assertEquals(array(), $this->diff->getDeleted());
    }

    public function testDetectsNewModifiedAndDeleted()
    {
        $this->left->set(1, 'a');
        $this->left->set(2, 'b');
        $this->left->set(3, 'c');
        $this->left->set(4, 'd');
        $this->left->set(5, 'e');
        $this->left->set(6, 'f');
        $this->left->set(7, 'g');

        $this->right->set(2, 'b');
        $this->right->set(3, 'x');
        $this->right->set(4, 'd');
        $this->right->set(6, 'y');
        $this->right->set(8, 's');
        $this->right->set(9, 't');

        $this->diff->compare($this->left, $this->right);

        $this->assertEquals(array(8, 9), $this->diff->getNew());
        $this->assertEquals(array(3, 6), $this->diff->getModified());
        $this->assertEquals(array(1, 5, 7), $this->diff->getDeleted());
    }
}
