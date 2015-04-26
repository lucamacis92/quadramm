<?php
include_once 'Ordine.php';

class Carrello
{
	private $qty;
	private $subTot;
	private $tot;
	private $works;
	
	public function __construct()
	{
		$this->qty = 0;
		$this->subTot = 0;
		$this->tot = 0;
		$this->works = array();
	}
	
	public function getQty()
	{
		return $this->qty;
	}
	
	public function setQty($val_qty)
	{
		$this->qty = $val_qty;
	}
	
	public function getSubTot()
	{
		return $this->subTot;
	}
	
	public function setSubTot($val_subtot)
	{
		$this->subTot = $val_subtot;
	}
	
	public function getTot()
	{
		return $this->tot;
	}
	
	public function setTot($val_tot)
	{
		$this->tot = $val_tot;
	}
	
	public function getWorks()
	{
		$toRet = array();
		
		foreach ($this->works as $dev)
		{
			if($dev->getId())
			{
				$toRet[] = $dev;
			}
		}
		
		return $toRet;
	}
	
	public function getWorkFromId($id, $negozio)
	{
		for($i = 0; $i < count($this->works); $i++)
		{
			if($id == $this->works[$i]->getId() && $negozio == $this->works[$i]->getNegozio())
			{
				return $this->works[$i];
			}
		}
	}
	
	public function addWork($work)
	{
		$work->setQty(1);
		
		$this->tot = $this->tot + $work->getPrezzo();
		
		$this->qty = $this->qty + 1;
		
		$check = true;
		
		for($i = 0; $i < count($this->works); $i++)
		{
			if($work->getId() == $this->works[$i]->getId())
			{
				if($work->getNegozio() == $this->works[$i]->getNegozio())
				{
					$this->works[$i]->setQty($this->works[$i]->getQty()+1);
					$check = false;
				}
			}
		}

		if($check){
			$this->works[] = clone $work;
		}
		
	}
	
	public function removeWork($work)
	{
		if(!isset($work)) return false;
		
		for($i = 0; $i < count($this->works); $i++)
		{
			if($work->getId() == $this->works[$i]->getId() && $work->getNegozio() == $this->works[$i]->getNegozio())
			{					
				$this->tot = $this->tot - $work->getPrezzo();
				$this->qty = $this->qty - $work->getQty();
				$this->works[$i] = new Paint();
				return true;
			}
		}
		
		return false;
	}
	
	public function checkout($id_user)
	{
		$date = Date("Y-m-d h:i:s");
		$nuovo = Ordine::Nuovo;
		
		DB::istance()->autocommit(false);
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				INSERT INTO Ordine
					(Data, Stato, User_ID)
				VALUE 
					(?, ?, ?)
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('sii', $date, $nuovo, $id_user);
		
		if(!$stmt->execute())
		{
			DB::istance()->rollback();
			return false;
		}
		
		$qry = "
				SELECT ID
				FROM Ordine
				WHERE 
					Data = ? AND
					User_ID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('si', $date, $id_user);
		
		if(!$stmt->execute())
		{
			DB::istance()->rollback();
			return false;
		}
		
		$stmt->bind_result($res_idordine);
		
		$stmt->fetch();
		
		foreach ($this->getWorks() as $work)
		{
			$qty = $work->getQty();
			$nomeNegozio = $work->getNegozio();
			$prezzo = $work->getPrezzo();
			$id = $work->getId();
			
			$soldiNegozio = $prezzo*0.9;
			$soldiSito = $prezzo*0.1;
			
			//	modifico la quantita disponibile del quadro
			$stmt = DB::istance()->stmt_init();
			
			$qry = "
					UPDATE Negozio_has_Quadri
					SET
						Qty = Qty - ?
					WHERE NegozioID = (
										SELECT ID
										FROM Negozio
										WHERE NomeNegozio = ?
										) AND
						QuadroID = ?
			";
			
			$stmt->prepare($qry);
			
			$stmt->bind_param('isi', $qty, $nomeNegozio, $id);
			
			if(!$stmt->execute())
			{
				DB::istance()->rollback();
				return false;
			}
			
			//	scalo il credito dell'utente
			$stmt = DB::istance()->stmt_init();
			
			$qry = "
					UPDATE User
					SET
						Credito = Credito - ?
					WHERE ID = ?
			";
			
			$stmt->prepare($qry);
			
			$stmt->bind_param('si', $prezzo, $id_user);
			
			if(!$stmt->execute())
			{
				DB::istance()->rollback();
				return false;
			}
			
			//	accredito i soldi al negoziante
			$stmt = DB::istance()->stmt_init();
				
			$qry = "
					UPDATE User
					SET
						Credito = Credito + ?
					WHERE ID = (
								SELECT User_ID
								FROM Negozio
								WHERE NomeNegozio = ?
								)
			";
				
			$stmt->prepare($qry);
				
			$stmt->bind_param('ss', $soldiNegozio, $nomeNegozio);
				
			if(!$stmt->execute())
			{
				DB::istance()->rollback();
				return false;
			}
			
			//	accredito i soldi all'amministratore
			$stmt = DB::istance()->stmt_init();
			
			$qry = "
					UPDATE User
					SET
						Credito = Credito + ?
					WHERE Ruolo = 0
			";
			
			$stmt->prepare($qry);
			
			$stmt->bind_param('s', $soldiSito);
			
			if(!$stmt->execute())
			{
				DB::istance()->rollback();
				return false;
			}
			
			//	aggiungo il quadro alla tabella ordini
			$stmt = DB::istance()->stmt_init();
			
			$qry = "
					INSERT INTO Negozio_has_Quadri_has_Ordine
						(NegozioID, QuadriID, OrdineID, Prezzo, Qty, Stato)
					VALUE
						((
							SELECT ID
							FROM Negozio
							WHERE NomeNegozio = ?
						), ?, ?, ?, ?, ?)
						
			";
			
			$stmt->prepare($qry);
			
			$stmt->bind_param('siiiii', $nomeNegozio, $id, $res_idordine, $prezzo, $qty, $nuovo);
			
			if(!$stmt->execute())
			{
				DB::istance()->rollback();
				return false;
			}
			
		}
		
		DB::istance()->commit();
		
		DB::istance()->autocommit(true);
		
		$this->qty = 0;
		$this->tot = 0;
		$this->works = array();
		
		return true;
	}
}

?>