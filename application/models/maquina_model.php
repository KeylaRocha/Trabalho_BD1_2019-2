<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL MAQUINA	
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto Maquina.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Maquina_model extends CI_Model {	
	
	/**
	 * Construtor
	 */
	public function __construct()  {
    	parent::__construct();
	}	
	
	/**
	 * Retorna a quantidade de linhas na tabela
	 */	
    public function record_count() {
        return $this->db->count_all("maquina");
    }
	
	/**
	 * Insere um pessoa fisica no banco de dados
	 */		
	public function inserirMaquina($maquina){
		
		// O parâmetro da função deve ser um objeto do tipo 'Maquina'
		if($maquina instanceof Maquina){
			$this->db->trans_start();
			
			
			$dados = array ('idMaquina'		 	=> $maquina->getIdMaquina(),
							'numeroSerie'				=> $maquina->getNumeroSerie(),
							'modelo'		=> $maquina->getModelo(),
							'fabricante'		=> $maquina->getFabricante(),
							'idFilial'		=> $maquina->getIdFilial(),
							'idTipo'		=> $maquina->getIdTipo());
			$this->db->insert('maquina', $dados);
			$id = $this->db->insert_id();
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return $id;
			return FALSE;
		}
	}
	
	/**
	 * Edita um administrador no banco de dados
	 */
	public function editarMaquina($maquina){	

		// O parâmetro da função deve ser um objeto do tipo 'Maquina'
		if($maquina instanceof Maquina){
			$this->db->trans_start();
			
			// Insere a pessoa fisica
			$dados = array ('idMaquina'		 	=> $maquina->getIdMaquina(),
							'numeroSerie'				=> $maquina->getNumeroSerie(),
							'modelo'		=> $maquina->getModelo(),
							'fabricante'		=> $maquina->getFabricante(),
							'idFilial'		=> $maquina->getIdFilial(),
							'idTipo'		=> $maquina->getIdTipo());		
		
			// Pesquisa se existe pessoa fisica no banco de dados
			$this->db->where('idMaquina', $maquina->getIdMaquina());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('maquina', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}	
	}
	
	/** 
	*  Lista todos os administradores retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarMaquinas($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idFilial ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('maquina');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$maquinas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $maquinas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$maquinas[] = new Maquina(	$row->idMaquina,
														$row->numeroSerie,
														$row->modelo,
														$row->fabricante,
														$row->idFilial,
														$row->idTipo);
			}

			// Retorna o array com todos os administradores encontrados
			return $maquinas;
		}
		return NULL;
	}
	
	public function listarMaquinasByFilial($idFilial, $limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idFilial ASC');
		$this->db->limit($limit, $start);
		$this->db->where('idFilial',$idFilial);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('maquina');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$maquinas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $maquinas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$maquinas[] = new Maquina(	$row->idMaquina,
														$row->numeroSerie,
														$row->modelo,
														$row->fabricante,
														$row->idFilial,
														$row->idTipo);
			}

			// Retorna o array com todos os administradores encontrados
			return $maquinas;
		}
		return NULL;
	}
	
	public function listarMaquinasByTipo($idTipo, $limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idFilial ASC');
		$this->db->limit($limit, $start);
		$this->db->where('idTipo',$idTipo);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('maquina');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$maquinas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $maquinas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$maquinas[] = new Maquina(	$row->idMaquina,
														$row->numeroSerie,
														$row->modelo,
														$row->fabricante,
														$row->idFilial,
														$row->idTipo);
			}

			// Retorna o array com todos os administradores encontrados
			return $maquinas;
		}
		return NULL;
	}
	
	public function listarMaquinasNovas( $limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idFilial ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT m.*, count(mt.idManutencao) as numManut, f.idEndereco, tp.descricao FROM  filial as f JOIN maquina as m ON m.idFilial = f.idFilial JOIN tipomaquina as tp ON tp.idTipo = m.idTipo LEFT JOIN manutencao as mt ON m.idMaquina = mt.idMaquina GROUP BY m.idMaquina HAVING numManut = 0');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$maquinas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $maquinas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$maquinas[] = array(new Maquina(	$row->idMaquina,
														$row->numeroSerie,
														$row->modelo,
														$row->fabricante,
														$row->idFilial,
														$row->idTipo),
														$row->idEndereco,
														$row->descricao);
			}

			// Retorna o array com todos os administradores encontrados
			return $maquinas;
		}
		return NULL;
	}
	
	public function listarMaquinasDisponiveisByTipoEFilial($idTipo, $idFilial, $limit = 0, $start = 0) {
		
		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idFilial ASC');
		$this->db->limit($limit, $start);
		$this->db->where('idTipo',$idTipo);
		$this->db->where('idFilial',$idFilial);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT m.*, a.dataDevEfetiva, a.dataRetEfetiva, mt.dataSaida, mt.dataEntrada	FROM manutencao as mt RIGHT JOIN 
		maquina as m ON m.idMaquina = mt.idMaquina LEFT JOIN aluguel as a ON a.idMaquina = m.idMaquina WHERE ((a.dataDevEfetiva IS NULL 
		AND a.dataRetEfetiva IS NULL) OR a.dataDevEfetiva<"'.date('Y-m-d').'") AND ((mt.dataSaida IS NULL AND mt.dataEntrada IS NULL) 
		OR mt.dataSaida<"'.date('Y-m-d').'") AND idTipo = '.$idTipo.' AND idFilial='.$idFilial.' ORDER BY a.dataDevEfetiva ASC, mt.dataSaida ASC');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$maquinas = array();
		$ids = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $maquinas
			foreach ($query->result() as $row) {
				if(!in_array($row->idMaquina,$ids)){
				// Se a pessoa fisica não tiver com status 'excluído'
						$maquinas[] = new Maquina(	$row->idMaquina,
														$row->numeroSerie,
														$row->modelo,
														$row->fabricante,
														$row->idFilial,
														$row->idTipo);
						$ids[] = $row->idMaquina;
				}
			}

			// Retorna o array com todos os administradores encontrados
			return $maquinas;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getMaquina($idMaquina) {

		$this->db->trans_start();
		$this->db->where('idMaquina',$idMaquina);
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('maquina'); 
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new Maquina(	$row->idMaquina,
								$row->numeroSerie,
								$row->modelo,
								$row->fabricante,
								$row->idFilial,
								$row->idTipo);
  	}
	
	public function contarMaquinasByTipo($idTipo) {
		
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idTipo',$idTipo);
		$this->db->from('maquina');
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->count_all_results();
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		return $query;
	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('maquina'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerMaquina($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idMaquina',$id);
		
		$query = $this->db->delete('maquina'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file maquina_model.php */
/* Location: ./application/models/maquina_model.php */