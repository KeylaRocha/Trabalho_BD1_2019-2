<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL ADMINISTRADOR
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto Administrador.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Administrador_model extends CI_Model {	
	
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
        return $this->db->count_all("administradores");
    }
	
	/**
	 * Insere um administrador no banco de dados
	 */		
	public function inserirAdministrador($administrador){
		
		// O parâmetro da função deve ser um objeto do tipo 'Administrador'
		if($administrador instanceof Administrador){
			$this->db->trans_start();
			
			// Insere o administrador
			$dados = array ('idAdmin' 	=> $administrador->getIdAdmin(),
							'email' 			=> $administrador->getEmail(),
							'senha' 			=> $administrador->getSenha());			
			$this->db->insert('administradores', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}
	}
	
	/**
	 * Edita um administrador no banco de dados
	 */
	public function editarAdministrador($administrador) {	

		// O parâmetro da função deve ser um objeto do tipo 'Administrador'
		if($administrador instanceof Administrador){
			$this->db->trans_start();
			
			// Insere o administrador
			$dados = array ('idAdmin' 	=> $administrador->getIdAdmin(),
							'email' 			=> $administrador->getEmail(),
							'senha' 			=> $administrador->getSenha());		
		
			// Pesquisa se existe administrador no banco de dados
			$this->db->where('idAdmin', $administrador->getIdAdmin());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('administradores', $dados);
			
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
	public function listarAdministradores($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("administradores");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('administradores');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$administradores = array();
		
		// Verifica se encontrou algum administrador na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $administradores
			foreach ($query->result() as $row) {
				
				$administradores[] = new Administrador(	$row->idAdmin,
														$row->email,
														$row->senha);
			
			}

			// Retorna o array com todos os administradores encontrados
			return $administradores;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getAdministrador($idAdmin) {

		$this->db->trans_start();
    	
    	// Pesquisa se existe administrador no banco de dados
    	$this->db->where('idAdmin', $idAdmin);
    	
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('administradores');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return new Administrador(	$row->idAdmin,
									$row->email,
									$row->senha);
  	}
	
}

/* End of file administrador_model.php */
/* Location: ./application/models/administrador_model.php */