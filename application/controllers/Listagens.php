<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------------------
 * CONTROLLER LISTAGENS
 *---------------------------------------------------------------------------
 * 
 * Responsável por controlar toda a lógica computacional da função
 * relacionadas a tela de Inicio. Tem a função de se comunicar
 * com as models e as views, fazendo as chamadas nos momentos necessários.
 *
 */

class Listagens extends CI_Controller {

    /**
     * Construtor
     */
	function __construct() {

        // Chama todas as models e bibliotecas necessárias no controller
        parent::__construct();
        $this->load->model('maquina_model', 'Maquina_Model');
        $this->load->model('aluguel_model', 'Aluguel_Model');
        $this->load->model('manutencao_model', 'Manutencao_Model');
        $this->load->model('tipomaquina_model', 'TipoMaquina_Model');
        $this->load->model('operatipo_model', 'OperaTipo_Model');
        $this->load->model('filial_model', 'Filial_Model');
        $this->load->model('enderecos_model', 'Enderecos_Model');
        $this->load->model('reserva_model', 'Reserva_Model');
        $this->load->model('reservatipo_model', 'ReservaTipo_Model');
        $this->load->model('operador_model', 'Operador_Model');
        $this->load->model('pessoafisica_model', 'PessoaFisica_Model');
        $this->load->model('pessoajuridica_model', 'PessoaJuridica_Model');
    }

    /**
     * Carrega a página de inicio dos congressistas
     */
    public function index() {
		$this->load->view('listagens_view');
    }
		
		
	public function aluguel(){
		$data['tabela']='Locações';
		$data['dados']= $this->Aluguel_Model->listarAlugueis();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function pessoaFisica(){
		$data['tabela']='Pessoas Fisicas';
		$data['dados']=$this->PessoaFisica_Model->listarPessoasFisicas();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function pessoaJuridica(){
		$data['tabela']='Pessoas Juridicas';
		$data['dados']=$this->PessoaJuridica_Model->listarPessoasJuridicas();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function enderecos(){
		$data['tabela']='Endereços';
		$data['dados']=$this->Enderecos_Model->listarEnderecos();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function filial(){
		$data['tabela']='Filiais';
		$data['dados']=$this->Filial_Model->listarFiliais();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function manutencao(){
		$data['tabela']='Manutenções';
		$data['dados']=$this->Manutencao_Model->listarManutencoes();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function maquina(){
		$data['tabela']='Máquinas';
		$data['dados']=$this->Maquina_Model->listarMaquinas();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function operador(){
		$data['tabela']='Operadores';
		$data['dados']=$this->Operador_Model->listarOperadores();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function operatipo($idOp = NULL){
		if($idOp == NULL){
			$data['dados']=$this->OperaTipo_Model->listarOperaTipos();
		} else {
			$data['dados']=$this->OperaTipo_Model->getOperaTipoByOperador($idOp);
		}
		$data['tabela']='Operadores Por Tipo';
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function reserva(){
		$data['tabela']='Reservas';
		$data['dados']=$this->Reserva_Model->listarReservas();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function reservatipo(){
		$data['tabela']='Reservas Por Tipo de Máquina';
		$data['dados']=$this->ReservaTipo_Model->listarReservaTipos();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function tipomaquina(){
		$data['tabela']='Tipo de Máquina';
		$data['dados']=$this->TipoMaquina_Model->listarTipoMaquinas();
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function exibir($tabela,$id=NULL){
		$data['tabela']=$tabela;
		if($id!=NULL)
		switch($tabela){
			case "Cliente":
				$pf=$this->PessoaFisica_Model->getPessoaFisica($id);
				$pj=$this->PessoaJuridica_Model->getPessoaJuridica($id);
				if($pf!=NULL)
					$data['dados'] = array($pf);
				else
					$data['dados'] = array($pj);
				break;
			case "Endereco":
				$data['dados'] = array($this->Enderecos_Model->getEnderecos($id));
				break;
			case "Filial":
				$data['dados'] = array($this->Filial_Model->getFilial($id));
				break;
			case "Manutencao":
				$data['dados'] = array($this->Manutencao_Model->getManutencao($id));
				break;
			case "Maquina":
				$data['dados'] = array($this->Maquina_Model->getMaquina($id));
				break;
			case "Operador":
				$data['dados'] = array($this->Operador_Model->getOperador($id));
				break;
			case "Reserva":
				$data['dados'] = array($this->Reserva_Model->getReserva($id));
				break;
			case "TipoMaquina":
				$data['dados'] = array($this->TipoMaquina_Model->getTipoMaquina($id));
				break;
			case "EnderecoCliente":
				$data['dados'] = $this->Enderecos_Model->listarEnderecosByCliente($id);
				break;
		}
		$this->load->view('listagens_gerais_view', $data);
	}
	
	public function ramos_atividade($id=NULL){
		if($id==NULL){
			$tps = $this->TipoMaquina_Model->listarTipoMaquinas();
			$data['tipomaquinas'] = array();
			$ramos = array();
			foreach($tps as $tp){
				if(!in_array($tp->getRamo(),$ramos)){
					$data['tipomaquinas'][] = $tp;
					$ramos[] = $tp->getRamo();
				}
			}
			$this->load->view('ramos_list_view', $data);
		} else {
			$tps = $this->TipoMaquina_Model->listarTipoMaquinas();
			$ramo = $this->TipoMaquina_Model->getTipoMaquina($id)->getRamo();
			$operatipos = array();
			$maquinas = array();
			foreach($tps as $tp){
				if($tp->getRamo()==$ramo){
					$operatipos[] = $this->TipoMaquina_Model->getTipoMaquina($tp->getIdTipo());
					$maquinas=array_merge($maquinas,$this->Maquina_Model->listarMaquinasByTipo($tp->getIdTipo()));
				}
			}
			$data['servicos'] = $operatipos;
			$data['maquinas'] = $maquinas;
			$this->load->view('ferramentas_disp_view', $data);
		}
	}
	
}

/* End of file Produtos.php */
/* Location: ./application/controllers/Produtos.php */