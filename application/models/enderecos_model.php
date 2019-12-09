<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL ENDERECOS
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto Enderecos.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Enderecos_model extends CI_Model {	
	
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
        return $this->db->count_all("enderecos");
    }
	
	/**
	 * Insere um pessoa fisica no banco de dados
	 */		
	public function inserirEnderecos($enderecos){
		
		// O parâmetro da função deve ser um objeto do tipo 'Enderecos'
		if($enderecos instanceof Enderecos){
			$this->db->trans_start();
			
			
			$dados = array ('idEndereco'		 	=> $enderecos->getIdEndereco(),
							'CEP'				=> $enderecos->getCEP(),
							'estado'		=> $enderecos->getEstado(),
							'cidade'		=> $enderecos->getCidade(),
							'bairro'		=> $enderecos->getBairro(),
							'rua'		=> $enderecos->getRua(),
							'numero'		=> $enderecos->getNumero(),
							'complemento' 	=> $enderecos->getComplemento(),
							'ehPrincipal'	=> $enderecos->getEhPrincipal(),
							'idCliente'	=> $enderecos->getIdCliente());
			$this->db->insert('enderecos', $dados);
			$id=$this->db->insert_id();
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			//$this->db->close();
			
			if($this->db->trans_status()) 
				return $id;
			return FALSE;
		}
	}
	
	/**
	 * Edita um administrador no banco de dados
	 */
	public function editarEnderecos($enderecos){	

		// O parâmetro da função deve ser um objeto do tipo 'Enderecos'
		if($enderecos instanceof Enderecos){
			$this->db->trans_start();
			
			// Insere a pessoa fisica
			$dados = array ('idEndereco'		 	=> $enderecos->getIdEndereco(),
							'CEP'				=> $enderecos->getCEP(),
							'estado'		=> $enderecos->getEstado(),
							'cidade'		=> $enderecos->getCidade(),
							'bairro'		=> $enderecos->getBairro(),
							'rua'		=> $enderecos->getRua(),
							'numero'		=> $enderecos->getNumero(),
							'complemento' 	=> $enderecos->getComplemento(),
							'ehPrincipal'	=> $enderecos->getEhPrincipal(),
							'idCliente'	=> $enderecos->getIdCliente());		
		
			// Pesquisa se existe pessoa fisica no banco de dados
			$this->db->where('idEndereco', $enderecos->getIdEndereco());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('enderecos', $dados);
			
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
	public function listarEnderecos($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, bairro ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('enderecos');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$enderecoss = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $enderecoss
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$enderecoss[] = new Enderecos(	$row->idEndereco,
														$row->CEP,
														$row->estado,
														$row->cidade,
														$row->bairro,
														$row->rua,
														$row->numero,
														$row->complemento,
														$row->ehPrincipal,
														$row->idCliente);
			}

			// Retorna o array com todos os administradores encontrados
			return $enderecoss;
		}
		return NULL;
	}
	
	public function listarEnderecosByCliente($idCliente, $limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, bairro ASC');
		$this->db->limit($limit, $start);
		$this->db->where('idCliente',$idCliente);
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('enderecos');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$enderecoss = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $enderecoss
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$enderecoss[] = new Enderecos(	$row->idEndereco,
														$row->CEP,
														$row->estado,
														$row->cidade,
														$row->bairro,
														$row->rua,
														$row->numero,
														$row->complemento,
														$row->ehPrincipal,
														$row->idCliente);
			}

			// Retorna o array com todos os administradores encontrados
			return $enderecoss;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getEnderecos($idEnderecos) {

		$this->db->trans_start();
		$this->db->where('idEndereco',$idEnderecos);
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('enderecos'); 
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new Enderecos(	$row->idEndereco,
								$row->CEP,
								$row->estado,
								$row->cidade,
								$row->bairro,
								$row->rua,
								$row->numero,
								$row->complemento,
								$row->ehPrincipal,
								$row->idCliente);
  	}
	
	public function getEnderecoPrincipal($idCliente) {

		$this->db->trans_start();
		$this->db->where('idCliente',$idCliente);
		$this->db->where('ehPrincipal',1);
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('enderecos'); 
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new Enderecos(	$row->idEndereco,
								$row->CEP,
								$row->estado,
								$row->cidade,
								$row->bairro,
								$row->rua,
								$row->numero,
								$row->complemento,
								$row->ehPrincipal,
								$row->idCliente);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('enderecos'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerEndereco($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idEndereco',$id);
		
		$query = $this->db->delete('enderecos'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file enderecos_model.php */
/* Location: ./application/models/enderecos_model.php */