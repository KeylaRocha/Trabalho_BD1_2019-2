<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL OPERATIPO
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto OperaTipo.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class OperaTipo_model extends CI_Model {	
	
	/**
	 * Construtor
	 */
	public function __construct()  {
    	parent::__construct();
	}	
	
	/**
	 * Retorna a idOperador de linhas na tabela
	 */	
    public function record_count() {
        return $this->db->count_all("operatipo");
    }
	
	/**
	 * Insere um operatipo no banco de dados
	 */		
	public function inserirOperaTipo($operatipo){
		
		// O parâmetro da função deve ser um objeto do tipo 'OperaTipo'
		if($operatipo instanceof OperaTipo){
			$this->db->trans_start();
			
			// Insere o operatipo
			$dados = array ('idTipo' 			=> $operatipo->getIdTipo(),
							'idOperador' 			=> $operatipo->getIdOperador());			
			$this->db->insert('operatipo', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			//$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}
	}
	
	/**
	 * Edita um operatipo no banco de dados
	 */
	public function editarOperaTipo($idOperador,$idTipo,$operatipo) {	

		// O parâmetro da função deve ser um objeto do tipo 'OperaTipo'
		if($operatipo instanceof OperaTipo){
			$this->db->trans_start();
			
			// Insere o operatipo
			$dados = array ('idTipo' 			=> $operatipo->getIdTipo(),
							'idOperador' 			=> $operatipo->getIdOperador());		
		
			// Pesquisa se existe operatipo no banco de dados
			$this->db->where('idTipo', $idTipo);
			$this->db->where('idOperador', $idOperador);
			
			// Atualiza a alteração no banco de dados
			$this->db->update('operatipo', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}	
	}
	
	
	/** 
	*  Lista todos os operatipo retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarOperaTipos($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de operatipo cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("operatipo");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('operatipo');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$operatipos = array();
		
		// Verifica se encontrou algum operatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $operatipo
			foreach ($query->result() as $row) {
				
				$operatipos[] = new OperaTipo(	$row->idTipo,
													$row->idOperador);
			
			}

			// Retorna o array com todos os operatipo encontrados
			return $operatipos;
		}
		return NULL;
	}
	
	public function listarServicos($limit = 0, $start = 0) {
		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de operatipo cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("operatipo");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT DISTINCT o.idTipo, t.valorAluguel, t.descricao, t.ramo from operatipo as o JOIN tipomaquina as t ON o.idTipo = t.idTipo	');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$operatipos = array();
		
		// Verifica se encontrou algum operatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $operatipo
			foreach ($query->result() as $row) {
				
				$operatipos[] = new TipoMaquina($row->idTipo,
												$row->valorAluguel,
												$row->descricao,
												$row->ramo);												
			
			}

			// Retorna o array com todos os operatipo encontrados
			return $operatipos;
		}
		return NULL;
	}
	
	public function listarServicosByFilial($idFilial, $limit = 0, $start = 0) {
		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de operatipo cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("operatipo");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT o.idTipo, t.valorAluguel, t.descricao, t.ramo from operatipo as o JOIN tipomaquina as t ON o.idTipo = t.idTipo 
								   JOIN maquina m	ON m.idTipo = t.idTipo WHERE m.idFilial='.$idFilial);
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$operatipos = array();
		$idtipos = array();
		
		// Verifica se encontrou algum operatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $operatipo
			foreach ($query->result() as $row) {
				if(!in_array($row->idTipo,$idtipos)){
				$operatipos[] = new TipoMaquina($row->idTipo,
												$row->valorAluguel,
												$row->descricao,
												$row->ramo);												
				$idtipos[] = $row->idTipo;
				}
				
			}

			// Retorna o array com todos os operatipo encontrados
			return $operatipos;
		}
		return NULL;
	}
	
	
	
	/** 
	*  Obtém todos os dados do operatipo baseado no código recebido como parâmetro.
	*/
	public function getOperaTipoByTipo($idTipo) {

		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->where('idTipo',$idTipo);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('operatipo');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$operatipos = array();
		
		// Verifica se encontrou algum operatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $operatipo
			foreach ($query->result() as $row) {
				
				$operatipos[] = new OperaTipo(	$row->idTipo,
													$row->idOperador);
			
			}

			// Retorna o array com todos os operatipo encontrados
			return $operatipos;
		}
		return NULL;

  	}
	
	public function getOperaTipoByOperador($idOperador) {

		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->where('idOperador',$idOperador);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('operatipo');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$operatipos = array();
		
		// Verifica se encontrou algum operatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $operatipo
			foreach ($query->result() as $row) {
				
				$operatipos[] = new OperaTipo(	$row->idTipo,
													$row->idOperador);
			
			}

			// Retorna o array com todos os operatipo encontrados
			return $operatipos;
		}
		return NULL;

  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('operatipo'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerOperaTipo($idT,$idO) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idOperador',$idO);
		$this->db->where('idTipo',$idT);
		
		$query = $this->db->delete('operatipo'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file operatipo_model.php */
/* Location: ./application/models/operatipo_model.php */