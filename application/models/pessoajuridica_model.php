<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL PESSOAJURIDICA
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto PessoaJuridica.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class PessoaJuridica_model extends CI_Model {	
	
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
        return $this->db->count_all("pessoajuridica");
    }
	
	/**
	 * Insere um pessoa fisica no banco de dados
	 */		
	public function inserirPessoaJuridica($pessoajuridica){
		
		// O parâmetro da função deve ser um objeto do tipo 'PessoaJuridica'
		if($pessoajuridica instanceof PessoaJuridica){
			$this->db->trans_start();
			
			$dados = array ('id'		=> $pessoajuridica->getIdCliente(),
							'nome'		=> $pessoajuridica->getNome(),
							'telefone'	=> $pessoajuridica->getTelefone(),
							'email'		=> $pessoajuridica->getEmail());
			$this->db->insert('cliente', $dados);
			if($pessoajuridica->getIdCliente()==NULL)
				$id = $this->db->insert_id();
			else
				$id =$pessoajuridica->getIdCliente();
			
			// Insere o administrador
			$dados = array ('idCliente'		 	=> $id,
							'CNPJ'				=> $pessoajuridica->getCNPJ(),
							'razaoSocial'		=> $pessoajuridica->getRazaoSocial(),
							'representante'		=> $pessoajuridica->getRepresentante());
			$this->db->insert('pessoajuridica', $dados);
			
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
	public function editarPessoaJuridica($pessoajuridica){	

		// O parâmetro da função deve ser um objeto do tipo 'PessoaJuridica'
		if($pessoajuridica instanceof PessoaJuridica){
			$this->db->trans_start();
			
			$dados = array ('id'		=> $pessoajuridica->getIdCliente(),
							'nome'		=> $pessoajuridica->getNome(),
							'telefone'	=> $pessoajuridica->getTelefone(),
							'email'		=> $pessoajuridica->getEmail());
			
			$this->db->where('id', $pessoajuridica->getIdCliente());
			
			$this->db->update('cliente', $dados);
			
			// Insere a pessoa fisica
			$dados = array ('idCliente'		 	=> $pessoajuridica->getIdCliente(),
							'CNPJ'				=> $pessoajuridica->getCNPJ(),
							'razaoSocial'		=> $pessoajuridica->getRazaoSocial(),
							'representante'		=> $pessoajuridica->getRepresentante());		
		
			// Pesquisa se existe pessoa fisica no banco de dados
			$this->db->where('idCliente', $pessoajuridica->getIdCliente());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('pessoajuridica', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			//$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}	
	}
	
	/** 
	*  Lista todos os administradores retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarPessoasJuridicas($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT p.idCliente, p.CNPJ, p.razaoSocial, p.representante, c.nome, c.telefone, c.email from pessoajuridica p 
								   JOIN cliente c ON p.idCliente = c.id;');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$pessoasjuridicas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $pessoasjuridicas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$pessoasjuridicas[] = new PessoaJuridica(	$row->idCliente,
															$row->CNPJ,
															$row->razaoSocial,
															$row->representante,
															$row->nome,
															$row->telefone,
															$row->email);
			}

			// Retorna o array com todos os administradores encontrados
			return $pessoasjuridicas;
		}
		return NULL;
	}
	
	public function listarPessoasJuridicasByFaturamento($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		
		$query = $this->db->query('SELECT p.idCliente, p.CNPJ, p.razaoSocial, p.representante, c.nome, c.telefone, c.email, sum(a.valorTotal) as faturamento from aluguel as a JOIN reserva as r ON
							r.idReserva = a.idReserva RIGHT JOIN cliente c ON r.idCliente = c.id JOIN pessoajuridica p ON p.idCliente = c.id GROUP BY
							p.idCliente ORDER BY faturamento DESC');
		
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$pessoasjuridicas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $pessoasjuridicas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$pessoasjuridicas[] = array(new PessoaJuridica(	$row->idCliente,
															$row->CNPJ,
															$row->razaoSocial,
															$row->representante,
															$row->nome,
															$row->telefone,
															$row->email),
															$row->faturamento);
			}

			// Retorna o array com todos os administradores encontrados
			return $pessoasjuridicas;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getPessoaJuridica($idCliente) {

		$this->db->trans_start();
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->query('SELECT p.idCliente, p.CNPJ, p.razaoSocial, p.representante, c.nome, c.telefone, c.email from pessoajuridica p 
								   JOIN cliente c ON p.idCliente = c.id WHERE id="'.$idCliente.'";');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new PessoaJuridica(	$row->idCliente,
									$row->CNPJ,
									$row->razaoSocial,
									$row->representante,
									$row->nome,
									$row->telefone,
									$row->email);
  	}
	
	public function getPessoaJuridicaByCNPJ($cnpj) {

		$this->db->trans_start();
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->query('SELECT p.idCliente, p.CNPJ, p.razaoSocial, p.representante, c.nome, c.telefone, c.email from pessoajuridica p 
								   JOIN cliente c ON p.idCliente = c.id WHERE p.CNPJ="'.$cnpj.'";');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new PessoaJuridica(	$row->idCliente,
									$row->CNPJ,
									$row->razaoSocial,
									$row->representante,
									$row->nome,
									$row->telefone,
									$row->email);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('pessoajuridica'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerPessoaJuridica($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idCliente',$id);
		
		$query = $this->db->delete('pessoajuridica'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file pessoajuridica_model.php */
/* Location: ./application/models/pessoajuridica_model.php */