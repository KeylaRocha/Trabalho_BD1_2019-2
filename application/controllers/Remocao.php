<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------------------
 * CONTROLLER REMOCAO
 *---------------------------------------------------------------------------
 * 
 * Responsável por controlar toda a lógica computacional da função
 * relacionadas a tela de Inicio. Tem a função de se comunicar
 * com as models e as views, fazendo as chamadas nos momentos necessários.
 *
 */

class Remocao extends CI_Controller {

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
		
		
	public function Aluguel($id){
		$data['dados']=array($this->Aluguel_Model->getAluguel($id));
		$id = $this->Aluguel_Model->removerAluguel($id);
		if($id)
			$this->load->view('remove_confirm_view', $data);
		else{
			$data=array();
			$data['erro']="ERRO NA REMOCAO";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function PessoaFisica($id){
		$data['dados']=array($this->PessoaFisica_Model->getPessoaFisica($id));
		$teste = $this->Reserva_Model->podeRemover("idCliente",$id);
		$teste2 = $this->Enderecos_Model->podeRemover("idCliente",$id);
		if($teste){
			if($teste2){
				$id = $this->PessoaFisica_Model->removerPessoaFisica($id);
				if($id)
					$this->load->view('remove_confirm_view', $data);
				else{
					$data=array();
					$data['erro']="ERRO NA REMOCAO";
					$this->load->view('remove_confirm_view', $data);
				}
			} else {
				$data['erro']="ERRO NA REMOCAO</br>EXISTE ENDEREÇO RELACIONADO";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE RESERVA RELACIONADA";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function PessoaJuridica($id){
		$data['dados']=array($this->PessoaJuridica_Model->getPessoaJuridica($id));
		$teste = $this->Reserva_Model->podeRemover("idCliente",$id);
		$teste2 = $this->Enderecos_Model->podeRemover("idCliente",$id);
		if($teste){
			if($teste2){
				$id = $this->PessoaJuridica_Model->removerPessoaJuridica($id);
				if($id)
					$this->load->view('remove_confirm_view', $data);
				else{
					$data=array();
					$data['erro']="ERRO NA REMOCAO";
					$this->load->view('remove_confirm_view', $data);
				}
			} else {
				$data['erro']="ERRO NA REMOCAO</br>EXISTE ENDEREÇO RELACIONADO";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE RESERVA RELACIONADA";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function Enderecos($id){
		$end = $this->Enderecos_Model->getEnderecos($id);
		$data['dados']=array($end);
		$teste = $this->Filial_Model->podeRemover("idEndereco",$id);
		$teste = $this->Reserva_Model->podeRemover("idReserva",$id);
		
		if($teste){
			if($teste){
				$id = $this->Enderecos_Model->removerEndereco($id);
				if($id)
					$this->load->view('remove_confirm_view', $data);
				else{
					$data=array();
					$data['erro']="ERRO NA REMOCAO";
					$this->load->view('remove_confirm_view', $data);
				}
			} else {
				$data=array();
				$data['erro']="ERRO NA REMOCAO</br>EXISTE RESERVA RELACIONADA";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data=array();
			$data['erro']="ERRO NA REMOCAO</br>EXISTE FILIAL RELACIONADA";
			$this->load->view('remove_confirm_view', $data);
		} 	
	}
	
	public function Filial($id){
		$data['dados']=array($this->Filial_Model->getFilial($id));
		$teste = $this->Maquina_Model->podeRemover("idFilial",$id);
		if($teste){
			$id = $this->Filial_Model->removerFilial($id);
			if($id)
				$this->load->view('remove_confirm_view', $data);
			else{
				$data=array();
				$data['erro']="ERRO NA REMOCAO";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE MAQUINA RELACIONADA";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function Manutencao($id){
		$data['dados']=array($this->Manutencao_Model->getManutencao($id));
		$teste = $this->Aluguel_Model->podeRemover("idManutencao",$id);
		if($teste){
			$id = $this->Manutencao_Model->removerManutencao($id);
			if($id)
				$this->load->view('remove_confirm_view', $data);
			else{
				$data=array();
				$data['erro']="ERRO NA REMOCAO";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE ALUGUEL RELACIONADO";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function Maquina($id){
		$data['dados']=array($this->Maquina_Model->getMaquina($id));
		$teste = $this->Aluguel_Model->podeRemover("idMaquina",$id);
		$teste2 = $this->Manutencao_Model->podeRemover("idMaquina",$id);
		if($teste){
			if($teste2){
				$id = $this->Maquina_Model->removerMaquina($id);
				if($id)
					$this->load->view('remove_confirm_view', $data);
				else{
					$data=array();
					$data['erro']="ERRO NA REMOCAO";
					$this->load->view('remove_confirm_view', $data);
				}
			} else {
				$data['erro']="ERRO NA REMOCAO</br>EXISTE MANUTENÇÃO RELACIONADA";
			$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE ALUGUEL RELACIONADO";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function Operador($id){
		$data['dados']=array($this->Operador_Model->getOperador($id));
		$teste = $this->Aluguel_Model->podeRemover("idOperador",$id);
		$teste2 = $this->OperaTipo_Model->podeRemover("idOperador",$id);
		if($teste){
			if($teste2){
				$id = $this->Operador_Model->removerOperador($id);
				if($id)
					$this->load->view('remove_confirm_view', $data);
				else{
					$data=array();
					$data['erro']="ERRO NA REMOCAO";
					$this->load->view('remove_confirm_view', $data);
				}
			} else {
				$data['erro']="ERRO NA REMOCAO</br>EXISTE SERVIÇO(OPERATIPO) RELACIONADO";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE ALUGUEL RELACIONADO";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function OperaTipo($idO,$idT){
		$data['dados']=array(new OperaTipo($idO,$idT));
		$id = $this->OperaTipo_Model->removerOperaTipo($idT,$idO);
		if($id)
			$this->load->view('remove_confirm_view', $data);
		else{
			$data=array();
			$data['erro']="ERRO NA REMOCAO";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	
	public function Reserva($id){
		$data['dados']=array($this->Reserva_Model->getReserva($id));
		$teste = $this->Aluguel_Model->podeRemover("idReserva",$id);
		$teste2 = $this->ReservaTipo_Model->podeRemover("idReserva",$id);
		if($teste){
			if($teste2){
				$id = $this->Reserva_Model->removerReserva($id);
				if($id)
					$this->load->view('remove_confirm_view', $data);
				else{
					$data=array();
					$data['erro']="ERRO NA REMOCAO";
					$this->load->view('remove_confirm_view', $data);
				}
			} else {
				$data['erro']="ERRO NA REMOCAO</br>EXISTE RESERVATIPO RELACIONADA";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE ALUGUEL RELACIONADA";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function ReservaTipo($idR,$idT){
		$data['dados']=array($this->ReservaTipo_Model->getReservaTipo($idR,$idT));
		$id = $this->ReservaTipo_Model->removerReservaTipo($idR,$idT);
		if($id)
			$this->load->view('remove_confirm_view', $data);
		else{
			$data=array();
			$data['erro']="ERRO NA REMOCAO";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
	public function TipoMaquina($id){
		$data['dados']=array($this->TipoMaquina_Model->getTipoMaquina($id));
		$teste = $this->Maquina_Model->podeRemover("idTipo",$id);
		$teste2 = $this->ReservaTipo_Model->podeRemover("idTipo",$id);
		$teste3 = $this->OperaTipo_Model->podeRemover("idTipo",$id);
		if($teste){
			if($teste2){
				if($teste3){
					$id = $this->TipoMaquina_Model->removerTipoMaquina($id);
					if($id)
						$this->load->view('remove_confirm_view', $data);
					else{
						$data=array();
						$data['erro']="ERRO NA REMOCAO";
						$this->load->view('remove_confirm_view', $data);
					}
				} else {
					$data['erro']="ERRO NA REMOCAO</br>EXISTE SERVIÇO(OPERATIPO) RELACIONADO";
					$this->load->view('remove_confirm_view', $data);
				}
			} else {
				$data['erro']="ERRO NA REMOCAO</br>EXISTE RESERVATIPO RELACIONADA";
				$this->load->view('remove_confirm_view', $data);
			}
		} else {
			$data['erro']="ERRO NA REMOCAO</br>EXISTE MAQUINA RELACIONADA";
			$this->load->view('remove_confirm_view', $data);
		}
	}
	
}

/* End of file Produtos.php */
/* Location: ./application/controllers/Produtos.php */