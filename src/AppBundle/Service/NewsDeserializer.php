<?php

namespace AppBundle\Service;

use AppBundle\Entity\News;
use JMS\Serializer\Serializer;

class NewsDeserializer
{
	/**
	 * @var Serializer
	 */
	private $serializer;

	/**
	 * @param Serializer $serializer
	 */
	public function __construct(Serializer $serializer)
	{
		$this->serializer = $serializer;
	}

	/**
	 * @param string $jsonData
	 * @return News
	 */
	public function deserializeFromJson($jsonData)
	{
		return $this->serializer->deserialize($jsonData, 'AppBundle\Entity\News', 'json');
	}
}
