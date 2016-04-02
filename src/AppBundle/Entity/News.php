<?php

namespace AppBundle\Entity;

class News
{
	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var \DateTime
	 */
	private $time;

	/**
	 * @var string
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