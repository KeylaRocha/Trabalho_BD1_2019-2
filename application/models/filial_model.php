<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL FILIAL
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto Filial.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Filial_model extends CI_Model {	
	
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
        return $this->db->count_all("filial");
    }
	
	/**
	 * Insere uma filial no banco de dados
	 */		
	public function inserirFilial($filial){
		
		// O parâmetro da função deve ser um objeto do tipo 'Filial'
		if($filial instanceof Filial){
			$this->db->trans_start();
			
			// Insere o filial
			$dados = array ('idFilial'		 	=> $filial->getIdFilial(),
							'Telefone' 			=> $filial->getTelefone(),
							'idEndereco' 			=> $filial->getIdEndereco());			
			$this->db->insert('filial', $dados);
			
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
	 * Edita um filial no banco de dados
	 */
	public function editarFilial($filial) {	

		// O parâmetro da função deve ser um objeto do tipo 'Filial'
		if($filial instanceof Filial){
			$this->db->trans_start();
			
			// Insere o filial
			$dados = array ('idFilial' 		=> $filial->getIdFilial(),
							'Telefone' 		=> $filial->getTelefone(),
							'idEndereco'	=> $filial->getIdEndereco());		
		
			// Pesquisa se existe filial no banco de dados
			$this->db->where('idFilial', $filial->getIdFilial());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('filial', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}	
	}
	
	
	/** 
	*  Lista todos os filial retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarFiliais($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de filial cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("filial");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('filial');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$filiais = array();
		
		// Verifica se encontrou algum filial na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $filial
			foreach ($query->result() as $row) {
				
				$filiais[] = new Filial($row->idFilial,
										$row->Telefone,
										$row->idEndereco);
			
			}

			// Retorna o array com todos os filial encontrados
			return $filiais;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do filial baseado no código recebido como parâmetro.
	*/
	public function getFilial($idFilial) {

		$this->db->trans_start();
    	
    	// Pesquisa se existe filial no banco de dados
    	$this->db->where('idFilial', $idFilial);
    	
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('filial');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum filial, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este filial
		$row = $query->row();
		
		// Retorna o filial requisitado
		return new Filial(	$row->idFilial,
							$row->Telefone,
							$row->idEndereco);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('filial'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerFilial($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idFilial',$id);
		
		$query = $this->db->delete('filial'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file filial_model.php */
/* Location: ./application/models/filial_model.php */