<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * MODEL RESERVA
 *---------------------------------------------------------------
 * 
 * Model que trata as funções relacionadas ao objeto PessoaFisica.
 * Todas as funções que necessitam de acessos ao banco de dados,
 * estão descritas neste arquivo.
 *
 */

class Reserva_model extends CI_Model {	
	
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
        return $this->db->count_all("reserva");
    }
	
	/**
	 * Insere um pessoa fisica no banco de dados
	 */		
	public function inserirReserva($reserva){
		
		// O parâmetro da função deve ser um objeto do tipo 'Reserva'
		if($reserva instanceof Reserva){
			$this->db->trans_start();
			
			$dados = array ('idReserva'		=> $reserva->getIdReserva(),
							'hora'			=> $reserva->getHora(),
							'dataRetirada'	=> $reserva->getDataRetirada(),
							'dataDevolucao' => $reserva->getDataDevolucao(),
							'idCliente'		=> $reserva->getIdCliente(),
							'idEndereco'		=> $reserva->getIdEndereco());
			$this->db->insert('reserva', $dados);
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
	public function editarReserva($reserva){	

		// O parâmetro da função deve ser um objeto do tipo 'PessoaFisica'
		if($reserva instanceof Reserva){
			$this->db->trans_start();
			
			$dados = array ('idReserva'		=> $reserva->getIdReserva(),
							'hora'			=> $reserva->getHora(),
							'dataRetirada'	=> $reserva->getDataRetirada(),
							'dataDevolucao'	=> $reserva->getDataDevolucao(),
							'idCliente'		=> $reserva->getIdCliente(),
							'idEndereco'		=> $reserva->getIdEndereco());
			
			$this->db->where('idReserva', $reserva->getIdReserva());
			
			$this->db->update('reserva', $dados);
			
			
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
	public function listarReservas($limit = 0, $start = 0) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->order_by('dataRetirada ASC, hora ASC, dataDevolucao ASC');
		$this->db->limit($limit, $start);
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('reserva');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$reservas = array();
		
		// Verifica se encontrou alguma reserva na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$reservas[] = new Reserva(	$row->idReserva,
											$row->hora,
											$row->dataRetirada,
											$row->dataDevolucao,
											$row->idCliente,
											$row->idEndereco);
			}

			// Retorna o array com todos os administradores encontrados
			return $reservas;
		}
		return NULL;
	}
	
	
	public function listarReservasByCliente($idCliente, $jaRetiradas=FALSE, $ativas=FALSE) {

		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->order_by('dataRetirada ASC, hora ASC, dataDevolucao ASC');
		$this->db->where('idCliente', $idCliente);
		if($jaRetiradas)
			$this->db->where('dataRetirada<=', date('Y-m-d'));
		if($ativas)
			$this->db->where('dataDevolucao>=', date('Y-m-d'));
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('reserva');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		$this->db->close();
		
		$reservas = array();
		
		// Verifica se encontrou alguma reserva na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$reservas[] = new Reserva(	$row->idReserva,
											$row->hora,
											$row->dataRetirada,
											$row->dataDevolucao,
											$row->idCliente,
											$row->idEndereco);
			}

			// Retorna o array com todos os administradores encontrados
			return $reservas;
		}
		return NULL;
	}
	
	/** 
	*  Lista todos os administradores retornando um array com todos os itens cadastrados no banco de dados.
	*  Se a função for chamada sem parâmetros, considera que o usuário quer listar todos os itens.
	*/
	public function listarReservasAtivasPessoaFisica($cpf=NULL, $limit = 0, $start = 0, $jaRetiradas=FALSE) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		/*$this->db->order_by('dataRetirada ASC, hora ASC, dataDevolucao ASC');
		$this->db->limit($limit, $start);*/
		$extra="";
		$extra2="";
		if($jaRetiradas)
			$extra = 'AND dataRetirada<="'.date('Y-m-d').'"'; //$this->db->where('dataRetirada>=', date('Y-m-d'));
		if($cpf!=NULL)
			$extra2 = 'AND p.CPF = "'.$cpf.'"';
		/*$this->db->where('dataDevolucao>=', date('Y-m-d'));
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('reserva');*/
		$query = $this->db->query('SELECT idReserva, hora, dataRetirada, dataDevolucao, idEndereco, c.*, p.* FROM reserva as r JOIN cliente as c ON c.id = r.idCliente 
								 JOIN pessoafisica as p ON c.id = p.idCliente WHERE dataDevolucao>="'.date('Y-m-d').'" '.$extra.' '.$extra2.'
								 ORDER BY dataRetirada ASC, hora ASC, dataDevolucao ASC LIMIT '.$start.','.$limit);	
		
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$reservas = array();
		
		// Verifica se encontrou alguma reserva na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$reservas[] = array(new Reserva(	$row->idReserva,
											$row->hora,
											$row->dataRetirada,
											$row->dataDevolucao,
											$row->idCliente,
											$row->idEndereco),
									new PessoaFisica(	$row->idCliente,
											$row->CPF,
											$row->dataNascimento,
											$row->nome,
											$row->telefone,
											$row->email));
			}

			// Retorna o array com todos os administradores encontrados
			return $reservas;
		}
		return array();
	}
	
	public function listarReservasAtivasPessoaJuridica($cnpj=NULL, $limit = 0, $start = 0, $jaRetiradas=FALSE) {

		// Caso não seja passado nenhum valor limite como parâmetro, inicia a variável com o número total de administradores cadastrados no banco de dados
		if ($limit == 0) {
			$limit = $this->record_count();
		}
		
		// Inicia a transação
		$this->db->trans_start();
		
		/*$this->db->order_by('dataRetirada ASC, hora ASC, dataDevolucao ASC');
		$this->db->limit($limit, $start);*/
		$extra="";
		$extra2="";
		if($jaRetiradas)
			$extra = 'AND dataRetirada<="'.date('Y-m-d').'"'; //$this->db->where('dataRetirada>=', date('Y-m-d'));
		if($cnpj!=NULL)
			$extra2 = 'AND p.CNPJ = '.$cnpj;
		/*$this->db->where('dataDevolucao>=', date('Y-m-d'));
		
		// Realiza a pesquisa no banco de dados e joga os dados na query	
		$query = $this->db->get('reserva');*/
		$query = $this->db->query('SELECT idReserva, hora, dataRetirada, dataDevolucao, idEndereco, c.*, p.* FROM reserva as r JOIN cliente as c ON c.id = r.idCliente 
								 JOIN pessoajuridica as p ON c.id = p.idCliente WHERE dataDevolucao>="'.date('Y-m-d').'" '.$extra.' '.$extra2.'
								 ORDER BY dataRetirada ASC, hora ASC, dataDevolucao ASC LIMIT '.$start.','.$limit);	
		
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		$reservas = array();
		
		// Verifica se encontrou alguma reserva na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$reservas[] = array(new Reserva(	$row->idReserva,
											$row->hora,
											$row->dataRetirada,
											$row->dataDevolucao,
											$row->idCliente,
											$row->idEndereco),
									new PessoaJuridica(	$row->idCliente,
											$row->CNPJ,
											$row->razaoSocial,
											$row->representante,
											$row->nome,
											$row->telefone,
											$row->email));
			}

			// Retorna o array com todos os administradores encontrados
			return $reservas;
		}
		return array();
	}
	
	/** 
	*  Obtém todos os dados do administrador baseado no código recebido como parâmetro.
	*/
	public function getReserva($idReserva) {

		$this->db->trans_start();
    	// Realiza a pesquisa no banco de dados e joga os dados na query
    	$this->db->where('idReserva', $idReserva);
		
		$query = $this->db->get('reserva');
			
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
    	
    	// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	if ($query->num_rows() == 0)
        	return null; 

    	// Caso encontre o dado, pega a linha que contém este administrador
		$row = $query->row();
		
		// Retorna o administrador requisitado
		return  new Reserva(	$row->idReserva,
								$row->hora,
								$row->dataRetirada,
								$row->dataDevolucao,
								$row->idCliente,
								$row->idEndereco);
  	}
	
	public function contaMaquinasReservadas($dataInicio, $dataFim, $idTipo){
		$this->db->trans_start();
		
		$query = $this->db->query('SELECT r.*, sum(rt.quantidade) as totalemp FROM `reserva` as r JOIN reservatipo as rt ON 
		r.idReserva=rt.idReserva WHERE dataDevolucao>"'.$dataInicio.'" and dataRetirada<"'.$dataFim.'" and rt.idTipo = '.$idTipo.' group by rt.idReserva');
		
		// Finaliza a transação e fecha a conexão
		$this->db->trans_complete();
		//$this->db->close();
		
		// Caso não tenha encontrado nenhum administrador, retorna um valor nulo
    	$reservas = array();
		
		// Verifica se encontrou alguma reserva na query
		if ($query->num_rows() > 0  ) {

			// Joga os resultados dentro da variável $reservas
			foreach ($query->result() as $row) {

				// Se a pessoa fisica não tiver com status 'excluído'
				$reservas[] = array(new Reserva($row->idReserva,
												$row->hora,
												$row->dataRetirada,
												$row->dataDevolucao,
												$row->idCliente,
												$row->idEndereco),$row->totalemp);
			}

			// Retorna o array com todos os administradores encontrados
			return $reservas;
		}
		return array();
		
	}
	
	public function podeRemover($campo,$id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where($campo,$id);
		
		$query = $this->db->get('reserva'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if ($query->num_rows() == 0)
        	return True; 
		return False;
	}
	
	public function removerReserva($id) {
		// Inicia a transação
		$this->db->trans_start();
		
		$this->db->where('idReserva',$id);
		
		$query = $this->db->delete('reserva'); 
		
		$this->db->trans_complete();
		//$this->db->close();
		
		if($this->db->trans_status()) 
			return TRUE;
		return FALSE;
	}
}

/* End of file reserva_model.php */
/* Location: ./application/models/reserva_model.php */