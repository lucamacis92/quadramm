<?php

class Paint {
	
	const Moderna = 'Moderna';
	const Medievale = 'Medievale';
	const Contemporanea = 'Contemporanea';
	
	
	private $id;
	private $nome;
	private $tipologia;
	private $autore;
	private $data;
	private $dimensione;
	private $tecnica;
	private $corrente;
	private $descrizione;
	private $qty;
	private $prezzo;
	private $prezzo_min;
	private $prezzo_max;
	private $immagine;
	private $negozio;
	private $stato;
	
	public function __construct()
	{
			
	}
		
	public function getStato()
	{
		return $this->stato;
	}
	
	public function setStato($stato)
	{
		if (!filter_var($stato, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[0-9]{1}/')))) {
			return false;
		}
		$this->stato = $stato;
		return true;
	}
	
	public function getNegozio()
	{
		return $this->negozio;
	}
	
	public function setNegozio($nome)
	{
		$this->negozio = $nome;
	}
	
	public function getPrezzoMin()
	{
		return $this->prezzo_min;
	}
	
	public function setPrezzoMin($val_prezzo_min)
	{
		$this->prezzo_min = $val_prezzo_min;
	}
	
	public function getPrezzoMax()
	{
		return $this->prezzo_max;
	}
	
	public function setPrezzoMax($val_prezzo_max)
	{
		$this->prezzo_max = $val_prezzo_max;
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
	
	public function getDescrizione()
	{
		return $this->descrizione;
	}
	
	public function setDescrizione($val_desc)
	{
		$this->descrizione = $val_desc;
		return true;
	}
	
	public function getNome()
	{
		return $this->nome;
	}
	
	public function setNome($val_nome)
	{
		if (!isset($val_nome) || !$val_nome != '') {
			return false;
		}
		$this->nome = $val_nome;
		return true;
	}
	
	public function getTipologia()
	{
		return $this->tipologia;
	}
	
	public function setTipologia($val_tipologia)
	{
		$this->tipologia = $val_tipologia;
		return true;
	}
	
	public function getAutore()
	{
		return $this->autore;
	}
	
	public function setAutore($val_autore)
	{
		$this->autore = $val_autore;
		return true;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function setData($val_data)
	{
		$this->data = $val_data;
		return true;
	}
	
	public function getDimensione()
	{
		return $this->dimensione;
	}
	
	public function setDimensione($val_dimensione)
	{
		$this->dimensione = $val_dimensione;
		return true;
	}
	
	public function getTecnica()
	{
		return $this->tecnica;
	}
	
	public function setTecnica($val_tecnica)
	{
		$this->tecnica = $val_tecnica;
		return true;
	}
	
	public function getCorrente()
	{
		return $this->corrente;
	}
	
	public function setCorrente($val_corrente)
	{
		$this->corrente = $val_corrente;
		return true;
	}
	
	public function getQty()
	{
		return $this->qty;
	}
	
	public function setQty($val_qty)
	{
		$this->qty = $val_qty;
		return true;
	}
	
	public function getPrezzo()
	{
		return $this->prezzo;
	}
	
	public function setPrezzo($val_prezzo)
	{
		$this->prezzo = $val_prezzo;
		return true;
	}
	
	public function getImmagine()
	{
		return $this->immagine;
	}
	
	public function setImmagine($url_img)
	{
		$this->immagine = $url_img;
		return true;
	}
}

?>