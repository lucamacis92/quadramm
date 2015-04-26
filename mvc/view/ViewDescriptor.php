<?php

class ViewDescriptor
{
	
	const get = 'get';
	
	const post = 'post';

	private $titolo;
	private $login_file;
	private $menu_file;
	private $content_file;
	private $pagina;
	private $sottopagina;
	private $url_base;
	
	private $listWork;
	private $contentTitle;
	
	private $work;
	private $negozi;
	
	private $is_seller;
	
	private $work_qty;
	private $subTot;
	
	private $error_message;
	private $info_message;
	
	private $prezzo_negozio;

	public function __construct()
	{
		$this->info_message = array();
		$this->error_message = array();
	}
	
	public function getNegozi()
	{
		return $this->negozi;
	}
	
	public function setNegozi($negozi)
	{
		$this->negozi = $negozi;
	}
	
	public function getPrezzoNegozio()
	{
		return $this->prezzo_negozio;
	}
	
	public function setPrezzoNegozio($array_prezzo_negozio)
	{
		$this->prezzo_negozio = $array_prezzo_negozio;
	}
	
	public function getErrorMessage()
	{
		if($this->error_message)
			return $this->error_message;
		else
			return false;
	}
	
	public function setErrorMessage($message)
	{
		$this->error_message[] = $message;
	}
	
	public function getInfoMessage()
	{
		if($this->info_message)
			return $this->info_message;
		else
			return false;
	}
	
	public function setInfoMessage($message)
	{
		$this->info_message[] = $message;
	}

	public function getWorkQty()
	{
		return $this->work_qty;
	}

	public function setWorkQty($val_qty)
	{
		$this->work_qty = $val_qty;
	}

	public function getSubTot()
	{
		return $this->subTot;
	}

	public function setSubTot($val_subTot)
	{
		$this->subTot = $val_subTot;
	}

	public function getSeller()
	{
		return $this->is_seller;
	}

	public function setSeller($val_seller)
	{
		$this->is_seller = $val_seller;
	}

	public function getWork()
	{
		return $this->work;
	}

	public function setWork($val_work)
	{
		$this->work = $val_work;
	}

	public function getUrlBase()
	{
		return $this->url_base;
	}

	public function setUrlBase($val_url_base)
	{
		$this->url_base = $val_url_base;
	}

	public function getContentTitle()
	{
		return $this->contentTitle;
	}

	public function setContentTitle($val_title)
	{
		$this->contentTitle = $val_title;
	}

	public function getListWork()
	{
		return $this->listWork;
	}

	public function setListWork($list)
	{
		$this->listWork = $list;
	}

	public function getTitolo()
	{
		return $this->titolo;
	}

	public function setTitolo($titolo)
	{
		$this->titolo = $titolo;
	}

	public function getLoginFile()
	{
		return $this->login_file;
	}

	public function setLoginFile($login)
	{
		$this->login_file = $login;
	}

	public function getMenuFile()
	{
		return $this->menu_file;
	}

	public function setMenuFile($menu)
	{
		$this->menu_file = $menu;
	}

	public function getContentFile()
	{
		return $this->content_file;
	}

	public function setContentFile($content)
	{
		$this->content_file = $content;
	}

	public function getPagina()
	{
		return $this->pagina;
	}

	public function setPagina($pagina)
	{
		$this->pagina = $pagina;
	}

	public function getSottopagina()
	{
		return $this->sottopagina;
	}

	public function setSottopagina($sottopagina)
	{
		$this->sottopagina = $sottopagina;
	}



	public function setImpToken($token) {
		$this->impToken = $token;
	}

	public function scriviToken($pre = '', $method = self::get) {
        $imp = BaseController::impersonato;
        switch ($method) {
            case self::get:
                if (isset($this->impToken)) {
                    // nel caso della 
                    return $pre . "$imp=$this->impToken";
                }
                break;

            case self::post:
                if (isset($this->impToken)) {
                    return "<input type=\"hidden\" name=\"$imp\" value=\"$this->impToken\"/>";
                }
                break;
        }

        return '';
    }
}