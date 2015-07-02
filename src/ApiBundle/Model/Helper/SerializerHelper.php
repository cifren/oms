<?php

namespace ApiBundle\Model\Helper;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer as baseGetSetMethodNormalizer;
use ApiBundle\Model\Serializer\Normalizer\GetSetMethodNormalizer;

class SerializerHelper
{

    /**
     *
     * @var array 
     */
    protected $encoders;

    /**
     *
     * @var GetSetMethodNormalizer 
     */
    protected $normalizer;

    /**
     *
     * @var baseGetSetMethodNormalizer 
     */
    protected $recursiveNormalizer;

    public function __construct()
    {
        $this->encoders = array(new XmlEncoder(), new JsonEncoder());
        $this->customNormalizer = new GetSetMethodNormalizer();
        $this->recursiveNormalizer = new baseGetSetMethodNormalizer();
    }

    /**
     * 
     * @param object $object
     * 
     * @return array
     */
    public function getArrayFromObject($object)
    {
        $serializer = new Serializer(array($this->customNormalizer), $this->encoders);
        $data = $serializer->normalize($object);

        return $data;
    }

    /**
     * 
     * @param object $object
     * 
     * @return array
     */
    public function getArrayFromObjectRecursive($object, array $ignoredAttributes = null)
    {
        $ignoredAttributes = empty($ignoredAttributes) ? array() : $ignoredAttributes;
        
        $this->recursiveNormalizer->setIgnoredAttributes($ignoredAttributes);
        $serializer = new Serializer(array($this->recursiveNormalizer), $this->encoders);
        $data = $serializer->normalize($object);

        return $data;
    }

}
