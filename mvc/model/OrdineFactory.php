<?php

include_once 'DB.php';
include_once 'Ordine.php';


class OrdineFactory
{
	public function __construct()
	{
		
	}
	
	public static function changeShipmentStatus($id_ordine, $id_quadro, $id_negozio)
	{
		if(Settings::debug)
			echo "ordine: $id_ordine quadro: $id_quadro negozio: $id_negozio";
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT Stato
				FROM Negozio_has_Quadri_has_Ordine
				WHERE 
					OrdineID = ? AND
					NegozioID = ? AND
					QuadriID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('iii', $id_ordine, $id_negozio, $id_quadro);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->bind_result($res_stato);
		
		$stmt->fetch();
		
		if($res_stato == 0)
				$stato = 1;
		else 	
				$stato = 0;
		
		if(Settings::debug)
			echo "statoTabella: $res_stato stato: $stato";
		
		$qry = "
				UPDATE Negozio_has_Quadri_has_Ordine
				SET Stato = ?
				WHERE
					OrdineID = ? AND
					NegozioID = ? AND
					QuadriID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('iiii', $stato, $id_ordine, $id_negozio, $id_quadro);
		
		if(!$stmt->execute())
			return false;
		
		$qry = "
				SELECT * 
				FROM Negozio_has_Quadri_has_Ordine
				WHERE
					OrdineID = ? AND
					Stato = 0
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id_ordine);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			$stato = 0;
		}
		else 
		{
			$stato = 1;
		}
		
		$qry = "
				UPDATE Ordine
				SET Stato = ?
				WHERE ID = ?	
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('ii', $stato, $id_ordine);
		
		if(!$stmt->execute())
			return false;
	}
	
	public static function &loadOrderFromUserId($id)
	{
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT
					ID, 
					Data, 
					Stato
				FROM Ordine
				WHERE User_ID = ?";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			$stmt->bind_result($res_id, $res_data, $res_stato);
			
			while($stmt->fetch())
			{
				$ordine = new Ordine();
				
				$ordine->setId($res_id);
				$ordine->setData($res_data);
				$ordine->setStato($res_stato);
				
				$toRet[] = $ordine;
			}
		}
		
		return $toRet;
	}
	
	public static function &loadOrderFromIdNegozio($id)
	{
		$toRet = array();
	
		$stmt = DB::istance()->stmt_init();
	
		$qry = "
				SELECT
					ID,
					Data,
					Ordine.Stato
				FROM Ordine
				JOIN Negozio_has_Quadri_has_Ordine 
				        ON Negozio_has_Quadri_has_Ordine.OrdineID = Ordine.ID
				WHERE NegozioID = ?
				GROUP BY Ordine.ID
		";
	
		$stmt->prepare($qry);
	
		$stmt->bind_param('i', $id);
	
		if(!$stmt->execute())
			return false;
	
		$stmt->store_result();
	
		if($stmt->num_rows > 0)
		{
			$stmt->bind_result($res_id, $res_data, $res_stato);
				
			while($stmt->fetch())
			{
				$ordine = new Ordine();
	
				$ordine->setId($res_id);
				$ordine->setData($res_data);
				$ordine->setStato($res_stato);
	
				$toRet[] = $ordine;
			}
		}
	
		return $toRet;
	}
	
	public static function &loadOrderFromId($id)
	{
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT
					ID, 
					Data, 
					Stato
				FROM Ordine
				WHERE ID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		$stmt->bind_result($res_id, $res_data, $res_stato);
		
		$stmt->fetch();
		
		$ordine = new Ordine();
		
		$ordine->setId($res_id);
		$ordine->setData($res_data);
		$ordine->setStato($res_stato);
		
		$qry = "
				SELECT
					Quadri.Nome,
                                        Quadri.Immagine,
					Negozio.NomeNegozio,
					Negozio_has_Quadri_has_Ordine.Prezzo,
					Negozio_has_Quadri_has_Ordine.Qty
				FROM Negozio_has_Quadri_has_Ordine
				JOIN Negozio ON Negozio_has_Quadri_has_Ordine.NegozioID = Negozio.ID
				JOIN Quadri ON Negozio_has_Quadri_has_Ordine.QuadriID = Quadri.ID
				WHERE OrdineID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->bind_result(
							$res_nome,
                                                        $res_immagine,
							$res_negozio,
							$res_prezzo,
							$res_qty
		);
		
		while($stmt->fetch())
		{
			$paint = new Paint();
			
			$paint->setNome($res_nome);
                        $paint->setImmagine($res_immagine);
			$paint->setPrezzo($res_prezzo);
			$paint->setQty($res_qty);
			$paint->setNegozio($res_negozio);
			
			$ordine->addWork($paint);
		}
		
		return $ordine;
	}
	
	public static function loadOrderWorkFromIdAndIdNegozio($id, $id_negozio)
	{
            
            if(Settings::debug)
                echo " ".$id." ".$id_negozio;
                
                
		$stmt = DB::istance()->stmt_init();
	
		$qry = "
				SELECT
					ID,
					Data,
					Stato
				FROM Ordine
				WHERE ID = ?
		";
	
		$stmt->prepare($qry);
	
		$stmt->bind_param('i', $id);
	
		if(!$stmt->execute())
			return false;
	
		$stmt->store_result();
	
		$stmt->bind_result($res_id, $res_data, $res_stato);
	
		$stmt->fetch();
	
		$ordine = new Ordine();
	
		$ordine->setId($res_id);
		$ordine->setData($res_data);
		$ordine->setStato($res_stato);
	
		$qry = "
				SELECT
					Quadri.Nome,
                                        Quadri.Immagine,
					Negozio.NomeNegozio,
					Negozio_has_Quadri_has_Ordine.Prezzo,
					Negozio_has_Quadri_has_Ordine.Qty,
					Quadri.ID,
					Negozio_has_Quadri_has_Ordine.Stato
				FROM Negozio_has_Quadri_has_Ordine
				JOIN Negozio ON Negozio_has_Quadri_has_Ordine.NegozioID = Negozio.ID
				JOIN Quadri ON Negozio_has_Quadri_has_Ordine.QuadriID = Quadri.ID
				WHERE 
					OrdineID = ? AND
					NegozioID = ?
		";
	
		$stmt->prepare($qry);
	
		$stmt->bind_param('ii', $id, $id_negozio);
	
		if(!$stmt->execute())
			return false;
	
		$stmt->bind_result(
				$res_nome,
                                $res_immagine,
				$res_negozio,
				$res_prezzo,
				$res_qty,
				$res_id,
				$res_stato
		);
	
		while($stmt->fetch())
		{
			$paint = new Paint();
				
			$paint->setId($res_id);
			$paint->setNome($res_nome);
                        $paint->setImmagine($res_immagine);
			$paint->setPrezzo($res_prezzo);
			$paint->setQty($res_qty);
			$paint->setNegozio($res_negozio);
			$paint->setStato($res_stato);
				
			$ordine->addWork($paint);
		}
                
                
	
		return $ordine;
	}
}