<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------------------
 * CONTROLLER EDICAO
 *---------------------------------------------------------------------------
 * 
 * Responsável por controlar toda a lógica computacional da função
 * relacionadas a tela de Inicio. Tem a função de se comunicar
 * com as models e as views, fazendo as chamadas nos momentos necessários.
 *
 */

class Edicao extends CI_Controller {

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
		$instancia= $this->Aluguel_Model->getAluguel($id);
		if($this->input->post("dataRet")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['dataRet']=$this->desconverte_data($instancia->getDataRetEfetiva());
			if($instancia->getDataDevEfetiva()!=NULL)
				$data['dados']['dataDev']=$this->desconverte_data($instancia->getDataDevEfetiva());
			else
				$data['dados']['dataDev']="";
			$data['dados']['taxa']=floatval($instancia->getTaxa());
			$data['dados']['maquina']=$instancia->getIdMaquina();
			$data['dados']['reserva']=$instancia->getIdReserva();
			$data['dados']['seguro']=$instancia->getTemSeguro();
			$data['dados']['manut']=$this->Manutencao_Model->getManutencao($instancia->getIdManutencao());
			$maq = $this->Maquina_Model->getMaquina($instancia->getIdMaquina());
			$op = $this->Operador_Model->getOperador($instancia->getIdOperador());
			if($op!=NULL)
				$data['dados']['operador'] = $op->getNome();
			else
				$data['dados']['operador'] = "Nenhum";
			$reserva=$this->Reserva_Model->getReserva($instancia->getIdReserva());
			$data['dados']['maq'] = $maq->getModelo()." Nº ".$maq->getNumeroSerie()." - ".$maq->getFabricante();
			$data['dados']['res'] = "De ".$reserva->getDataRetirada()." às ".$reserva->getHora()." até ".$reserva->getDataDevolucao();
			$pf = $this->PessoaFisica_Model->getPessoaFisica($reserva->getIdCliente());
			$pj = $this->PessoaJuridica_Model->getPessoaJuridica($reserva->getIdCliente());
			if($pf!=NULL)
				$data['dados']['cliente']=$pf->getCPF();
			else
				$data['dados']['cliente']=$pf->getCNPJ();
			$this->load->view('aluguel_edit_view', $data);
		} else {
			$this->load->library('form_validation');
					
			$this->form_validation->set_rules('dataRet', 'DataRetirada', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('dataDev', 'DataDevolucao', 'trim|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('taxa', 'Taxa', 'trim|required|decimal');
			$this->form_validation->set_rules('seguro', 'Seguro', 'trim|required');
			$this->form_validation->set_rules('manut', 'Manutencao', 'trim|required');
			$this->form_validation->set_rules('inicio', 'Inicio da Manutencao', 'trim|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('fim', 'Fim da Manutencao', 'trim|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('custo', 'Custo', 'trim|decimal');
			if ($this->form_validation->run() == FALSE){
				$data=array();
				$data['dados'] = $_POST;
				$data['dados']['id']=$id;
				$data['dados']['manut']=$this->Manutencao_Model->getManutencao($instancia->getIdManutencao());
				$maq = $this->Maquina_Model->getMaquina($instancia->getIdMaquina());
				$reserva=$this->Reserva_Model->getReserva($instancia->getIdReserva());
				$data['dados']['maq'] = $maq->getModelo()." Nº ".$maq->getNumeroSerie()." - ".$maq->getFabricante();
				$data['dados']['res'] = "De ".$reserva->getDataRetirada()." às ".$reserva->getHora()." até ".$reserva->getDataDevolucao();
				$op = $this->Operador_Model->getOperador($instancia->getIdOperador());
				if($op!=NULL)
					$data['dados']['operador'] = $op->getNome();
				else
					$data['dados']['operador'] = "Nenhum";
				$pf = $this->PessoaFisica_Model->getPessoaFisica($reserva->getIdCliente());
				$pj = $this->PessoaJuridica_Model->getPessoaJuridica($reserva->getIdCliente());
				if($pf!=NULL)
					$data['dados']['cliente']=$pf->getCPF();
				else
					$data['dados']['cliente']=$pf->getCNPJ();
				$data["erro"]= "ERRO: ".validation_errors();
				$this->load->view('aluguel_edit_view', $data);
			} else {
				$instancia->setDataRetEfetiva($this->converte_data($this->input->post("dataRet")));
				if($this->input->post("dataDev")!=NULL)
					$instancia->setDataDevEfetiva($this->converte_data($this->input->post("dataDev")));
				$instancia->setTaxa($this->input->post("taxa"));
				$instancia->setTemSeguro($this->input->post("seguro"));
				if($this->input->post("manut")=="N" and $this->input->post("custo")!=NULL){
					$manutencao = new Manutencao(NULL,$this->converte_data($this->input->post("dataRet")),$this->converte_data($this->input->post("dataDev")),$this->input->post("custo"),$instancia->getIdMaquina());
					
					$id=$this->Manutencao_Model->inserirManutencao($manutencao);
					if($id==NULL){
						$data['erro']="ERRO INSERINDO MANUTENCAO";
						$this->load->view('aluguel_edit_view',$data);
					} else {
						$instancia->setIdManutencao($id);
						if($instancia->getTemSeguro()==0){
							$instancia->setValorTotal(floatval($instancia->getValorTotal())+floatval($this->input->post("custo")));
						}
						if($this->Aluguel_Model->editarAluguel($instancia))
						$data['sucesso'] = "Dados inseridos com Sucesso";
						else
							$data['erro'] = "ERRO EDITANDO ALUGUEL";
						$this->load->view('aluguel_edit_view',$data);
					}
				} else {
					if($this->Aluguel_Model->editarAluguel($instancia))
						$data['sucesso'] = "Dados editados com Sucesso";
					else
						$data['erro'] = "ERRO EDITANDO ALUGUEL";
					$this->load->view('aluguel_edit_view',$data);
				}
			}
		}
	}
	
	public function PessoaFisica($id){
		$instancia=$this->PessoaFisica_Model->getPessoaFisica($id);
		$end = $this->Enderecos_Model->getEnderecoPrincipal($id);
		if($this->input->post("nome")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['nome']=$instancia->getNome();
			$data['dados']['cliente']=$instancia->getCPF();
			$data['dados']['email']=$instancia->getEmail();
			$data['dados']['tel']=$instancia->getTelefone();
			$data['dados']['nasc']=$this->desconverte_data($instancia->getDataNascimento());
			$data['dados']['bairro']=$end->getBairro();
			$data['dados']['cidade']=$end->getCidade();
			$data['dados']['uf']=$end->getEstado();
			$data['dados']['rua']=$end->getRua();
			$data['dados']['num']=$end->getNumero();
			$data['dados']['comp']=$end->getComplemento();
			$data['dados']['cep']=$end->getCEP();
			$this->load->view('pessoafisica_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[11]');
			$this->form_validation->set_rules('nasc', 'DataNascimento', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('nome', 'Nome', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('bairro', 'Bairro', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('cidade', 'Cidade', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('rua', 'Rua', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('num', 'Número', 'trim|required');
			$this->form_validation->set_rules('comp', 'Complemento', 'trim');
			$this->form_validation->set_rules('cep', 'CEP', 'trim|required|max_length[8]');
			$this->form_validation->set_rules('uf', 'Estado', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('tel', 'Telefone', 'trim|required|max_length[11]');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors(); 
				$this->load->view('pessoafisica_edit_view',$data);
			} else {
				$instancia->setCPF($this->input->post("cliente"));
				$instancia->setNome($this->input->post("nome"));
				$instancia->setDataNascimento($this->input->post("nasc"));
				$instancia->setEmail($this->input->post("email"));
				$instancia->setTelefone($this->input->post("tel"));
				$end->setBairro($this->input->post("bairro"));
				$end->setCidade($this->input->post("cidade"));
				$end->setRua($this->input->post("rua"));
				$end->setNumero($this->input->post("num"));
				$end->setComplemento($this->input->post("comp"));
				$end->setEstado($this->input->post("uf"));
				$end->setCEP($this->input->post("cep"));
				
				$id = $this->PessoaFisica_Model->editarPessoaFisica($instancia);
				if(!$id){
					$data['erro'] = "ERRO EDITANDO CLIENTE";
				} else {
					$id = $this->Enderecos_Model->editarEnderecos($end);
					if(!$id){
						$data['erro'] = "ERRO EDITANDO ENDEREÇO DO CLIENTE";
					} else {
						$data['sucesso'] = "Dados editados com Sucesso";
					}
				}
				$this->load->view('pessoafisica_edit_view', $data);
			}
		}
	}
	
	public function PessoaJuridica($id){
		$instancia=$this->PessoaJuridica_Model->getPessoaJuridica($id);
		$end = $this->Enderecos_Model->getEnderecoPrincipal($id);
		if($this->input->post("nome")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['nome']=$instancia->getNome();
			$data['dados']['cliente']=$instancia->getCNPJ();
			$data['dados']['email']=$instancia->getEmail();
			$data['dados']['tel']=$instancia->getTelefone();
			$data['dados']['razaosoc']=$instancia->getRazaoSocial();
			$data['dados']['repr']=$instancia->getRepresentante();
			$data['dados']['bairro']=$end->getBairro();
			$data['dados']['cidade']=$end->getCidade();
			$data['dados']['uf']=$end->getEstado();
			$data['dados']['rua']=$end->getRua();
			$data['dados']['num']=$end->getNumero();
			$data['dados']['comp']=$end->getComplemento();
			$data['dados']['cep']=$end->getCEP();
			$this->load->view('pessoajuridica_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
			$this->form_validation->set_rules('razaosoc', 'RazaoSocial', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('repr', 'Representante', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('nome', 'Nome', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('bairro', 'Bairro', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('cidade', 'Cidade', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('rua', 'Rua', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('num', 'Número', 'trim|required');
			$this->form_validation->set_rules('comp', 'Complemento', 'trim');
			$this->form_validation->set_rules('cep', 'CEP', 'trim|required|max_length[8]');
			$this->form_validation->set_rules('uf', 'Estado', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('tel', 'Telefone', 'trim|required|max_length[11]');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors(); 
				$this->load->view('pessoajuridica_edit_view',$data);
			} else {
				$instancia->setCNPJ($this->input->post("cliente"));
				$instancia->setNome($this->input->post("nome"));
				$instancia->setRazaoSocial($this->input->post("razaosoc"));
				$instancia->setRepresentante($this->input->post("repr"));
				$instancia->setEmail($this->input->post("email"));
				$instancia->setTelefone($this->input->post("tel"));
				$end->setBairro($this->input->post("bairro"));
				$end->setCidade($this->input->post("cidade"));
				$end->setRua($this->input->post("rua"));
				$end->setNumero($this->input->post("num"));
				$end->setComplemento($this->input->post("comp"));
				$end->setEstado($this->input->post("uf"));
				$end->setCEP($this->input->post("cep"));
				
				$id = $this->PessoaJuridica_Model->editarPessoaJuridica($instancia);
				if(!$id){
					$data['erro'] = "ERRO EDITANDO CLIENTE";
				} else {
					$id = $this->Enderecos_Model->editarEnderecos($end);
					if(!$id){
						$data['erro'] = "ERRO EDITANDO ENDEREÇO DO CLIENTE";
					} else {
						$data['sucesso'] = "Dados editados com Sucesso";
					}
				}
				$this->load->view('pessoajuridica_edit_view', $data);
			}
		}
	}
	
	public function Enderecos($id){
		$end=$this->Enderecos_Model->getEnderecos($id);
		if($this->input->post("rua")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['bairro']=$end->getBairro();
			$data['dados']['cidade']=$end->getCidade();
			$data['dados']['uf']=$end->getEstado();
			$data['dados']['rua']=$end->getRua();
			$data['dados']['num']=$end->getNumero();
			$data['dados']['comp']=$end->getComplemento();
			$data['dados']['cep']=$end->getCEP();
			$this->load->view('endereco_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('bairro', 'Bairro', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('cidade', 'Cidade', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('rua', 'Rua', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('num', 'Número', 'trim|required');
			$this->form_validation->set_rules('comp', 'Complemento', 'trim');
			$this->form_validation->set_rules('cep', 'CEP', 'trim|required|max_length[8]');
			$this->form_validation->set_rules('uf', 'Estado', 'trim|required|max_length[50]');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors(); 
				$this->load->view('endereco_edit_view',$data);
			} else {
				$end->setBairro($this->input->post("bairro"));
				$end->setCidade($this->input->post("cidade"));
				$end->setRua($this->input->post("rua"));
				$end->setNumero($this->input->post("num"));
				$end->setComplemento($this->input->post("comp"));
				$end->setEstado($this->input->post("uf"));
				$end->setCEP($this->input->post("cep"));
				
				$id = $this->Enderecos_Model->editarEnderecos($end);
				if(!$id){
					$data['erro'] = "ERRO EDITANDO ENDEREÇO";
				} else {
					$data['sucesso'] = "Dados editados com Sucesso";
				}
				
				$this->load->view('endereco_edit_view', $data);
			}
		}
	}
	
	public function Filial($id){
		$instancia=$this->Filial_Model->getFilial($id);
		$end = $this->Enderecos_Model->getEnderecos($instancia->getIdEndereco());
		if($this->input->post("rua")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['tel']=$instancia->getTelefone();
			$data['dados']['bairro']=$end->getBairro();
			$data['dados']['cidade']=$end->getCidade();
			$data['dados']['uf']=$end->getEstado();
			$data['dados']['rua']=$end->getRua();
			$data['dados']['num']=$end->getNumero();
			$data['dados']['comp']=$end->getComplemento();
			$data['dados']['cep']=$end->getCEP();
			$this->load->view('filial_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('bairro', 'Bairro', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('cidade', 'Cidade', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('rua', 'Rua', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('num', 'Número', 'trim|required');
			$this->form_validation->set_rules('comp', 'Complemento', 'trim');
			$this->form_validation->set_rules('cep', 'CEP', 'trim|required|max_length[8]');
			$this->form_validation->set_rules('uf', 'Estado', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('tel', 'Telefone', 'trim|required|max_length[11]');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors(); 
				$this->load->view('filial_edit_view',$data);
			} else {
				$instancia->setTelefone($this->input->post("tel"));
				$end->setBairro($this->input->post("bairro"));
				$end->setCidade($this->input->post("cidade"));
				$end->setRua($this->input->post("rua"));
				$end->setNumero($this->input->post("num"));
				$end->setComplemento($this->input->post("comp"));
				$end->setEstado($this->input->post("uf"));
				$end->setCEP($this->input->post("cep"));
				
				$id = $this->Filial_Model->editarFilial($instancia);
				if(!$id){
					$data['erro'] = "ERRO EDITANDO FILIAL";
				} else {
					$id = $this->Enderecos_Model->editarEnderecos($end);
					if(!$id){
						$data['erro'] = "ERRO EDITANDO ENDEREÇO DA FILIAL";
					} else {
						$this->load->library('upload');
						$config['upload_path'] = './Imagens/Filial/';
						$config['file_name'] = $id;
						$config['allowed_types'] = 'jpg';
						$config['max_size']	= '2048';
						$this->upload->initialize($config);
						if ($this->upload->do_upload('foto') == TRUE) {
							$upload_data = $this->upload->data();
							$nome_do_arquivo_gravado = $upload_data['file_name'];
							$data['sucesso'] = "Dados editados com Sucesso";
						}
						else {
							$data["erro"]= "ERRO NO UPLOAD DA IMAGEM: </br>".$this->upload->display_errors();
						}						
					}
				}
				$this->load->view('filial_edit_view', $data);
			}
		}
	}
	
	public function Manutencao($id){
		$instancia=$this->Manutencao_Model->getManutencao($id);
		if($this->input->post("custo")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['inicio']=$this->desconverte_data($instancia->getDataEntrada());
			$data['dados']['fim']=$this->desconverte_data($instancia->getDataSaida());
			$data['dados']['custo']=$instancia->getCusto();
			$maq=$this->Maquina_Model->getMaquina($instancia->getIdMaquina());
			$data['dados']['maq'] = $maq->getModelo()." Nº ".$maq->getNumeroSerie()." - ".$maq->getFabricante();
			$this->load->view('manutencao_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('inicio', 'Inicio da Manutencao', 'trim|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('fim', 'Fim da Manutencao', 'trim|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('custo', 'Custo', 'trim|decimal');
			if ($this->form_validation->run() == FALSE){
				$data['dados']=array();
				$data['dados']['id']=$id;
				$data['dados']['inicio']=$this->desconverte_data($instancia->getDataEntrada());
				$data['dados']['fim']=$this->desconverte_data($instancia->getDataSaida());
				$data['dados']['custo']=$instancia->getCusto();
				$maq=$this->Maquina_Model->getMaquina($instancia->getIdMaquina());
				$data['dados']['maq'] = $maq->getModelo()." Nº ".$maq->getNumeroSerie()." - ".$maq->getFabricante();
				$data["erro"]= "ERRO: ".validation_errors(); 
				$this->load->view('manutencao_edit_view',$data);
			} else {
				$instancia->setDataEntrada($this->converte_data($this->input->post("inicio")));
				$instancia->setDataSaida($this->converte_data($this->input->post("fim")));
				$instancia->setCusto($this->input->post("custo"));
				$id=$this->Manutencao_Model->editarManutencao($instancia);
				if($id==NULL){
					$data['erro']="ERRO EDITANDO MANUTENCAO";
				} else {
					$data['sucesso'] = "Dados editados com Sucesso";
				}
				$this->load->view('manutencao_edit_view',$data);
			}
		}
	}
	
	public function Maquina($id){
		$instancia=$this->Maquina_Model->getMaquina($id);
		if($this->input->post("modelo")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['modelo']=$instancia->getModelo();
			$data['dados']['fabricante']=$instancia->getFabricante();
			$data['dados']['numserie']=$instancia->getNumeroSerie();
			$data['dados']['filial']=$instancia->getIdFilial();
			$data['tipomaquinas']=$this->TipoMaquina_Model->listarTipoMaquinas();
			$f=$this->Filial_Model->getFilial($instancia->getIdFilial());
			$e = $this->Enderecos_Model->getEnderecos($f->getIdEndereco());
			$data['dados']['end']=$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP();
			$this->load->view('maquina_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('modelo', 'Modelo', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('fabricante', 'Fabricante', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('numserie', 'NumeroSerie', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('tipomaquina', 'idTipo', 'trim|required');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors(); 
				$data['filial']=$filial;
				$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
				$this->load->view('maquina_cadastro_view', $data);
			} else {
				$instancia->setModelo($this->input->post("modelo"));
				$instancia->setFabricante($this->input->post("fabricante"));
				$instancia->setNumeroSerie($this->input->post("numserie"));
				$instancia->setIdTipo($this->input->post("idTipo"));
				$id = $this->Maquina_Model->editarMaquina($maquina);
				if($id != FALSE){
					$this->load->library('upload');
					$config['upload_path'] = './Imagens/Maquina/';
					$config['file_name'] = $id;
					$config['allowed_types'] = 'jpg';
					$config['max_size']	= '2048';
					$this->upload->initialize($config);
					if ($this->upload->do_upload('foto') == TRUE) {
						$upload_data = $this->upload->data();
						$nome_do_arquivo_gravado = $upload_data['file_name'];
						$data['sucesso'] = "Dados editados com Sucesso";
					}
					else {
						$data["erro"]= "ERRO NO UPLOAD DA IMAGEM: </br>".$this->upload->display_errors();
					}
				} else {
					$data['erro']="ERRO EDITANDO MAQUINA";
				}
				$this->load->view('maquina_cadastro_view',$data);
			}
		}
	}
	
	public function Operador($id){
		$instancia=$this->Operador_Model->getOperador($id);
		if($this->input->post("nome")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['nome']=$instancia->getNome();
			$data['dados']['valorhora']=$instancia->getValorHora();
			$data['dados']['celular']=$instancia->getCelular();
			//$data['tipomaquinas']=$this->TipoMaquina_Model->listarTipoMaquinas();
			$this->load->view('operador_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nome', 'Nome', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('celular', 'Celular', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('valorhora', 'ValorHora', 'trim|required|decimal');
			
			if ($this->form_validation->run() == FALSE){
				$data['dados']=array();
				$data['dados']['id']=$id;
				$data['dados']['nome']=$instancia->getNome();
				$data['dados']['valorhora']=$instancia->getValorHora();
				$data['dados']['celular']=$instancia->getCelular();
				//$data['tipomaquinas']=$this->TipoMaquina_Model->listarTipoMaquinas();
				$data["erro"]= "ERRO: ".validation_errors();
				$this->load->view('operador_edit_view',$data);
			} else{
				$instancia->setNome($this->input->post("nome"));
				$instancia->setCelular($this->input->post("celular"));
				$instancia->setValorHora($this->input->post("valorhora"));
				$id=$this->Operador_Model->editarOperador($instancia);
				if($id == FALSE)
					$data['erro'] = "ERRO EDITANDO OPERADOR";
				else
					$data['sucesso'] = "Dados editados com Sucesso";
				$this->load->view('operador_edit_view',$data);
			}
		}
	}
	
	public function OperaTipo($idO,$idT){
		$op=$this->Operador_Model->getOperador($idO);
		if($this->input->post("tipomaquina")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$idO."/".$idT;
			$data['dados']['op']=$op->getNome();
			$data['tipomaquinas']=$this->TipoMaquina_Model->listarTipoMaquinas();
			$this->load->view('operatipo_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tipomaquina', 'IdTipo', 'trim|required');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors();
				$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
				$this->load->view('operatipo_edit_view',$data);
			} else{
				$operatipos=$this->OperaTipo_Model->getOperaTipoByOperador($idO);
				$aux = new OperaTipo($this->input->post("tipomaquina"),$idO);
				if(in_array($aux,$operatipos)){
					$data['erro'] = "RELAÇÃO OPERADOR TIPO JÁ EXISTE";
				} else {
					$id=$this->OperaTipo->editarOperaTipo($idO,$idT,$aux);
					if($id == FALSE){
						$data['erro'] = "ERRO EDITANDO OPERATIPO";
						$data['dados']=array();
						$data['dados']['id']=$idO."/".$idT;
						$data['dados']['op']=$op->getNome();
						$data['tipomaquinas']=$this->TipoMaquina_Model->listarTipoMaquinas();
					}else
						$data['sucesso'] = "Dados editados com Sucesso";
					$this->load->view('operatipo_edit_view',$data);
				}
			}
		}
	}
	
	
	public function Reserva($id){
		$instancia=$this->Reserva_Model->getReserva($id);
		if($this->input->post("dataRet")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['dataRet']=$this->desconverte_data($instancia->getDataRetirada());
			$data['dados']['dataDev']=$this->desconverte_data($instancia->getDataDevolucao());
			$data['dados']['hora']=$instancia->getHora();
			$data['dados']['qtd']=count($this->ReservaTipo_Model->getReservaTiposByReserva($id));
			$data['tipomaquinas']=$this->TipoMaquina_Model->listarTipoMaquinas();
			$end = $this->Enderecos_Model->listarEnderecosByCliente($instancia->getIdCliente());
			$data['enderecos'] = array();
			foreach($end as $e){
				$data['enderecos'][] = array($e->getIdEndereco(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP());
			}
			$pf = $this->PessoaFisica_Model->getPessoaFisica($instancia->getIdCliente());
			$pj = $this->PessoaJuridica_Model->getPessoaJuridica($instancia->getIdCliente());
			if($pf!=NULL)
				$data['dados']['cliente']=$pf->getCPF();
			else
				$data['dados']['cliente']=$pf->getCNPJ();
			$this->load->view('reserva_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('dataRet', 'DataRetirada', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('dataDev', 'DataDevolucao', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			$this->form_validation->set_rules('hora', 'Hora', 'trim|required|regex_match[/\d\d:\d\d:\d\d/]');
			$this->form_validation->set_rules('tipomaquina', 'idTipo', 'trim|required');
			$this->form_validation->set_rules('qtd', 'Quantidade', 'trim|required|integer');
			$this->form_validation->set_rules('endereco', 'IdEndereco', 'trim|required|integer');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors();
					$this->load->view('reserva_edit_view', $data);
			} else {
				$instancia->setDataRetirada($this->converte_data($this->input->post("dataRet")));
				$instancia->setDataDevolucao($this->converte_data($this->input->post("dataDev")));
				$instancia->setHora($this->input->post("hora"));
				$instancia->setIdEndereco($this->input->post("endereco"));
				$resTipos = $this->ReservaTipo_Model->getReservaTiposByReserva($id);
				$rtExists=False;
				$needsEdit=True;
				$qtdOriginal=0;
				foreach($resTipos as $rt){
					echo $rt->getIdReserva()." ".$rt->getIdTipo()."</br>";
					echo $instancia->getIdReserva()." ".$this->input->post("tipomaquina")."</br>";
					if($rt->getIdReserva() == $instancia->getIdReserva() and $this->input->post("tipomaquina")==$rt->getIdTipo()){
						$rtExists=True;
						$reservatipo = $rt;
						if($rt->getQuantidade() == $this->input->post("qtd"))
							$needsEdit=False;
					}
					$qtdOriginal+=$rt->getQuantidade();
				}
				
				$maqReser=$this->Reserva_Model->contaMaquinasReservadas($this->converte_data($this->input->post("dataRet")),$this->converte_data($this->input->post("dataDev")),$this->input->post("tipomaquina"));
				$nummaqs=$this->Maquina_Model->contarMaquinasByTipo($this->input->post("tipomaquina"));	
				$inicio = new DateTime($this->converte_data($this->input->post("dataRet")));
				$fim = new DateTime($this->converte_data($this->input->post("dataDev")));
				$teste=True;
				
				for($inicio;$inicio<=$fim;date_modify($inicio,'+1 day')){
					$total=$this->input->post("qtd");
					foreach($maqReser as $mqr){
						$itemInicio = new DateTime($mqr[0]->getDataRetirada());
						$itemFim = new DateTime($mqr[0]->getDataDevolucao());
						if($itemInicio <= $inicio and $itemFim >= $inicio)
							$total+=$mqr[1];
					}
					if($total-$qtdOriginal>$nummaqs){
						$teste=False;
						break;
					}
				}
				
				if($teste){
					$id = $this->Reserva_Model->editarReserva($instancia);
					if($id!=NULL){
						if(!$rtExists){
							$reservatipo = new ReservaTipo($instancia->getIdReserva(),$this->input->post("tipomaquina"),$this->input->post("qtd"));
							$id = $this->ReservaTipo_Model->inserirReservaTipo($reservatipo);
						} else if ($needsEdit){
							$reservatipo->setQuantidade($this->input->post("qtd"));
							$id = $this->ReservaTipo_Model->editarReservaTipo($reservatipo);
						}
						if($id==NULL){
							$data['erro'] = "ERRO EDITANDO TIPOS NA RESERVA";
						} else {
							$data['sucesso'] = "Dados editados com Sucesso";
						}
					} else {
						$data['erro'] = "ERRO EDITANDO RESERVA";
					}
				} else {
					$data['erro'] = "ERRO: NÃO HÁ MÁQUINAS DISPONÍVEIS PARA RESERVA NESSE PERIODO";
				}
				$this->load->view('reserva_edit_view', $data);
			}
		}
	}
	
	public function ReservaTipo($idR,$idT){
		$instancia=$this->ReservaTipo_Model->getReservaTipo($idR,$idT);
		$reserva=$this->Reserva_Model->getReserva($idR);
		if($this->input->post("qtd")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$idR."/".$idT;
			$data['dados']['qtd']=$instancia->getQuantidade();
			$data['tipomaquinas']=$this->TipoMaquina_Model->listarTipoMaquinas();
			$data['dados']['reserva'] = "De ".$reserva->getDataRetirada()." às ".$reserva->getHora()." até ".$reserva->getDataDevolucao();
			$this->load->view('reservatipo_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('tipomaquina', 'idTipo', 'trim|required');
			$this->form_validation->set_rules('qtd', 'Quantidade', 'trim|required|integer');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors();
				$this->load->view('reservatipo_edit_view', $data);
			} else {
				$instancia->setIdTipo($this->input->post("tipomaquina"));
				$qtdOriginal = $instancia->getQuantidade();
				$instancia->setQuantidade($this->input->post("qtd"));
				//----------------------
				$maqReser=$this->Reserva_Model->contaMaquinasReservadas($reserva->getDataRetirada(),$reserva->getDataDevolucao(),$this->input->post("tipomaquina"));
				$nummaqs=$this->Maquina_Model->contarMaquinasByTipo($this->input->post("tipomaquina"));	
				$inicio = new DateTime($reserva->getDataRetirada());
				$fim = new DateTime($reserva->getDataDevolucao());
				$teste2=True;
				
				for($inicio;$inicio<=$fim;date_modify($inicio,'+1 day')){
					$total=$this->input->post("qtd");
					foreach($maqReser as $mqr){
						$itemInicio = new DateTime($mqr[0]->getDataRetirada());
						$itemFim = new DateTime($mqr[0]->getDataDevolucao());
						if($itemInicio <= $inicio and $itemFim >= $inicio)
							$total+=$mqr[1];
					}
					if($total-$qtdOriginal>$nummaqs){
						$teste2=False;
						break;
					}
				}
				//------------------------
				
				
				$teste = $this->ReservaTipo_Model->getReservaTipo($idR,$this->input->post("idTipo"));
				if($teste==NULL){
					if($teste2){
						$id = $this->ReservaTipo_Model->editarReservaTipo($instancia,$idT);
						if($id==NULL){
							$data['erro'] = "ERRO EDITANDO TIPOS NA RESERVA";
						} else {
							$data['sucesso'] = "Dados editados com Sucesso";
						}
					} else {
						$data['erro'] = "ERRO: NÃO HÁ MÁQUINAS DISPONÍVEIS PARA RESERVA NESSE PERIODO";
					}
				} else if($teste->getQuantidade() !=  $instancia->getQuantidade()) {
					if($teste2){
						$id = $this->ReservaTipo_Model->editarReservaTipo($instancia);
						if($id==NULL){
							$data['erro'] = "ERRO EDITANDO TIPOS NA RESERVA";
						} else {
							$data['sucesso'] = "Dados editados com Sucesso";
						}
					} else {
						$data['erro'] = "ERRO: NÃO HÁ MÁQUINAS DISPONÍVEIS PARA RESERVA NESSE PERIODO";
					}
				} else {
					$data['erro'] = "TIPOS IGUAIS NA RESERVA";
				}
				$this->load->view('reservatipo_edit_view', $data);
			}
		}
	}
	
	public function TipoMaquina($id){
		$instancia=$this->TipoMaquina_Model->getTipoMaquina($id);
		if($this->input->post("desc")==NULL){
			$data['dados']=array();
			$data['dados']['id']=$id;
			$data['dados']['desc']=$instancia->getDescricao();
			$data['dados']['valor']=$instancia->getValorAluguel();
			$data['dados']['ramo']=$instancia->getRamo();
			$this->load->view('tipomaquina_edit_view', $data);
		} else {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('valor', 'valorAluguel', 'trim|required|decimal');
			$this->form_validation->set_rules('desc', 'Descricao', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('ramo', 'Descricao', 'trim|required|max_length[100]');
			if ($this->form_validation->run() == FALSE){
				$data['dados']=array();
				$data['dados']['id']=$id;
				$data['dados']['desc']=$instancia->getDescricao();
				$data['dados']['valor']=$instancia->getValorAluguel();
				$data['dados']['ramo']=$instancia->getRamo();
				$data["erro"]= "ERRO: ".validation_errors(); 
				$this->load->view('tipomaquina_edit_view',$data);
			} else{
				$instancia->setDescricao($this->input->post("desc"));
				$instancia->setValorAluguel($this->input->post("valor"));
				$instancia->setRamo($this->input->post("ramo"));
				$id = $this->TipoMaquina_Model->editarTipoMaquina($instancia);
				if($id != FALSE){
					$data['sucesso'] = "Dados inseridos com Sucesso";
				} else {
					$data["erro"] = "ERRO NA INSERÇAO DO TIPO DE MAQUINA";
				}
				$this->load->view('tipomaquina_edit_view');
			}
		}
	}
	
	private function converte_data($data){
		$data = explode("/",$data);
		$newData = $data[2].'-'.$data[1].'-'.$data[0];
		return $newData;
	}
	
	private function desconverte_data($data){
		$data = explode("-",$data);
		$newData = $data[2].'/'.$data[1].'/'.$data[0];
		echo $newData;
		return $newData;
	}
	
}

/* End of file Produtos.php */
/* Location: ./application/controllers/Produtos.php */