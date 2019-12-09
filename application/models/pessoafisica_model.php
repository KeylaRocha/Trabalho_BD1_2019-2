<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL PESSOAFISICA
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto PessoaFisica.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class PessoaFisica_model extends CI_Model {	
	
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
        return $this->db->count_all("pessoafisica");
    }
	
	/**
	 * Insere um pessoa fisica no banco de dados
	 */		
	public function inserirPessoaFisica($pessoafisica){
		
		// O parâmetro da função deve ser um objeto do tipo 'PessoaFisica'
		if($pessoafisica instanceof PessoaFisica){
			$this->db->trans_start();
			
			$dados = array ('id'		=> $pessoafisica->getIdCliente(),
							'nome'		=> $pessoafisica->getNome(),
							'telefone'	=> $pessoafisica->getTelefone(),
							'email'		=> $pessoafisica->getEmail());
			$this->db->insert('cliente', $dados);
			if($pessoafisica->getIdCliente()==NULL)
				$id = $this->db->insert_id();
			else
				$id =$pessoafisica->getIdCliente();
			
			// Insere o administrador
			$dados = array ('idCliente'		 	=> $id,
							'CPF'				=> $pessoafisica->getCPF(),
							'dataNascimento'	=> $pessoafisica->getDataNascimento());
			$this->db->insert('pessoafisica', $dados);
			
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
	public function editarPessoaFisica($pessoafisica){	

		// O parâmetro da função deve ser um objeto do tipo 'PessoaFisica'
		if($pessoafisica instanceof PessoaFisica){
			$this->db->trans_start();
			
			$dados = array ('id'		=> $pessoafisica->getIdCliente(),
							'nome'		=> $pessoafisica->getNome(),
							'telefone'	=> $pessoafisica->getTelefone(),
							'email'		=> $pessoafisica->getEmail());
			
			$this->db->where('id', $pessoafisica->getIdCliente());
			
			$this->db->update('cliente', $dados);
			
			// Insere a pessoa fisica
			$dados = array ('idCliente'		 	=> $pessoafisica->getIdCliente(),
							'CPF'				=> $pessoafisica->getCPF(),
							'dataNascimento'	=> $pessoafisica->getDataNascimento());		
		
			// Pesquisa se existe pessoa fisica no banco de dados
			$this->db->where('idCliente', $pessoafisica->getIdCliente());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('pessoafisica', $dados);
			
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
	public function listarPessoasFisicas($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT p.idCliente, p.CPF, p.dataNascimento, c.nome, c.telefone, c.email from pessoafisica p 
								   JOIN cliente c ON p.idCliente = c.id;');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$pessoasfisicas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $pessoasfisicas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$pessoasfisicas[] = new PessoaFisica(	$row->idCliente,
														$row->CPF,
														$row->dataNascimento,
														$row->nome,
														$row->telefone,
														$row->email);
			}

			// Retorna o array com todos os administradores encontrados
			return $pessoasfisicas;
		}
		return NULL;
	}
	
	public function listarPessoasFisicasByFaturamento($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT p.idCliente, p.CPF, p.dataNascimento, c.nome, c.telefone, c.email, sum(a.valorTotal) as faturamento from aluguel as a JOIN reserva as r ON
									r.idReserva = a.idReserva RIGHT JOIN cliente c ON r.idCliente = c.id JOIN pessoafisica p ON p.idCliente = c.id GROUP BY
									p.idCliente ORDER BY faturamento DESC');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$pessoasfisicas = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $pessoasfisicas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$pessoasfisicas[] = array(new PessoaFisica(	$row->idCliente,
														$row->CPF,
														$row->dataNascimento,
														$row->nome,
														$row->telefone,
														$row->email),
														$row->faturamento);
			}

			// Retorna o array com todos os administradores encontrados
			return $pessoasfisicas;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getPessoaFisica($idCliente) {

		$this->db->trans_start();
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->query('SELECT p.idCliente, p.CPF, p.dataNascimento, c.nome, c.telefone, c.email from pessoafisica p 
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
		return  new PessoaFisica(	$row->idCliente,
									$row->CPF,
									$row->dataNascimento,
									$row->nome,
									$row->telefone,
									$row->email);
  	}
	
	public function getPessoaFisicaByCPF($cpf) {

		$this->db->trans_start();
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->query('SELECT p.idCliente, p.CPF, p.dataNascimento, c.nome, c.telefone, c.email from pessoafisica p 
								   JOIN cliente c ON p.idCliente = c.id WHERE p.CPF="'.$cpf.'";');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new PessoaFisica(	$row->idCliente,
									$row->CPF,
									$row->dataNascimento,
									$row->nome,
									$row->telefone,
									$row->email);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('pessoafisica'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerPessoaFisica($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idCliente',$id);
		
		$query = $this->db->delete('pessoafisica'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file pessoafisica_model.php */
/* Location: ./application/models/pessoafisica_model.php */