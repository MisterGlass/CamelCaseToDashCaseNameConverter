<?php
namespace MrGlass\CamelCaseToDashCaseNameConverter;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * CamelCaseToDashCaseNameConverter name converter.
 * Heavily based on the Symfony CamelCaseToSnakeCaseNameConverter
 */
class CamelCaseToDashCaseNameConverter implements NameConverterInterface
{
    /**
     * @var array|null
     */
    private $attributes;

    /**
     * @var bool
     */
    private $lowerCamelCase;

    /**
     * @param null|array $attributes     The list of attributes to rename or null for all attributes
     * @param bool       $lowerCamelCase Use lowerCamelCase style
     */
    public function __construct(array $attributes = null, $lowerCamelCase = true)
    {
        $this->attributes = $attributes;
        $this->lowerCamelCase = $lowerCamelCase;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($propertyName)
    {
        if (null === $this->attributes || in_array($propertyName, $this->attributes)) {
            $dasherizedCasedName = '';

            $len = strlen($propertyName);
            for ($i = 0; $i < $len; ++$i) {
                if (ctype_upper($propertyName[$i])) {
                    $dasherizedCasedName .= '-'.strtolower($propertyName[$i]);
                } else {
                    $dasherizedCasedName .= strtolower($propertyName[$i]);
                }
            }

            return $dasherizedCasedName;
        }

        return $propertyName;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($propertyName)
    {
        $camelCasedName = preg_replace_callback('/(^|-|\.)+(.)/', function ($match) {
            return ('.' === $match[1] ? '-' : '').strtoupper($match[2]);
        }, $propertyName);

        if ($this->lowerCamelCase) {
            $camelCasedName = lcfirst($camelCasedName);
        }

        if (null === $this->attributes || in_array($camelCasedName, $this->attributes)) {
            return $this->lowerCamelCase ? lcfirst($camelCasedName) : $camelCasedName;
        }

        return $propertyName;
    }
}
