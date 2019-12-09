<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL MANUTENCAO
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto Manutencao.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Manutencao_model extends CI_Model {	
	
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
        return $this->db->count_all("manutencao");
    }
	
	/**
	 * Insere um pessoa fisica no banco de dados
	 */		
	public function inserirManutencao($manutencao){
		
		// O parâmetro da função deve ser um objeto do tipo 'Manutencao'
		if($manutencao instanceof Manutencao){
			$this->db->trans_start();
			
			
			$dados = array ('idManutencao'		 	=> $manutencao->getIdManutencao(),
							'dataEntrada'				=> $manutencao->getDataEntrada(),
							'dataSaida'		=> $manutencao->getDataSaida(),
							'custo'		=> $manutencao->getCusto(),
							'idMaquina'		=> $manutencao->getIdMaquina());
			$this->db->insert('manutencao', $dados);
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
	 * Edita um administrador no banco de dados
	 */
	public function editarManutencao($manutencao){	

		// O parâmetro da função deve ser um objeto do tipo 'Manutencao'
		if($manutencao instanceof Manutencao){
			$this->db->trans_start();
			
			// Insere a pessoa fisica
			$dados = array ('idManutencao'		 	=> $manutencao->getIdManutencao(),
							'dataEntrada'				=> $manutencao->getDataEntrada(),
							'dataSaida'		=> $manutencao->getDataSaida(),
							'custo'		=> $manutencao->getCusto(),
							'idMaquina'		=> $manutencao->getIdMaquina());		
		
			// Pesquisa se existe pessoa fisica no banco de dados
			$this->db->where('idManutencao', $manutencao->getIdManutencao());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('manutencao', $dados);
			
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
	public function listarManutencoes($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idMaquina ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('manutencao');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$manutencoes = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $manutencoes
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$manutencoes[] = new Manutencao(	$row->idManutencao,
															$row->dataEntrada,
															$row->dataSaida,
															$row->custo,
															$row->idMaquina);
			}

			// Retorna o array com todos os administradores encontrados
			return $manutencoes;
		}
		return NULL;
	}
	
	public function listarManutencoesCompleta($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idMaquina ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT mt.*, m.*, f.idEndereco, tp.descricao FROM tipomaquina as tp JOIN maquina as m ON m.idTipo =tp.idTipo JOIN filial as f ON f.idFilial = m.idFilial JOIN manutencao as mt ON mt.idMaquina = m.idMaquina ');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$manutencoes = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $manutencoes
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$manutencoes[] = array(new Manutencao(	$row->idManutencao,
															$row->dataEntrada,
															$row->dataSaida,
															$row->custo,
															$row->idMaquina),
										new Maquina(	$row->idMaquina,
														$row->numeroSerie,
														$row->modelo,
														$row->fabricante,
														$row->idFilial,
														$row->idTipo),
													$row->idEndereco,
													$row->descricao);
			}

			// Retorna o array com todos os administradores encontrados
			return $manutencoes;
		}
		return NULL;
	}
	
	public function listarManutencoesByMaquina($idMaquina,$limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, idMaquina ASC');
		$this->db->limit($limit, $start);
		$this->db->where("idMaquina",$idMaquina);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('manutencao');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$manutencoes = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $manutencoes
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$manutencoes[] = new Manutencao(	$row->idManutencao,
															$row->dataEntrada,
															$row->dataSaida,
															$row->custo,
															$row->idMaquina);
			}

			// Retorna o array com todos os administradores encontrados
			return $manutencoes;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getManutencao($idManutencao) {

		$this->db->trans_start();
		$this->db->where('idManutencao',$idManutencao);
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('manutencao'); 
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new Manutencao(	$row->idManutencao,
									$row->dataEntrada,
									$row->dataSaida,
									$row->custo,
									$row->idMaquina);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('manutencao'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerManutencao($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idManutencao',$id);
		
		$query = $this->db->delete('manutencao'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file manutencao_model.php */
/* Location: ./application/models/manutencao_model.php */