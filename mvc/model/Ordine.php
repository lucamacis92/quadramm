<?php

class Ordine
{
	const Nuovo = 0;
	const Spedito = 1;
	
	private $stato;
	private $works;
	private $data;
	private $id;
	
	public function __construct()
	{
		$this->works = array();
	}
	
	public function getStato()
	{
		return $this->stato;
	}
	
	public function setStato($stato)
	{
		$this->stato = $stato;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function setData($data)
	{
		$this->data = $data;
	}
	
	public function addWork($work)
	{
		$this->works[] = $work;
	}
	
	public function setWorks($works)
	{
		$this->works = $works;
	}
	
	public function getWorks()
	{
		return $this->works;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
}

?>