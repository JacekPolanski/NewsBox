<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\Type;

class News
{
	/**
	 * @var string
	 *
	 * @Type("string")
	 */
	private $title;

	/**
	 * @var \DateTime
	 *
	 * @Type("DateTime<'Y-m-d H:i'>")
	 */
	private $time;

	/**
	 * @var string
	 *
	 * @Type("string")
	 */
	private $content;

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return \DateTime
	 */
	public function getTime()
	{
		return $this->time;
	}

	/**
	 * @param \DateTime $time
	 */
	public function setTime($time)
	{
		$this->time = $time;
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param string $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}
}