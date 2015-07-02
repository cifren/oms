<?php

namespace ApiBundle\Model\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer as baseGetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * ApiBundle\Model\Serializer\Normalizer\GetSetMethodNormalizer
 */
class GetSetMethodNormalizer extends baseGetSetMethodNormalizer
{

    /**
     * {@inheritdoc}
     * 
     * Modified in order to avoid recursivity and simplify array
     */
    public function normalize($object, $format = null, array $context = array())
    {
        $reflectionObject = new \ReflectionObject($object);
        $reflectionMethods = $reflectionObject->getMethods(\ReflectionMethod::IS_PUBLIC);

        $attributes = array();
        foreach ($reflectionMethods as $method) {
            if ($this->isGetMethod($method)) {
                $attributeName = lcfirst(substr($method->name, 3));

                if (in_array($attributeName, $this->ignoredAttributes)) {
                    continue;
                }

                $attributeValue = $method->invoke($object);
                if (array_key_exists($attributeName, $this->callbacks)) {
                    $attributeValue = call_user_func($this->callbacks[$attributeName], $attributeValue);
                }
                if (null !== $attributeValue && !is_scalar($attributeValue)) {
                    if (!$this->serializer instanceof NormalizerInterface) {
                        throw new \LogicException(sprintf('Cannot normalize attribute "%s" because injected serializer is not a normalizer', $attributeName));
                    }

                    //get id from children, not the object and only if getid exist
                    if (is_object($attributeValue)) {
                        $reflectionObjectChild = new \ReflectionObject($attributeValue);
                        if ($reflectionObjectChild->hasMethod('getId') && $this->isGetMethod($reflectionObjectChild->getMethod('getId'))) {
                            $methodChild = $reflectionObjectChild->getMethod('getId');
                            $attributeValue = $methodChild->invoke($attributeValue);
                        }
                    }
                }

                //exclude array and object
                if (!is_object($attributeValue) && !is_array($attributeValue)) {
                    $attributes[$attributeName] = utf8_encode($attributeValue);
                }
            }
        }

        return $attributes;
    }

    /**
     * Checks if a method's name is get.* and can be called without parameters.
     *
     * @param \ReflectionMethod $method the method to check
     *
     * @return bool    whether the method is a getter.
     */
    protected function isGetMethod(\ReflectionMethod $method)
    {
        return (
                0 === strpos($method->name, 'get') &&
                3 < strlen($method->name) &&
                0 === $method->getNumberOfRequiredParameters()
                );
    }

}
