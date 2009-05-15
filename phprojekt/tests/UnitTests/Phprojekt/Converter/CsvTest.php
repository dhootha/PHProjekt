<?php
/**
 * Unit test
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License version 2.1 as published by the Free Software Foundation
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * @copyright  Copyright (c) 2008 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL 2.1 (See LICENSE file)
 * @version    $Id$
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 */
require_once 'PHPUnit/Framework.php';

/**
 * Tests Converter csv class
 *
 * @copyright  Copyright (c) 2008 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL 2.1 (See LICENSE file)
 * @version    Release: @package_version@
 * @link       http://www.phprojekt.com
 * @since      File available since Release 6.0
 * @author     Gustavo Solt <solt@mayflower.de>
 */
class Phprojekt_Converter_CsvTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test csv converter
     */
    public function testConvert()
    {
        $convertedFields = '"Title","Start Date","End Date","Priority","Current Status","Percentage Completed"';
        $convertedValues = '"Invisible Root","","","","Offered","0.00"';
        $object          = Phprojekt_Loader::getModel('Project', 'Project');
        $records         = $object->fetchAll();
        $result          = Phprojekt_Converter_Csv::convert($records);
        $this->assertTrue(strlen(strstr($result, $convertedFields)) > 0);
        $this->assertTrue(strlen(strstr($result, $convertedValues)) > 0);

        $result = Phprojekt_Converter_Csv::convert($object->find(1));
        $this->assertEquals($result, "");
    }

    /**
     * Test csv convertion of array
     */
    public function testConvertArray()
    {
        $data      = array('first entry', 'second entry');
        $converted = "\"\n\"\n";
        $result    = Phprojekt_Converter_Csv::convert($data);;
        $this->assertEquals($converted, $result);

        $data            = array();
        $data[0][]       = 'Title 1';
        $data[0][]       = 'Title 2';
        $data[1][]       = 'Data 1';
        $data[1][]       = 'Data 2';
        $convertedFields = '"Title 1","Title 2"';
        $convertedValues = '"Data 1","Data 2"';
        $result          = Phprojekt_Converter_Csv::convert($data);
        $this->assertTrue(strlen(strstr($result, $convertedFields)) > 0);
        $this->assertTrue(strlen(strstr($result, $convertedValues)) > 0);
    }
}