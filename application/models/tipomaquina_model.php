<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL TIPOMAQUINA
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto TipoMaquina.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class TipoMaquina_model extends CI_Model {	
	
	/**
	 * Construtor
	 */
	public function __construct()  {
    	parent::__construct();
	}	
	
	/**
	 * Retorna a valorAluguel de linhas na tabela
	 */	
    public function record_count() {
        return $this->db->count_all("tipomaquina");
    }
	
	/**
	 * Insere um tipomaquina no banco de dados
	 */		
	public function inserirTipoMaquina($tipomaquina){
		
		// O parâmetro da função deve ser um objeto do tipo 'TipoMaquina'
		if($tipomaquina instanceof TipoMaquina){
			$this->db->trans_start();
			
			// Insere o tipomaquina
			$dados = array ('idTipo' 			=> $tipomaquina->getIdTipo(),
							'valorAluguel' 			=> $tipomaquina->getValorAluguel(),
							'descricao'			=> $tipomaquina->getDescricao(),
							'ramo'			=> $tipomaquina->getRamo());			
			$this->db->insert('tipomaquina', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}
	}
	
	/**
	 * Edita um tipomaquina no banco de dados
	 */
	public function editarTipoMaquina($tipomaquina) {	

		// O parâmetro da função deve ser um objeto do tipo 'TipoMaquina'
		if($tipomaquina instanceof TipoMaquina){
			$this->db->trans_start();
			
			// Insere o tipomaquina
			$dados = array ('idTipo' 			=> $tipomaquina->getIdTipo(),
							'valorAluguel' 			=> $tipomaquina->getValorAluguel(),
							'descricao'			=> $tipomaquina->getDescricao(),
							'ramo'			=> $tipomaquina->getRamo());		
		
			// Pesquisa se existe tipomaquina no banco de dados
			$this->db->where('idTipo', $tipomaquina->getIdTipo());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('tipomaquina', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}	
	}
	
	
	/** 
	*  Lista todos os tipomaquina retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarTipoMaquinas($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de tipomaquina cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("tipomaquina");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('tipomaquina');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$tipomaquinas = array();
		
		// Verifica se encontrou algum tipomaquina na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $tipomaquina
			foreach ($query->result() as $row) {
				
				$tipomaquinas[] = new TipoMaquina(	$row->idTipo,
													$row->valorAluguel,
													$row->descricao,
													$row->ramo);
			
			}

			// Retorna o array com todos os tipomaquina encontrados
			return $tipomaquinas;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do tipomaquina baseado no código recebido como parâmetro.
	*/
	public function getTipoMaquina($idTipo) {

		$this->db->trans_start();
    	
    	// Pesquisa se existe tipomaquina no banco de dados
    	$this->db->where('idTipo', $idTipo);
    	
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('tipomaquina');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum tipomaquina, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este tipomaquina
		$row = $query->row();
		
		// Retorna o tipomaquina requisitado
		return new TipoMaquina(	$row->idTipo,
								$row->valorAluguel,
								$row->descricao,
								$row->ramo);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('tipomaquina'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerTipoMaquina($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idTipo',$id);
		
		$query = $this->db->delete('tipomaquina'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file tipomaquina_model.php */
/* Location: ./application/models/tipomaquina_model.php */