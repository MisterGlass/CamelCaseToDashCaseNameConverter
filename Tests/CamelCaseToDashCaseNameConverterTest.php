<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MrGlass\CamelCaseToDashCaseNameConverter\Tests;

use MrGlass\CamelCaseToDashCaseNameConverter\CamelCaseToDashCaseNameConverter;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class CamelCaseToDashCaseNameConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $attributeMetadata = new CamelCaseToDashCaseNameConverter();
        $this->assertInstanceOf(
            'Symfony\Component\Serializer\NameConverter\NameConverterInterface',
            $attributeMetadata
        );
    }

    /**
     * @dataProvider attributeProvider
     */
    public function testNormalize($underscored, $lowerCamelCased)
    {
        $nameConverter = new CamelCaseToDashCaseNameConverter();
        $this->assertEquals($nameConverter->normalize($lowerCamelCased), $underscored);
    }

    /**
     * @dataProvider attributeProvider
     */
    public function testDenormalize($underscored, $lowerCamelCased)
    {
        $nameConverter = new CamelCaseToDashCaseNameConverter();
        $this->assertEquals($nameConverter->denormalize($underscored), $lowerCamelCased);
    }

    public function attributeProvider()
    {
        return array(
            array('coop-tilleuls', 'coopTilleuls'),
            array('-kevin-dunglas', '-kevinDunglas'),
            array('this-is-a-test', 'thisIsATest'),
        );
    }
}
