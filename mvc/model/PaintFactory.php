<?php

include_once 'Paint.php';
include_once 'DB.php';

class PaintFactory {
	
	
	public function __construct()
	{
	}
	
	
	public static function &recoverPaintFromRequest($request)
	{
		$toRet = new Paint();
	
		$toRet->setNome($request['nome']);
		$toRet->setTipologia($request['tipologia']);
		$toRet->setAutore($request['autore']);
		$toRet->setData($request['data']);
		$toRet->setDimensione($request['dimensione']);
		$toRet->setTecnica($request['tecnica']);
		$toRet->setCorrente($request['corrente']);
		$toRet->setDescrizione($request['descrizione']);
		$toRet->setImmagine($request['immagine']);
			
		return $toRet;
			
	}
	
	public static function &updatePaint(Paint $paint, ViewDescriptor $vd)
	{
		$nome = $paint->getNome();
		$autore = $paint->getAutore();
		$data = $paint->getData();
		$dimensione = $paint->getDimensione();
		$tecnica = $paint->getTecnica();
		$corrente = $paint->getCorrente();
		$descrizione = $paint->getDescrizione();
		$immagine = $paint->getImmagine();
		$tipologia = $paint->getTipologia();
		$id = $paint->getId();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				UPDATE Quadri
				SET Nome = ?, 
					Autore = ?,
					Data = ?,
					Dimensione = ?,
					Tecnica = ?,
                                        Corrente = ?,
					Descrizione = ?,
					Immagine = ?,
					Tipologia = ? 
				WHERE ID = ? 
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('sssssssssi', 
										$nome,
										$autore,
										$data,
										$dimensione,
										$tecnica,
										$corrente,
										$descrizione,
										$immagine,
										$tipologia,
										$id
		);
		
		if($stmt->execute())
		{
			return true;
		}
		else
		{
			$vd->setErrorMessage('Errore di salvataggio dati, per favore riprova piu tardi.');
			return false;
		}
	}
	
	public static function &storePaint(Paint $paint, ViewDescriptor $vd)
	{
		$nome = $paint->getNome();
		$autore = $paint->getAutore();
		$data = $paint->getData();
		$dimensione = $paint->getDimensione();
		$tecnica = $paint->getTecnica();
		$corrente = $paint->getCorrente();
		$descrizione = $paint->getDescrizione();
		$immagine = $paint->getImmagine();
		$tipologia = $paint->getTipologia();
		$id = $paint->getId();
		
		$stmt = DB::istance()->stmt_init();
		 
		$qry = "
				SELECT * 
				FROM Quadri 
				WHERE Nome = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('s', $nome);
		
		if(!$stmt->execute())
		{
			$vd->setErrorMessage('Errore di salvataggio dati, per favore riprova piu tardi.');
			return false;
		}
		
		$stmt->store_result();
		 
		if($stmt->num_rows > 0)
		{
			$vd->setErrorMessage("Nome quadro gia in uso, controlla che il quadro che stai inserendo non sia gia presente tra quelli vendibili.");
			return false;
		}
			 
		$qry = "
				INSERT INTO Quadri 
					(Nome, Autore, Data, Dimensione, Tecnica, Corrente, Descrizione, Immagine, Tipologia) 
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)
		";
	
		$stmt->prepare($qry);
		
		$stmt->bind_param('sssssssss', 
										$nome,
										$autore,
										$data,
										$dimensione,
										$tecnica,
										$corrente,
										$descrizione,
										$immagine,
										$tipologia
										
		);
		
                if(Settings::debug){
                    echo $nome." ".$autore." ".$data." ".$dimensione." ".$tecnica." ".$corrente." ".$descrizione." ".$immagine." ".$tipologia;
                }
                    
                
		if($stmt->execute())
			return true;
		else 
		{
			$vd->setErrorMessage('Errore di salvataggio dati, per favore riprova piu tardi.');
			return false;
		}
	}
	
	public static function &makePaintFromRequest($request, $vd)
	{
		$check = true;
	
		$toRet = new Paint();
		
		if(isset($request['id'])) $toRet->setId($request['id']);
	
		if(!$toRet->setNome($request['nome'])){
			$vd->setErrorMessage('Nome non valido.'); $check = false;
		}
		if(!$toRet->setTipologia($request['tipologia'])){
			$vd->setErrorMessage('Tipologia non valida.'); $check = false;
		}
		if(!$toRet->setAutore($request['autore'])){
			$vd->setErrorMessage('Autore non valida.'); $check = false;
		}
		if(!$toRet->setData($request['data'])){
			$vd->setErrorMessage('DATA non valida.'); $check = false;
		}
		if(!$toRet->setDimensione($request['dimensione'])){
			$vd->setErrorMessage('DIMENSIONE non valida.'); $check = false;
		}
		if(!$toRet->setTecnica($request['tecnica'])){
			$vd->setErrorMessage('Tecnica non valida.'); $check = false;
		}
		if(!$toRet->setCorrente($request['corrente'])){
			$vd->setErrorMessage('Sistema Operativo non valida.'); $check = false;
		}
		if(!$toRet->setDescrizione($request['descrizione'])){
			$vd->setErrorMessage('Descrizione non valida.'); $check = false;
		}
                if(!$toRet->setImmagine($request['immagine'])){
			$vd->setErrorMessage('Immagine non valida.'); $check = false;
		}
	
		if($check)
			return $toRet;
		else
			return false;
	}
	
	public static function &makeWorkStoreFromRequest($request, $vd)
	{
		$check = true;
		
		$toRet = new Paint();
		
		$toRet->setId($request['id']);
		
		if(!$toRet->setQty($request['qty'])){
			$vd->setErrorMessage("Quantita non valida."); $check = false;
		}
		
		if(!$toRet->setPrezzo($request['prezzo'])){
			$vd->setErrorMessage("Prezzo non valido."); $check = false;
		}
		
		if($check)
			return $toRet;
		else 
			return false;
	}
	
	public static function &recoverWorkStoreFromRequest($request)
	{
		$toRet = Paint();
		
		$toRet->setQty($request['qty']);
		$toRet->setPrezzo($request['prezzo']);
		
		return $toRet;
	}
	
	public static function &loadWorkToSell($id_negozio)
	{
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		 
		$qry = "
				SELECT 
					ID,
					Nome,
					Tipologia,
					Autore,
					Data,
					Dimensione,
					Tecnica,
					Corrente,
					Descrizione,
					Immagine
				FROM Quadri 
				WHERE Quadri.ID NOT IN 
					(
						SELECT QuadroID 
						FROM Negozio_has_Quadri 
						WHERE NegozioID = ? 
					)
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id_negozio);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		 
		if($stmt->num_rows > 0){
			
			$stmt->bind_result(
					$res_id,
					$res_nome,
					$res_tipologia,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine
			);
		
			while($stmt->fetch())
			{
				$paint = new Paint();
				
				$paint->setId($res_id);
				$paint->setNome($res_nome);
				$paint->setTipologia($res_tipologia);
				$paint->setAutore($res_autore);
				$paint->setData($res_data);
				$paint->setDimensione($res_dimensione);
				$paint->setTecnica($res_tecnica);
				$paint->setCorrente($res_corrente);
				$paint->setDescrizione($res_descrizione);
				$paint->setImmagine($res_immagine);
				
				$toRet[] = $paint;
			}
		}
		
		return $toRet;
	}
	
	public static function &loadWorkFromNegozio($id_negozio)
	{
            
            if(Settings::debug)
                echo $id_negozio;
            
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT 	
					Quadri.ID, 
					Quadri.Nome, 
					Quadri.Tipologia, 
					Quadri.Autore, 
					Quadri.Data, 
					Quadri.Dimensione, 
					Quadri.Tecnica, 
					Quadri.Corrente, 
					Quadri.Descrizione, 
					Quadri.Immagine, 
					Negozio_has_Quadri.Qty, 
					Negozio_has_Quadri.Prezzo
				FROM Negozio_has_Quadri 
				JOIN Quadri ON Quadri.ID = Negozio_has_Quadri.QuadroID
				WHERE NegozioID = ?
		";
                
                
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $id_negozio);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			$stmt->bind_result(
					$res_id,
					$res_nome,
					$res_tipologia,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine,
					$res_qty,
					$res_prezzo
			);
			
			while($stmt->fetch())
			{
				$paint = new Paint();
				
				$paint->setId($res_id);
				$paint->setNome($res_nome);
				$paint->setTipologia($res_tipologia);
				$paint->setAutore($res_autore);
				$paint->setData($res_data);
				$paint->setDimensione($res_dimensione);
				$paint->setTecnica($res_tecnica);
				$paint->setCorrente($res_corrente);
				$paint->setDescrizione($res_descrizione);
				$paint->setImmagine($res_immagine);
				$paint->setQty($res_qty);
				$paint->setPrezzo($res_prezzo);
				
				$toRet[] = $paint;
			}
		}
		
		return $toRet;
	}
	
	public static function &loadWorkFromCategory($category)
	{
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT 
					`ID` , 
					`Nome` , 
					`Autore` , 
					`Data` , 
					`Dimensione` , 
					`Tecnica` , 
					`Corrente` , 
					`Descrizione` , 
					`Immagine` , 
					`Tipologia` , 
					SUM( Qty ) , 
					MIN( Prezzo ) , 
					MAX( Prezzo )
				FROM `Quadri`
				JOIN Negozio_has_Quadri ON Negozio_has_Quadri.QuadroID = Quadri.ID
				WHERE Tipologia = ?
				GROUP BY ID
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('s', $category);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			$stmt->bind_result(
					$res_id,
					$res_nome,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine,
					$res_tipologia,
					$res_qty,
					$res_prezzo_min,
					$res_prezzo_max
			);
			
			while($stmt->fetch())
			{
				if($res_qty > 0)
				{
					$paint = new Paint();
					
					$paint->setId($res_id);
					$paint->setNome($res_nome);
					$paint->setTipologia($res_tipologia);
					$paint->setAutore($res_autore);
					$paint->setData($res_data);
					$paint->setDimensione($res_dimensione);
					$paint->setTecnica($res_tecnica);
					$paint->setCorrente($res_corrente);
					$paint->setDescrizione($res_descrizione);
					$paint->setImmagine($res_immagine);
					$paint->setQty($res_qty);
					$paint->setPrezzoMin($res_prezzo_min);
					$paint->setPrezzoMax($res_prezzo_max);
					
					$toRet[] = $paint;
				}
			}
		}
		
		return $toRet;
	}
		
	public static function &loadAllWork()
	{
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT 
					`ID` , 
					`Nome` , 
					`Autore` , 
					`Data` , 
					`Dimensione` , 
					`Tecnica` , 
					`Corrente` , 
					`Descrizione` , 
					`Immagine` , 
					`Tipologia` , 
					SUM( Qty ) , 
					MIN( Prezzo ) , 
					MAX( Prezzo )
				FROM `Quadri`
				JOIN Negozio_has_Quadri ON Negozio_has_Quadri.QuadroID = Quadri.ID
				GROUP BY ID
		";
		
		$stmt->prepare($qry);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->store_result();
		
		if($stmt->num_rows > 0)
		{
			$stmt->bind_result(
					$res_id,
					$res_nome,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine,
					$res_tipologia,
					$res_qty,
					$res_prezzo_min,
					$res_prezzo_max
			);
			
			while($stmt->fetch())
			{
				if($res_qty > 0)
				{
					$paint = new Paint();
					
					$paint->setId($res_id);
					$paint->setNome($res_nome);
					$paint->setTipologia($res_tipologia);
					$paint->setAutore($res_autore);
					$paint->setData($res_data);
					$paint->setDimensione($res_dimensione);
					$paint->setTecnica($res_tecnica);
					$paint->setCorrente($res_corrente);
					$paint->setDescrizione($res_descrizione);
					$paint->setImmagine($res_immagine);
					$paint->setQty($res_qty);
					$paint->setPrezzoMin($res_prezzo_min);
					$paint->setPrezzoMax($res_prezzo_max);
					
					$toRet[] = $paint;
				}
			}
		}
		
		return $toRet;
	}
	
	public static function &loadWorkFromId($id)
	{
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT 
					ID,
					Nome,
					Tipologia,
					Autore,
					Data,
					Dimensione,
					Tecnica,
					Corrente,
					Descrizione,
					Immagine
				FROM Quadri
				WHERE ID = ?
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
					$res_nome,
					$res_tipologia,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine
			);
			
			$stmt->fetch();
		
			$paint = new Paint();
			
			$paint->setId($res_id);
			$paint->setNome($res_nome);
			$paint->setTipologia($res_tipologia);
			$paint->setAutore($res_autore);
			$paint->setData($res_data);
			$paint->setDimensione($res_dimensione);
			$paint->setTecnica($res_tecnica);
			$paint->setCorrente($res_corrente);
			$paint->setDescrizione($res_descrizione);
			$paint->setImmagine($res_immagine);
		}
		
		return $paint;
	}
	
	public static function &loadPriceFromWork($work_id)
	{
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT 
					QuadroID,
					NomeNegozio, 
					Prezzo, 
					Qty 
				FROM Negozio_has_Quadri 
				JOIN Negozio ON Negozio_has_Quadri.NegozioID = Negozio.ID
				WHERE Negozio_has_Quadri.QuadroID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('i', $work_id);
		
		if(!$stmt->execute())
			return $toRet;
		
		$stmt->store_result();
		
		$stmt->bind_result($res_id, $res_nome, $res_prezzo, $res_qty);
		
		while($stmt->fetch())
		{
			$paint = new Paint();
			
			$paint->setId($res_id);
			$paint->setNegozio($res_nome);
			$paint->setPrezzo($res_prezzo);
			$paint->setQty($res_qty);
			
			$toRet[] = $paint;
		}
		
		return $toRet;
	}
	
	public static function &loadWorkStoreFromId($work_id, $negozio)
	{
		
		$stmt = DB::istance()->stmt_init();
		
		if(is_numeric($negozio))
		{
			$qry = "
					SELECT
						Quadri.ID,
						Nome,
						Tipologia,
						Autore,
						Data,
						Dimensione,
						Tecnica,
						Corrente,
						Quadri.Descrizione,
						Immagine,
						Prezzo,
						Qty,
						NomeNegozio
					FROM Negozio_has_Quadri
					JOIN Quadri ON Negozio_has_Quadri.QuadroID = Quadri.ID
					JOIN Negozio ON Negozio_has_Quadri.NegozioID = Negozio.ID
					WHERE Negozio_has_Quadri.QuadroID = ? AND
						Negozio_has_Quadri.NegozioID = ?
			";
			$type = 'ii';	
		}
		else
		{
			$qry = "
					SELECT
						Quadri.ID,
						Nome,
						Tipologia,
						Autore,
						Data,
						Dimensione,
						Tecnica,
						Corrente,
						Quadri.Descrizione,
						Immagine,
						Prezzo,
						Qty,
						NomeNegozio
					FROM Negozio_has_Quadri
					JOIN Quadri ON Negozio_has_Quadri.QuadroID = Quadri.ID
					JOIN Negozio ON Negozio_has_Quadri.NegozioID = Negozio.ID
					WHERE Negozio_has_Quadri.QuadroID = ? AND
						Negozio.NomeNegozio = ?
			";
			$type = 'is';
		}
		
		$stmt->prepare($qry);
		
		$stmt->bind_param($type, $work_id, $negozio);
		
		if(!$stmt->execute())
			return $toRet;
		
		$stmt->store_result();
		
		if($stmt->num_rows <= 0)
		{
			$qry = "
					SELECT
						ID,
						Nome,
						Tipologia,
						Autore,
						Data,
						Dimensione,
						Tecnica,
						Corrente,
						Descrizione,
						Immagine
					FROM Quadri
					WHERE ID = ?
			";
			
			$stmt->prepare($qry);
			
			$stmt->bind_param('i', $work_id);
			
			if(!$stmt->execute())
				return $toRet;
			
			$stmt->bind_result(
					$res_id,
					$res_nome,
					$res_tipologia,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine
			);
			
			$stmt->fetch();
			
			$paint = new Paint();
				
			$paint->setId($res_id);
			$paint->setNome($res_nome);
			$paint->setTipologia($res_tipologia);
			$paint->setAutore($res_autore);
			$paint->setData($res_data);
			$paint->setDimensione($res_dimensione);
			$paint->setTecnica($res_tecnica);
			$paint->setCorrente($res_corrente);
			$paint->setDescrizione($res_descrizione);
			$paint->setImmagine($res_immagine);
		}
		else 
		{
			$stmt->bind_result(
					$res_id,
					$res_nome,
					$res_tipologia,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine,
					$res_prezzo,
					$res_qty,
					$res_nomenegozio
			);
			
			$stmt->fetch();
			
			$paint = new Paint();
				
			$paint->setId($res_id);
			$paint->setNome($res_nome);
			$paint->setTipologia($res_tipologia);
			$paint->setAutore($res_autore);
			$paint->setData($res_data);
			$paint->setDimensione($res_dimensione);
			$paint->setTecnica($res_tecnica);
			$paint->setCorrente($res_corrente);
			$paint->setDescrizione($res_descrizione);
			$paint->setImmagine($res_immagine);
			$paint->setPrezzo($res_prezzo);
			$paint->setQty($res_qty);
			$paint->setNegozio($res_nomenegozio);
		}
		
		
			
		return $paint;
	}
	
	public static function &loadWorkFromFilter($filter)
	{
		
		if(Settings::debug)
			echo $filter['Nome'];
		
		if(isset($filter['Nome']))
			$nome = '%'.$filter['Nome'].'%';
		else 
			$nome = '%%';
		if(isset($filter['Autore']))
			$autore = '%'.$filter['Autore'].'%';
		else 
			$autore = '%%';
		if(isset($filter['Data']))
			$data = '%'.$filter['Data'].'%';
		else 
			$data = '%%';
		if(isset($filter['Dimensione']))
			$dimensione = '%'.$filter['Dimensione'].'%';
		else 
			$dimensione = '%%';
		if(isset($filter['Tecnica']))
			$tecnica = '%'.$filter['Tecnica'].'%';
		else 
			$tecnica = '%%';
		if(isset($filter['Corrente']))
			$corrente = '%'.$filter['Corrente'].'%';
		else 
			$corrente = '%%';
		
		$toRet = array();
		
		
		$stmt = DB::istance()->stmt_init();
	
		$qry = "
				SELECT 
					`ID` , 
					`Nome` , 
					`Autore` , 
					`Data` , 
					`Dimensione` , 
					`Tecnica` , 
					`Corrente` , 
					`Descrizione` , 
					`Immagine` , 
					`Tipologia` , 
					SUM( Qty ) , 
					MIN( Prezzo ) , 
					MAX( Prezzo )
				FROM `Quadri`
				JOIN Negozio_has_Quadri ON Negozio_has_Quadri.QuadroID = Quadri.ID
				WHERE 
					Nome LIKE ? AND
					Autore LIKE ? AND
					Data LIKE ? AND
					Dimensione LIKE ? AND
					Tecnica LIKE ? AND
					Corrente LIKE ?
				GROUP BY ID
		";	
		
		$stmt->prepare($qry);
	
		$stmt->bind_param('ssssss', $nome, $autore, $data, $dimensione, $tecnica, $corrente);
	
		if(!$stmt->execute())
			return $toRet;
	
		$stmt->store_result();
		
		if(Settings::debug)
			echo "risultati: $stmt->num_rows";
			
		if($stmt->num_rows > 0)
		{
			$stmt->bind_result(
					$res_id,
					$res_nome,
					$res_autore,
					$res_data,
					$res_dimensione,
					$res_tecnica,
					$res_corrente,
					$res_descrizione,
					$res_immagine,
					$res_tipologia,
					$res_qty,
					$res_prezzo_min,
					$res_prezzo_max
			);
			
			while($stmt->fetch())
			{
				if($res_qty > 0)
				{
					$paint = new Paint();
					
					$paint->setId($res_id);
					$paint->setNome($res_nome);
					$paint->setTipologia($res_tipologia);
					$paint->setAutore($res_autore);
					$paint->setData($res_data);
					$paint->setDimensione($res_dimensione);
					$paint->setTecnica($res_tecnica);
					$paint->setCorrente($res_corrente);
					$paint->setDescrizione($res_descrizione);
					$paint->setImmagine($res_immagine);
					$paint->setQty($res_qty);
					$paint->setPrezzoMin($res_prezzo_min);
					$paint->setPrezzoMax($res_prezzo_max);
					
					$toRet[] = $paint;
				}
			}
		}
		
		return $toRet;
	}
	
	public static function loadSuggestion($word, $field)
	{
		$word = $word."%";
		$toRet = array();
		
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				SELECT $field
				FROM Quadri
				JOIN Negozio_has_Quadri ON ID = QuadroID
				WHERE 
					$field LIKE ? AND
					Qty > 0
				GROUP BY $field
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('s', $word);
		
		if(!$stmt->execute())
			return false;
		
		$stmt->bind_result($res_nome);
		
		$stmt->store_result();
		
		for ($i = 0; $i < $stmt->num_rows; $i++)
		{
			$stmt->fetch();
		
			$toRet["nome$i"] = $res_nome;
		}
		
		return $toRet;
	}
	
	public static function deleteWorkStoreFromId($id_work, $id_negozio)
	{
		$stmt = DB::istance()->stmt_init();
		
		$qry = "
				DELETE 
				FROM Negozio_has_Quadri
				WHERE
					QuadroID = ? AND
					NegozioID = ?
		";
		
		$stmt->prepare($qry);
		
		$stmt->bind_param('ii', $id_work, $id_negozio);
		
		if(!$stmt->execute())
			return false;
		
		return true; 
	}
}

?>