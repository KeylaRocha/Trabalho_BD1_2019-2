<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL RESERVATIPO
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto ReservaTipo.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class ReservaTipo_model extends CI_Model {	
	
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
        return $this->db->count_all("reservatipo");
    }
	
	/**
	 * Insere um reservatipo no banco de dados
	 */		
	public function inserirReservaTipo($reservatipo){
		
		// O parâmetro da função deve ser um objeto do tipo 'ReservaTipo'
		if($reservatipo instanceof ReservaTipo){
			$this->db->trans_start();
			
			// Insere o reservatipo
			$dados = array ('idReserva' 	=> $reservatipo->getIdReserva(),
							'idTipo' 			=> $reservatipo->getIdTipo(),
							'quantidade' 			=> $reservatipo->getQuantidade());			
			$this->db->insert('reservatipo', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}
	}
	
	/**
	 * Edita um reservatipo no banco de dados
	 */
	public function editarReservaTipo($reservatipo, $idTipo=NULL) {	

		// O parâmetro da função deve ser um objeto do tipo 'ReservaTipo'
		if($reservatipo instanceof ReservaTipo){
			$this->db->trans_start();
			
			// Insere o reservatipo
			$dados = array ('idReserva' 	=> $reservatipo->getIdReserva(),
							'idTipo' 			=> $reservatipo->getIdTipo(),
							'quantidade' 			=> $reservatipo->getQuantidade());		
		
			// Pesquisa se existe reservatipo no banco de dados
			$this->db->where('idReserva', $reservatipo->getIdReserva());
			if($idTipo==NULL)
				$this->db->where('idTipo', $reservatipo->getIdTipo());
			else
				$this->db->where('idTipo', $idTipo);
			
			// Atualiza a alteração no banco de dados
			$this->db->update('reservatipo', $dados);
			
			// Finaliza a transação e fecha a conexão
			$this->db->trans_complete();
			$this->db->close();
			
			if($this->db->trans_status()) 
				return TRUE;
			return FALSE;
		}	
	}
	
	
	/** 
	*  Lista todos os reservatipo retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarReservaTipos($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de reservatipo cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->db->count_all("reservatipo");
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		//$this->db->order_by('status ASC, nome ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('reservatipo');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$reservatipos = array();
		
		// Verifica se encontrou algum reservatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservatipo
			foreach ($query->result() as $row) {
				
				$reservatipos[] = new ReservaTipo(	$row->idReserva,
														$row->idTipo,
														$row->quantidade);
			
			}

			// Retorna o array com todos os reservatipo encontrados
			return $reservatipos;
		}
		return NULL;
	}
	
	public function getReservaTiposByReserva($idReserva) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de reservatipo cadastrados no banco de dados
			
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idReserva', $idReserva);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('reservatipo');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$reservatipos = array();
		
		// Verifica se encontrou algum reservatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservatipo
			foreach ($query->result() as $row) {
				
				$reservatipos[] = new ReservaTipo(	$row->idReserva,
														$row->idTipo,
														$row->quantidade);
			
			}

			// Retorna o array com todos os reservatipo encontrados
			return $reservatipos;
		}
		return NULL;
	}
	
	public function getReservaTiposByTipo($idTipo) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de reservatipo cadastrados no banco de dados
			
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idTipo', $idTipo);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('reservatipo');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$reservatipos = array();
		
		// Verifica se encontrou algum reservatipo na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservatipo
			foreach ($query->result() as $row) {
				
				$reservatipos[] = new ReservaTipo(	$row->idReserva,
														$row->idTipo,
														$row->quantidade);
			
			}

			// Retorna o array com todos os reservatipo encontrados
			return $reservatipos;
		}
		return NULL;
	}
	
	/** 
	*  Obtém todos os dados do reservatipo baseado no código recebido como parâmetro.
	*/
	public function getReservaTipo($idReserva,$idTipo) {

		$this->db->trans_start();
    	
    	// Pesquisa se existe reservatipo no banco de dados
    	$this->db->where('idReserva', $idReserva);
    	$this->db->where('idTipo', $idTipo);
    	
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$query = $this->db->get('reservatipo');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum reservatipo, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este reservatipo
		$row = $query->row();
		
		// Retorna o reservatipo requisitado
		return new ReservaTipo(	$row->idReserva,
									$row->idTipo,
									$row->quantidade);
  	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('reservatipo'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerReservaTipo($idR,$idT) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idReserva',$idR);
		$this->db->where('idTipo',$idT);
		
		$query = $this->db->delete('reservatipo'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
	
}

/* End of file reservatipo_model.php */
/* Location: ./application/models/reservatipo_model.php */