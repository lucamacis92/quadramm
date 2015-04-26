<?php

class Negozio {
	
	private $nome_negozio;
	private $descrizione;
	private $id;
	
	public function __construct()
	{
		
	}
	
		
	public function getNomeNegozio()
	{
		return $this->nome_negozio;
	}
	
	public function setNomeNegozio($val_nome_negozio)
	{
		if (!filter_var($val_nome_negozio, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z0-9]{5}/')))) {
			return false;
		}
		$this->nome_negozio = $val_nome_negozio;
		return true;
	}
	
	public function getDescrizione()
	{
		return $this->descrizione;
	}
	
	public function setDescrizione($val_descrizione)
	{
		$this->descrizione = $val_descrizione;
		return true;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setId($val_id)
	{
		$this->id = $val_id;
		return true;
	}
	
	
}
