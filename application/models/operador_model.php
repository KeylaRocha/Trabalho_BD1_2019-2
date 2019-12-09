<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL OPERADOR
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto Operador.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Operador_model extends CI_Model {	
	
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
        return $this->db->count_all("operador");
    }
	
	/**
	 * Insere um operador no banco de dados
	 */		
	public function inserirOperador($operador){
		
		// O parâmetro da função deve ser um objeto do tipo 'Operador'
		if($operador instanceof Operador){
			$this->db->trans_start();
			
			// Insere o operador
			$dados = array ('idOperador' 	=> $operador->getIdOperador(),
							'nome' 			=> $operador->getNome(),
							'celular' 			=> $operador->getCelular(),
							'valorHora' 			=> $operador->getValorHora());			
			$this->db->insert('operador', $dados);
			$id = $this->db->insert_id();
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			//$this->db->close();
			
			if($this->db->trans_status()) 
				return $id;
			return FALSE;
		}
	}
	
	/**
	 * Edita um operador no banco de dados
	 */
	public function editarOperador($operador) {	

		// O parâmetro da função deve ser um objeto do tipo 'Operador'
		if($operador instanceof Operador){
			$this->db->trans_start();
			
			// Insere o operador
			$dados = array ('idOperador' 	=> $operador->getIdOperador(),
							'nome' 			=> $operador->getNome(),
							'celular' 			=> $operador->getCelular(),
							'valorHora' 			=> $operador->getValorHora());		
		
			// Pesquisa se existe operador no banco de dados
			$this->db->where('idOperador', $operador->getIdOperador());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('operador', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}	
	}
	
	
	/** 
	*  Lista todos os operador retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarOperadores($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de operador cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("operador");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('operador');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$operadores = array();
		
		// Verifica se encontrou algum operador na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $operador
			foreach ($query->result() as $row) {
				
				$operadores[] = new Operador(	$row->idOperador,
												$row->nome,
												$row->celular,
												$row->valorHora);
			
			}

			// Retorna o array com todos os operador encontrados
			return $operadores;
		}
		return NULL;
	}
	
	public function listarOperadoresMaisOciososByTipo($idTipo, $limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de operador cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("operador");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('numservicos');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT o.*, ot.idTipo, count(a.idAluguel) as numservicos FROM operatipo as ot JOIN operador as o 
					ON ot.idOperador=o.idOperador LEFT JOIN aluguel as a ON a.idOperador = o.idOperador WHERE ot.idTipo='.$idTipo.' 
					GROUP BY o.idOperador ORDER BY numservicos ASC');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$operadores = array();
		
		// Verifica se encontrou algum operador na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $operador
			foreach ($query->result() as $row) {
				
				$operadores[] = array(new Operador(	$row->idOperador,
												$row->nome,
												$row->celular,
												$row->valorHora),$row->numservicos,$row->idTipo);
			
			}

			// Retorna o array com todos os operador encontrados
			return $operadores;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do operador baseado no código recebido como parâmetro.
	*/
	public function getOperador($idOperador) {

		$this->db->trans_start();
    	
    	// Pesquisa se existe operador no banco de dados
    	$this->db->where('idOperador', $idOperador);
    	
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('operador');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum operador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este operador
		$row = $query->row();
		
		// Retorna o operador requisitado
		return new Operador(	$row->idOperador,
								$row->nome,
								$row->celular,
								$row->valorHora);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('operador'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerOperador($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idOperador',$id);
		
		$query = $this->db->delete('operador'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file operador_model.php */
/* Location: ./application/models/operador_model.php */