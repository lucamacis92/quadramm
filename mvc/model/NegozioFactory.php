<?php

include_once 'Negozio.php';
include_once 'Paint.php';
include_once 'DB.php';

class NegozioFactory {
	
	public function __construct()
	{
		
	}
	
	public static function makeNegozioFromRequest($request, $vd)
	{
		$check = true;
			
		$toRet = new Negozio();
			
		if(!$toRet->setNomeNegozio($request['nome_negozio'])){
			$vd->setErrorMessage('Nome non valido.'); $check = false;
		}
		if(!$toRet->setDescrizione($request['descrizione'])){
			$vd->setErrorMessage('Descrizione non valida.'); $check = false;
		}
		
		if(isset($request['id']))
			if(!$toRet->setId($request['id'])){ $vd->setErrorMessage('ID non valido.'); $check = false;}
			
		if($check)
			return $toRet;
		else
			return false;
	}
	
	public static function recoverNegozioFromRequest($request)
	{
		$toRet = new Negozio();
		
		$toRet->setNomeNegozio($request['nome_negozio']);
		$toRet->setDescrizione($request['descrizione']);
			
		return $toRet;
			
	}
	
	public static function storeNegozio(Negozio $negozio, User $user, ViewDescriptor $vd)
	{
		$nomeNegozio = $negozio->getNomeNegozio();
		$descrizione = $negozio->getDescrizione();
		$id = $user->getId();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT *
				FROM Negozio
				WHERE User_ID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id);
		
		if(!$stmt->execute())
		{
			$vd->setErrorMessage('Errore di salvataggio dati, per favore riprova piu tardi.');
			return false;
		}
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			$vd->setErrorMessage('Hai gia un negozio, non puoi aprirne piu di uno.');
			return false;
		}
		 
		$qry = "
				SELECT * 
				FROM Negozio 
				WHERE NomeNegozio=?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('s', $nomeNegozio);
		
		if(!$stmt->execute())
		{
			$vd->setErrorMessage('Errore di salvataggio dati, per favore riprova piu tardi.');
			return false;
		}
			
		$stmt->store_result();
		
		if($stmt->num_rows == 0)
		{ 
			$qry = 
				"INSERT INTO Negozio 
					(NomeNegozio, Descrizione, User_ID) 
				VALUES (?, ?, ?)
			";
				
			$stmt->prepare($qry);
			
			$stmt->bind_param('ssi', $nomeNegozio, $descrizione, $id);
			
			if(!$stmt->execute())
			{
				$vd->setErrorMessage('Errore di salvataggio dati, per favore riprova piu tardi.');
				return false;
			}
			
			return true;		
			
		}
		else
		{
			$vd->setErrorMessage("Il nome che ai scelto &egrave; gia utilizzato.");
			return false;
		}
	}
	
	public static function updateNegozio(Negozio $negozio)
	{
		$nomeNegozio = $negozio->getNomeNegozio();
		$descrizione = $negozio->getDescrizione();
		$id = $negozio->getId();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				UPDATE Negozio
				SET
					NomeNegozio = ?,
					Descrizione = ?
				WHERE
					ID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('ssi', $nomeNegozio, $descrizione, $id);
		
		if(!$stmt->execute())
			return false;
		return true;
	}
	
	public static function loadNegozioFromUserID($id)
	{
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT 
					ID,
					NomeNegozio,
					Descrizione
				FROM Negozio 
				WHERE User_ID = ? 
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			$stmt->bind_result(	
								$res_id,
								$res_nomenegozio,
								$res_descrizione
			);
			
			$stmt->fetch();
			
			$toRet = new Negozio();
			
			$toRet->setNomeNegozio($res_nomenegozio);
			$toRet->setDescrizione($res_descrizione);
			$toRet->setId($res_id);
				
			return $toRet;
		}
		
		return false;
	}
	
	public static function &loadListNegozi($id_user)
	{
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		
                $qry = "
                        SELECT
                                ID,
                                NomeNegozio,
                                Descrizione
                        FROM Negozio
                ";
		
		$stmt->prepare($qry);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
	
                $stmt->bind_result(
                                $res_id,
                                $res_nomenegozio,
                                $res_descrizione
                );
			
		while($stmt->fetch())
		{
			$negozio = new Negozio();
			
			$negozio->setNomeNegozio($res_nomenegozio);
			$negozio->setDescrizione($res_descrizione);
			$negozio->setId($res_id);
			
			$toRet[] = $negozio;
		}
	
		return $toRet;
	}
	
	public static function setWorkStoreParam($id_negozio, Paint $paint)
	{
		$id_quadro = $paint->getId();
		$qty = $paint->getQty();
		$prezzo = $paint->getPrezzo();
		
		if($qty == "" || $prezzo == "")
			return false;
		
		$stmt = DB::istance()->stmt_init();
		
		$qry="
			SELECT *
			FROM Negozio_has_Quadri
			WHERE NegozioID = ? AND QuadroID = ?	
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('ii', $id_negozio, $id_quadro);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			// update
			
			$qry = "
				UPDATE Negozio_has_Quadri 
				SET 
					Qty = ?,
					Prezzo = ?
				WHERE	
					NegozioID = ? AND
					QuadroID = ?
			";
		}
		else
		{
			// insert
			
			$qry = "
				INSERT INTO Negozio_has_Quadri
					(Qty, Prezzo, NegozioID, QuadroID)
				VALUE(?, ?, ?, ?)	
			";
			
		}
		
		$stmt = DB::istance()->stmt_init();
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('iiii', $qty, $prezzo, $id_negozio, $id_quadro);
		
		if(!$stmt->execute())
			return false;
		
		return true;
	}
	
	
	
}