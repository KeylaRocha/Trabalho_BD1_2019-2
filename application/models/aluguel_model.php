<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL ALUGUEL
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto Aluguel.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Aluguel_model extends CI_Model {	
	
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
        return $this->db->count_all("aluguel");
    }
	
	/**
	 * Insere um pessoa fisica no banco de dados
	 */		
	public function inserirAluguel($aluguel){
		
		// O parâmetro da função deve ser um objeto do tipo 'Aluguel'
		if($aluguel instanceof Aluguel){
			$this->db->trans_start();
			
			
			$dados = array ('idAluguel'		 	=> $aluguel->getIdAluguel(),
							'dataDevEfetiva'				=> $aluguel->getDataDevEfetiva(),
							'dataRetEfetiva'		=> $aluguel->getDataRetEfetiva(),
							'temSeguro'		=> $aluguel->getTemSeguro(),
							'valorTotal'		=> $aluguel->getValorTotal(),
							'taxa'		=> $aluguel->getTaxa(),
							'idMaquina'		=> $aluguel->getIdMaquina(),
							'idReserva' 	=> $aluguel->getIdReserva(),
							'idManutencao'	=> $aluguel->getIdManutencao(),
							'idOperador'	=> $aluguel->getIdOperador());
			$this->db->insert('aluguel', $dados);
			
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
	public function editarAluguel($aluguel){	

		// O parâmetro da função deve ser um objeto do tipo 'Aluguel'
		if($aluguel instanceof Aluguel){
			$this->db->trans_start();
			
			// Insere a pessoa fisica
			$dados = array ('idAluguel'		 	=> $aluguel->getIdAluguel(),
							'dataDevEfetiva'				=> $aluguel->getDataDevEfetiva(),
							'dataRetEfetiva'		=> $aluguel->getDataRetEfetiva(),
							'temSeguro'		=> $aluguel->getTemSeguro(),
							'valorTotal'		=> $aluguel->getValorTotal(),
							'taxa'		=> $aluguel->getTaxa(),
							'idMaquina'		=> $aluguel->getIdMaquina(),
							'idReserva' 	=> $aluguel->getIdReserva(),
							'idManutencao'	=> $aluguel->getIdManutencao(),
							'idOperador'	=> $aluguel->getIdOperador());		
		
			// Pesquisa se existe pessoa fisica no banco de dados
			$this->db->where('idAluguel', $aluguel->getIdAluguel());
			
			// Atualiza a alteração no banco de dados
			$this->db->update('aluguel', $dados);
			
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
	public function listarAlugueis($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, valorTotal ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('aluguel');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$aluguels = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $aluguels
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$aluguels[] = new Aluguel(	$row->idAluguel,
														$row->dataDevEfetiva,
														$row->dataRetEfetiva,
														$row->temSeguro,
														$row->valorTotal,
														$row->taxa,
														$row->idMaquina,
														$row->idReserva,
														$row->idManutencao,
														$row->idOperador);
			}

			// Retorna o array com todos os administradores encontrados
			return $aluguels;
		}
		return NULL;
	}
	
	public function listarAlugueisByCliente($idCliente, $limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, valorTotal ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT a.*, r.idCliente FROM maquina as m JOIN aluguel as a ON a.idMaquina=m.idMaquina JOIN reserva as r ON r.idReserva=a.idReserva WHERE r.idCliente='.$idCliente);
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$aluguels = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $aluguels
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$aluguels[] = new Aluguel(	$row->idAluguel,
														$row->dataDevEfetiva,
														$row->dataRetEfetiva,
														$row->temSeguro,
														$row->valorTotal,
														$row->taxa,
														$row->idMaquina,
														$row->idReserva,
														$row->idManutencao,
														$row->idOperador);
			}

			// Retorna o array com todos os administradores encontrados
			return $aluguels;
		}
		return NULL;
	}
	
	public function listarAlugueisByClienteADevolver($idCliente, $limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, valorTotal ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT a.*, r.idCliente, m.* FROM maquina as m JOIN aluguel as a ON a.idMaquina=m.idMaquina JOIN reserva as r 
		ON r.idReserva=a.idReserva WHERE a.dataDevEfetiva IS NULL AND r.idCliente='.$idCliente);
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$aluguels = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $aluguels
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$aluguels[] = array(new Aluguel(	$row->idAluguel,
														$row->dataDevEfetiva,
														$row->dataRetEfetiva,
														$row->temSeguro,
														$row->valorTotal,
														$row->taxa,
														$row->idMaquina,
														$row->idReserva,
														$row->idManutencao,
														$row->idOperador),
									new Maquina(	$row->idMaquina,
													$row->numeroSerie,
													$row->modelo,
													$row->fabricante,
													$row->idFilial,
													$row->idTipo));
			}

			// Retorna o array com todos os administradores encontrados
			return $aluguels;
		}
		return NULL;
	}
	
	public function listarAlugueisADevolver($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, valorTotal ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->query('SELECT a.*, r.idCliente, r.dataDevolucao, m.* FROM maquina as m JOIN aluguel as a ON a.idMaquina=m.idMaquina JOIN reserva as r 
		ON r.idReserva=a.idReserva WHERE a.dataDevEfetiva IS NULL');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$aluguels = array();
		
		// Verifica se encontrou alguma pessoa fisica na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $aluguels
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$aluguels[] = array(new Aluguel(	$row->idAluguel,
														$row->dataDevEfetiva,
														$row->dataRetEfetiva,
														$row->temSeguro,
														$row->valorTotal,
														$row->taxa,
														$row->idMaquina,
														$row->idReserva,
														$row->idManutencao,
														$row->idOperador),
														$row->dataDevolucao,
														$row->idCliente,
									new Maquina(	$row->idMaquina,
													$row->numeroSerie,
													$row->modelo,
													$row->fabricante,
													$row->idFilial,
													$row->idTipo));
			}

			// Retorna o array com todos os administradores encontrados
			return $aluguels;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getAluguel($idAluguel) {

		$this->db->trans_start();
		$this->db->where('idAluguel',$idAluguel);
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('aluguel'); 
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new Aluguel(	$row->idAluguel,
								$row->dataDevEfetiva,
								$row->dataRetEfetiva,
								$row->temSeguro,
								$row->valorTotal,
								$row->taxa,
								$row->idMaquina,
								$row->idReserva,
								$row->idManutencao,
								$row->idOperador);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('aluguel'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerAluguel($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idAluguel',$id);
		
		$query = $this->db->delete('aluguel'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file aluguel_model.php */
/* Location: ./application/models/aluguel_model.php */