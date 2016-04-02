<?php

namespace AppBundle\Service;

use AppBundle\Entity\News;
use AppBundle\Entity\NewsCollection;
use JMS\Serializer\Serializer;

class NewsDeserializer
{
	const FORMAT_TYPES = ['json', 'xml', 'yaml'];

	/**
	 * @var Serializer
	 */
	private $serializer;

	/**
	 * @var string
	 */
	private $format;

	/**
	 * @param Serializer $serializer
	 * @param string $format json, xml or yaml
	 */
	public function __construct(Serializer $serializer, $format)
	{
		if (!in_array($format, self::FORMAT_TYPES)) {
			throw new \UnexpectedValueException('Deserializer support only JSON, XML or YAML data formats.');
		}

		$this->serializer = $serializer;
		$this->format = $format;
	}

	/**
	 * @param string $data
	 * @return News
	 */
	public function deserializeOne($data)
	{
		return $this->serializer->deserialize($data, 'AppBundle\Entity\News', $this->format);
	}

	/**
	 * @param $data
	 * @return NewsCollection
	 */
	public function deserializeCollection($data)
	{
		return $this->serializer->deserialize($data, 'ArrayCollection<AppBundle\Entity\News>', $this->format);
	}
}
