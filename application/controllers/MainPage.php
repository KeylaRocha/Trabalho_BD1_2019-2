<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------------------
 * CONTROLLER FILIAL
 *---------------------------------------------------------------------------
 * 
 * Responsável por controlar toda a lógica computacional da função
 * relacionadas a tela de Inicio. Tem a função de se comunicar
 * com as models e as views, fazendo as chamadas nos momentos necessários.
 *
 */

class MainPage extends CI_Controller {

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
		$filiais = $this->Filial_Model->listarFiliais();
		$data['filiais']=array();
		if($filiais == NULL)
			$filiais=array();
		foreach($filiais as $f){
			$e=$this->Enderecos_Model->getEnderecos($f->getIdEndereco());
			$data['filiais'][] = array($f->getIdFilial(),$f->getTelefone(),$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getCEP());
		}
		$data['servicos'] = $this->OperaTipo_Model->listarServicos();
		$data['maquinas'] = $this->Maquina_Model->listarMaquinas();
    	$this->load->view('filial_view', $data);
    }
	
	public function cadastro_maquinas($filial=NULL){
		if($filial==NULL){
			$filiais = $this->Filial_Model->listarFiliais();
			$data['filiais']=array();
			foreach($filiais as $f){
				$e=$this->Enderecos_Model->getEnderecos($f->getIdEndereco());
				$data['filiais'][] = array($f->getIdFilial(),$f->getTelefone(),$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getCEP());
			}
			$data['funcaodesejada']='cadastro_maquinas';
			$data['titulo']='Cadastro de Ferramentas';
			$data['descricao']='o cadastro de ferramentas';
			$this->load->view('escolhe_filial_view',$data);
		} else if($this->input->post("modelo")==NULL){
			$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
			$data['filial']=$filial;
			$this->load->view('maquina_cadastro_view', $data);
		} else {
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('modelo', 'Modelo', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('fabricante', 'Fabricante', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('numserie', 'NumeroSerie', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('filial', 'idFilial', 'trim|required');
			$this->form_validation->set_rules('tipomaquina', 'idTipo', 'trim|required');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors(); 
				$data['filial']=$filial;
				$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
				$this->load->view('maquina_cadastro_view', $data);
			} else {
				$maquina = new Maquina(NULL, $this->input->post("numserie"), $this->input->post("modelo"), $this->input->post("fabricante"), $this->input->post("filial"), $this->input->post("tipomaquina"));
				$id = $this->Maquina_Model->inserirMaquina($maquina);
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
						$data['sucesso'] = "Dados inseridos com Sucesso";
						$data['filial']=$filial;
						$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
						$this->load->view('maquina_cadastro_view',$data);
					}
					else {
						$data["erro"]= "ERRO NO UPLOAD DA IMAGEM: </br>".$this->upload->display_errors();	
						$data['filial']=$filial;
						$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
						$this->load->view('maquina_cadastro_view',$data);
					}
				} else echo "ERRO INSERINDO MAQUINA";
			}
			$this->db->close();
		}
	}
	
	public function cadastro_filiais(){
        if($this->input->post("bairro")==NULL)
			$this->load->view('filial_cadastro_view');
		else{
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
				$this->load->view('filial_cadastro_view',$data);
			} else{
				$end = new Enderecos(NULL, $this->input->post("cep"), $this->input->post("uf"), $this->input->post("cidade"), $this->input->post("bairro"),
									$this->input->post("rua"), $this->input->post("num"), $this->input->post("comp"), 1, NULL);
				$id = $this->Enderecos_Model->inserirEnderecos($end);
				if($id != FALSE){
					$filial = new Filial(NULL, $this->input->post("tel"), $id);
					$id = $this->Filial_Model->inserirFilial($filial);
				} else echo "ERRO INSERINDO ENDERECO";
				
				if($id != FALSE){
					$this->load->library('upload');
					$config['upload_path'] = './Imagens/Filial/';
					$config['file_name'] = $id;
					$config['allowed_types'] = 'jpg';
					$config['max_size']	= '2048';
					$this->upload->initialize($config);
					if ($this->upload->do_upload('foto') == TRUE) {
						$upload_data = $this->upload->data();
						$nome_do_arquivo_gravado = $upload_data['file_name'];
						$data['sucesso'] = "Dados inseridos com Sucesso";
						$this->load->view('filial_cadastro_view',$data);
					}
					else {
						$data["erro"]= "ERRO NO UPLOAD DA IMAGEM: </br>".$this->upload->display_errors();	
						$this->load->view('filial_cadastro_view',$data);
					}
				} else echo "ERRO INSERINDO FILIAL";
			}
			$this->db->close();
		}
	}
	
	public function cadastro_operadores(){
		if($this->input->post("nome")==NULL){
			$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
			$this->load->view('operador_cadastro_view',$data);
		} else {
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('nome', 'Nome', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('celular', 'Celular', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('valorhora', 'ValorHora', 'trim|required|decimal');
			$this->form_validation->set_rules('tipomaquina', 'IdTipo', 'trim|required');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors();
				$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
				$this->load->view('operador_cadastro_view',$data);
			} else{
				$operador = new Operador(NULL, $this->input->post("nome"), $this->input->post("celular"), $this->input->post("valorhora"));
				$id=$this->Operador_Model->inserirOperador($operador);
				$erro=array();
				if($id != FALSE){
					foreach(explode(",",$this->input->post("tipomaquina")) as $idTipo){
						$operatipo = new OperaTipo(intval($idTipo),$id);
						if(!$this->OperaTipo_Model->inserirOperaTipo($operatipo)){
							$erro[] = "Erro na inserção do tipo ".$idTipo."<\br>";
						}
					}
				} else {
					$erro[] = "ERRO NA INSERÇAO DO OPERADOR";
				}
				if(count($erro)>0){
					$data["erro"]=implode(" ",$erro);
					$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
					$this->load->view('operador_cadastro_view',$data);
				} else {
					$data['sucesso'] = "Dados inseridos com Sucesso";
					$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
					$this->load->view('operador_cadastro_view',$data);
				}
				$this->db->close();
			}
		}
	}
	
	public function cadastro_tipomaquinas(){
		if($this->input->post("valor")==NULL)
			$this->load->view('tipomaquina_cadastro_view');
		else{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('valor', 'valorAluguel', 'trim|required|decimal');
			$this->form_validation->set_rules('desc', 'Descricao', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('ramo', 'Descricao', 'trim|required|max_length[100]');
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors(); 
				$this->load->view('tipomaquina_cadastro_view');
			} else{
				$tipomaquina = new TipoMaquina(NULL,$this->input->post("valor"),$this->input->post("desc"),$this->input->post("ramo"));
				$id = $this->TipoMaquina_Model->inserirTipoMaquina($tipomaquina);
				if($id != FALSE){
					$data['sucesso'] = "Dados inseridos com Sucesso";
				} else {
					$data["erro"] = "ERRO NA INSERÇAO DO TIPO DE MAQUINA";
				}
				$this->load->view('tipomaquina_cadastro_view');
			}
		}
	}
	
	public function cadastro_clientes(){
		if($this->input->post("cliente")==NULL){
			$this->load->view('cliente_cadastro_view');
		} else {
			$this->load->library('form_validation');
			if($this->input->post("tipocliente")=='fisica'){
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[11]');
				$this->form_validation->set_rules('nasc', 'DataNascimento', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
			}else{
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('razaosoc', 'RazaoSocial', 'trim|required|max_length[100]');
				$this->form_validation->set_rules('repr', 'Representante', 'trim|required|max_length[200]');
			}
			$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
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
				$this->load->view('cliente_cadastro_view',$data);
			} else{
				if($this->input->post("tipocliente")=='fisica'){
					$cliente = new PessoaFisica(NULL,$this->input->post("cliente"),$this->converte_data($this->input->post("nasc")),$this->input->post("nome"),$this->input->post("tel"),$this->input->post("email"));
					$id = $this->PessoaFisica_Model->inserirPessoaFisica($cliente);
				} else {
					$cliente = new PessoaJuridica(NULL,$this->input->post("cliente"),$this->input->post("razaosoc"),$this->input->post("repr"),$this->input->post("nome"),$this->input->post("tel"),$this->input->post("email"));
					$id = $this->PessoaJuridica_Model->inserirPessoaJuridica($cliente);
				}
				
				if($id != FALSE){
					$end = new Enderecos(NULL, $this->input->post("cep"), $this->input->post("uf"), $this->input->post("cidade"), $this->input->post("bairro"),
									$this->input->post("rua"), $this->input->post("num"), $this->input->post("comp"), 1, $id);
					$id = $this->Enderecos_Model->inserirEnderecos($end);
				} else $data['erro'] = "ERRO INSERINDO CLIENTE</br>";
				
				if($id != FALSE){
					$data['sucesso'] = "Dados inseridos com Sucesso";
					$this->load->view('cliente_cadastro_view',$data);
				} else {
					$data['erro'] += "ERRO INSERINDO ENDERECO";
					$this->load->view('cliente_cadastro_view',$data);
				}
				
			}
		}
	}
	
	public function cadastro_enderecos(){
		if($this->input->post("bairro")==NULL){
			$this->load->view('endereco_cadastro_view');
		} else {
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
			$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
			$this->form_validation->set_rules('bairro', 'Bairro', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('cidade', 'Cidade', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('rua', 'Rua', 'trim|required|max_length[200]');
			$this->form_validation->set_rules('num', 'Número', 'trim|required');
			$this->form_validation->set_rules('comp', 'Complemento', 'trim');
			$this->form_validation->set_rules('cep', 'CEP', 'trim|required|max_length[8]');
			$this->form_validation->set_rules('uf', 'Estado', 'trim|required|max_length[50]');
			
			if ($this->form_validation->run() == FALSE){
				$data["erro"]= "ERRO: ".validation_errors();
				$this->load->view('endereco_cadastro_view',$data);
			} else{
				if($this->input->post("tipocliente")=='fisica')
					$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
				else
					$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
				if($cliente == NULL){
					$data["erro"]= "ERRO: Cliente não existe!</br>";	
					$this->load->view('endereco_cadastro_view',$data);
				}else{
					$end = new Enderecos(NULL, $this->input->post("cep"), $this->input->post("uf"), $this->input->post("cidade"), $this->input->post("bairro"),
										$this->input->post("rua"), $this->input->post("num"), $this->input->post("comp"), 0, $cliente->getIdCliente());
					$id = $this->Enderecos_Model->inserirEnderecos($end);
					if($id != FALSE){
						$data['sucesso'] = "Dados inseridos com Sucesso";
						$this->load->view('endereco_cadastro_view',$data);
					} else {
						$data["erro"]= "ERRO INSERINDO ENDERECO";
						$this->load->view('endereco_cadastro_view',$data);
					}
				}
			}
		}
	}
	
	public function reserva(){
		if($this->input->post("cliente") == NULL){
			$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
			$this->load->view('reserva_view',$data);
		} else {
			if($this->input->post("endereco") == NULL){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
				
				$data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
				if ($this->form_validation->run() == FALSE){
					$data["erro"]= "ERRO: ".validation_errors();
					$this->load->view('reserva_view',$data);
				} else {
					if($this->input->post("tipocliente")=='fisica')
						$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
					else
						$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
					if($cliente != NULL){
						 $end = $this->Enderecos_Model->listarEnderecosByCliente($cliente->getIdCliente());
						 if($end != NULL){
							 $data['enderecos'] = array();
							 foreach($end as $e){
								$data['enderecos'][] = array($e->getIdEndereco(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP());
							 }
						 }else
							 $data["erro"]= "ERRO: Cliente sem endereços";
					} else 
						$data["erro"]= "ERRO: Cliente não existente";
					 $data['post_data']=$_POST;
					$this->load->view('reserva_view',$data);
				}
			} else {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
				$this->form_validation->set_rules('dataRet', 'DataRetirada', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
				$this->form_validation->set_rules('dataDev', 'DataDevolucao', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
				$this->form_validation->set_rules('hora', 'Hora', 'trim|required|regex_match[/\d\d:\d\d:\d\d/]');
				$this->form_validation->set_rules('tipomaquina', 'idTipo', 'trim|required');
				$this->form_validation->set_rules('qtd', 'Quantidade', 'trim|required|integer');
				$this->form_validation->set_rules('endereco', 'IdEndereco', 'trim|required|integer');
				
				if ($this->form_validation->run() == FALSE){
					$data["erro"]= "ERRO: ".validation_errors();
					if($this->input->post("tipocliente")=='fisica')
						$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
					else
						$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
					$end = $this->Enderecos_Model->listarEnderecosByCliente($cliente->getIdCliente());
					 $data['enderecos'] = array();
					 foreach($end as $e){
						$data['enderecos'][] = array($e->getIdEndereco(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP());
					 }
					 $data['post_data']=$_POST;
					$this->load->view('reserva_view',$data);
				} else {
					if($this->input->post("tipocliente")=='fisica')
						$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
					else
						$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
					$reserva = new Reserva(NULL,$this->input->post("hora"),$this->converte_data($this->input->post("dataRet")),
					$this->converte_data($this->input->post("dataDev")),$cliente->getIdCliente(),$this->input->post("endereco"));
					
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
						if($total>$nummaqs){
							$teste=False;
							break;
						}
					}
					if($teste){
						$id = $this->Reserva_Model->inserirReserva($reserva);
						if($id != FALSE){
							$reservatipo = new ReservaTipo($id,$this->input->post("tipomaquina"),$this->input->post("qtd"));
							$id = $this->ReservaTipo_Model->inserirReservaTipo($reservatipo);
						} else $data['erro'] = "ERRO INSERINDO RESERVA";
						
						if($id != FALSE){
							$data['sucesso'] = "Dados inseridos com Sucesso";
							$this->load->view('reserva_view',$data);
						} else {
							$data['erro'] = $data['erro']."</br> ERRO INSERINDO RESERVATIPO";
							$this->load->view('reserva_view',$data);
						}
					} else {
						$data['erro'] = "ERRO: NÃO HÁ MÁQUINAS DISPONÍVEIS PARA RESERVA NESSE PERIODO";
						$this->load->view('reserva_view',$data);
					}
				}
				
			}
		}
	}
	
	public function aluguel_retirada($filial=NULL){
		if($filial==NULL){
			$filiais = $this->Filial_Model->listarFiliais();
			$data['filiais']=array();
			foreach($filiais as $f){
				$e=$this->Enderecos_Model->getEnderecos($f->getIdEndereco());
				$data['filiais'][] = array($f->getIdFilial(),$f->getTelefone(),$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getCEP());
			}
			$data['funcaodesejada']='aluguel_retirada';
			$data['titulo']='Retirada de Ferramenta para Aluguel';
			$data['descricao']='a retirada de ferramenta';
			$this->load->view('escolhe_filial_view',$data);
		} else if($this->input->post("cliente") == NULL){
			$data['servicos'] = $this->OperaTipo_Model->listarServicos();
			$data['filial']=$filial;
			$this->load->view('aluguel_retirada_view',$data);
		} else {
			if($this->input->post("carregarRes") != NULL  and $this->input->post("endereco") == NULL){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
				
				
				if ($this->form_validation->run() == FALSE){
					$data["erro"]= "ERRO: ".validation_errors();
					$data['filial']=$filial;
					$data['servicos'] = $this->OperaTipo_Model->listarServicos();
					$this->load->view('aluguel_retirada_view',$data);
				} else {
					if($this->input->post("tipocliente")=='fisica'){
						$res = $this->Reserva_Model->listarReservasAtivasPessoaFisica($this->input->post("cliente"));
					}else{
						$res = $this->Reserva_Model->listarReservasAtivasPessoaJuridica($this->input->post("cliente"));
					}
					 if($res != NULL){
						 $data['reservas'] = array();
						 foreach($res as $r){
							$data['reservas'][] = array($r[0]->getIdReserva(),"De ".$r[0]->getDataRetirada()." às ".$r[0]->getHora()." até ".$r[0]->getDataDevolucao());
						 }
					 }else{
						 $data["erro"]= "AVISO: Cliente sem reservas</br>";
						 $data["reservas"]= array();
					 }
						 if($this->input->post("tipocliente")=='fisica')
							$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
 						 else
							$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
						if($cliente != NULL){
							 $end = $this->Enderecos_Model->listarEnderecosByCliente($cliente->getIdCliente());
							 $data['enderecos'] = array();
							 foreach($end as $e){
								$data['enderecos'][] = array($e->getIdEndereco(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP());
							 }
						} else $data["erro"]+= "AVISO: Cliente Inexistente";
						 $data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
					 
					 $data['post_data']=$_POST;
					 $data['servicos'] = $this->OperaTipo_Model->listarServicos();
					 $data['filial']=$filial;
					$this->load->view('aluguel_retirada_view',$data);
				}
			} else {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
				$this->form_validation->set_rules('dataRet', 'DataRetirada', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
				$this->form_validation->set_rules('taxa', 'Taxa', 'trim|required|decimal');
				$this->form_validation->set_rules('seguro', 'TemSeguro', 'trim|required');
				$this->form_validation->set_rules('operador', 'Servico', 'trim');
				$this->form_validation->set_rules('filial', 'Filial', 'trim|required');
				
				if($this->input->post("reserva")!=NULL){
					$this->form_validation->set_rules('reserva', 'Reserva', 'trim|required');
				} else {
					$this->form_validation->set_rules('dataDev', 'DataDevolucao', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
					$this->form_validation->set_rules('tipomaquina', 'idTipo', 'trim|required');
					$this->form_validation->set_rules('qtd', 'Quantidade', 'trim|required|decimal');
					$this->form_validation->set_rules('endereco', 'IdEndereco', 'trim|required|integer');
				}
				
				if ($this->form_validation->run() == FALSE){
					$data["erro"]= "ERRO: ".validation_errors();
					if($this->input->post("tipocliente")=='fisica'){
						$res = $this->Reserva_Model->listarReservasAtivasPessoaFisica($this->input->post("cliente"));
					}else{
						$res = $this->Reserva_Model->listarReservasAtivasPessoaJuridica($this->input->post("cliente"));
					}
					 if($res != NULL){
						 $data['reservas'] = array();
						 foreach($res as $r){
							$data['reservas'][] = array($r[0]->getIdReserva(),"De ".$r[0]->getDataRetirada()." às ".$r[0]->getHora()." até ".$r[0]->getDataDevolucao());
						 }
					 }else{
						 $data["erro"]+= "AVISO: Cliente sem reservas";
						 $data["reservas"]= array();
						 if($this->input->post("tipocliente")=='fisica')
							$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
 						 else
							$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
						 $end = $this->Enderecos_Model->listarEnderecosByCliente($cliente->getIdCliente());
						 $data['enderecos'] = array();
						 foreach($end as $e){
							$data['enderecos'][] = array($e->getIdEndereco(),$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP());
						 }
						 $data['tipomaquinas'] = $this->TipoMaquina_Model->listarTipoMaquinas();
					 }
					 $data['post_data']=$_POST;
					 $data['servicos'] = $this->OperaTipo_Model->listarServicos();
					 $data['filial']=$filial;
					$this->load->view('aluguel_retirada_view',$data);
				} else {
					if($this->input->post("reserva")!=NULL){
						if($this->input->post("operador")!=NULL){
							$operadores = $this->Operador_Model->listarOperadoresMaisOciososByTipo($this->input->post("operador"));
							if($operadores == NULL){
								$data['erro'] = "ERRO: Sem Operadores para esse Tipo de Máquina!</br>";
								$this->load->view('aluguel_retirada_view',$data);
							} else {
								$reservatipos = $this->ReservaTipo_Model->getReservaTiposByReserva($this->input->post("reserva"));
								$data['erro'] = "";
								$temSeguro = 0;
								if($this->input->post("seguro")==1)
									$temSeguro = 1;
								foreach($reservatipos as $reservatipo){
									
									$maquinas = $this->Maquina_Model->listarMaquinasDisponiveisByTipoEFilial($reservatipo->getIdTipo(),$this->input->post("filial"));
									if($maquinas == NULL){
										$data['erro'] += "ERRO: Sem Máquinas desse Tipo disponíveis!";
									} else {
										if($operadores[0][2] == $maquinas[0]->getIdTipo())
											$aluguel = new Aluguel(NULL,NULL,$this->converte_data($this->input->post("dataRet")),$temSeguro,NULL,$this->input->post("taxa"),$maquinas[0]->getIdMaquina(),$this->input->post("reserva"),NULL,$operadores[0][0]->getIdOperador()); 
										else
											$aluguel = new Aluguel(NULL,NULL,$this->converte_data($this->input->post("dataRet")),$temSeguro,NULL,$this->input->post("taxa"),$maquinas[0]->getIdMaquina(),$this->input->post("reserva"),NULL,NULL); 
										$id = $this->Aluguel_Model->inserirAluguel($aluguel);
										
										if($id == FALSE){
											$data['erro'] += "ERRO INSERINDO ALUGUEL PARA MAQUINA DO TIPO ".$idTipo."</br>";
										}
									}
								}
								if($data['erro'] == ""){
									$data['sucesso'] = "Dados inseridos com Sucesso";
								}
								$this->load->view('aluguel_retirada_view',$data);
							}
						}else {
							$reservatipos = $this->ReservaTipo_Model->getReservaTiposByReserva($this->input->post("reserva"));
							$data['erro'] = "";
							foreach($reservatipos as $reservatipo){
								$maquinas = $this->Maquina_Model->listarMaquinasDisponiveisByTipoEFilial($reservatipo->getIdTipo(),$this->input->post("filial"));
								if($maquinas == NULL){
									$data['erro'] += "ERRO: Sem Máquinas desse Tipo disponíveis!</br>";
								} else {
									$aluguel = new Aluguel(NULL,NULL,$this->converte_data($this->input->post("dataRet")),$this->input->post("seguro"),NULL,$this->input->post("taxa"),
									$maquinas[0]->getIdMaquina(),$this->input->post("reserva"),NULL,NULL); 
									$id = $this->Aluguel_Model->inserirAluguel($aluguel);
								
									if($id == FALSE){
										$data['erro'] += "ERRO INSERINDO ALUGUEL PARA MAQUINA DO TIPO ".$idTipo."</br>";
									}
									
								}
							}
							if($data['erro'] == ""){
								$data['sucesso'] = "Dados inseridos com Sucesso";
							}
							$this->load->view('aluguel_retirada_view',$data);
						}
					} else {
						if($this->input->post("tipocliente")=='fisica')
							$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
						else
							$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
						$reserva = new Reserva(NULL,"00:00:00",$this->converte_data($this->input->post("dataRet")),$this->converte_data($this->input->post("dataDev")),
						$cliente->getIdCliente(),$this->input->post("endereco"));
						
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
							if($total>$nummaqs){
								$teste=False;
								break;
							}
						}
						if($teste){
							$id = $this->Reserva_Model->inserirReserva($reserva);
							$idReserva = $id;
							$data['erro'] ="";
							if($id != FALSE){
								$reservatipo = new ReservaTipo(NULL,$this->input->post("tipomaquina"),$this->input->post("qtd"));
								$id=$this->ReservaTipo_Model->inserirReservaTipo($reservatipo);
							} else $data['erro'] = "ERRO INSERINDO RESERVA</br>";
							
							if($id != FALSE){
								$operadores = $this->Operador_Model->listarOperadoresMaisOciososByTipo($this->input->post("operador"));
								if($operadores == NULL){
									$data['erro'] += "ERRO: Sem Operadores para esse Tipo de Máquina!";
								} else {
									$maquinas = $this->Maquina_Model->listarMaquinasDisponiveisByTipoEFilial($this->input->post("tipomaquina"),
									$this->input->post("filial"));
									
									$aluguel = new Aluguel(NULL,NULL,$this->converte_data($this->input->post("dataRet")),$this->input->post("seguro"),NULL,$this->input->post("taxa"),
									$maquinas[0]->getIdMaquina(),$idReserva,NULL,$operadores[0]->getIdOperador());
									$id = $this->Aluguel_Model->inserirAluguel($aluguel);
								}
							}  else $data['erro'] += "ERRO INSERINDO RESERVATIPO</br>";
							
							if($id != FALSE){
								$data['sucesso'] = "Dados inseridos com Sucesso";
								$this->load->view('aluguel_retirada_view',$data);
							} else {
								$data['erro'] += "ERRO INSERINDO ALUGUEL";
								$this->load->view('aluguel_retirada_view',$data);
							}
						} else {
							$data['erro'] += "ERRO: NÃO HÁ MÁQUINAS DISPONÍVEIS PARA RESERVA NESSE PERIODO";
							$this->load->view('aluguel_retirada_view',$data);
						}
					}
				}
			}
		}
	}
	
	public function aluguel_devolucao(){
		if($this->input->post("carregarAlg") == NULL and $this->input->post("cliente") == NULL){
			$this->load->view('aluguel_devolucao_view');
		} else {
			if($this->input->post("aluguel") == NULL){
				$this->load->library('form_validation');
					
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
				
				if ($this->form_validation->run() == FALSE){
					$data["erro"]= "ERRO: ".validation_errors();
					$this->load->view('aluguel_devolucao_view',$data);
				} else {
					if($this->input->post("tipocliente")=='fisica')
						$cliente = $this->PessoaFisica_Model->getPessoaFisicaByCPF($this->input->post("cliente"));
					else
						$cliente = $this->PessoaJuridica_Model->getPessoaJuridicaByCNPJ($this->input->post("cliente"));
					
					if($cliente!=NULL) {
						 $alugueiscliente = $this->Aluguel_Model->listarAlugueisByClienteADevolver($cliente->getIdCliente());
						 $data["alugueis"] = array();
						if($alugueiscliente == NULL)
							$data["erro"]= "ERRO: Cliente SEM ALUGUEIS!";
						else {
							foreach($alugueiscliente as $alg){
								$data["alugueis"][] = array($alg[0]->getIdAluguel(),$alg[1]->getModelo().' da Fabricante '.$alg[1]->getFabricante().' Série '.$alg[1]->getNumeroSerie().' Alugado em '.$alg[0]->getDataRetEfetiva());
							}
						}
						
					} else 
						$data["erro"]= "ERRO: Cliente Inexistente!";
					$data['post_data']=$_POST;
					$this->load->view('aluguel_devolucao_view',$data);
				}

			} else {			
				$this->load->library('form_validation');
					
				$this->form_validation->set_rules('cliente', 'Cliente', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('tipocliente', 'TipoCliente', 'trim|required');
				$this->form_validation->set_rules('dataDev', 'DataDevolucao', 'trim|required|regex_match[/\d\d\/\d\d\/\d\d\d\d/]');
				$this->form_validation->set_rules('taxa', 'Taxa', 'trim|required|decimal');
				$this->form_validation->set_rules('manut', 'Manutencao', 'trim|required');
				$this->form_validation->set_rules('aluguel', 'Aluguel', 'trim|required');
				$this->form_validation->set_rules('tempo', 'Tempo', 'trim|integer');
				$this->form_validation->set_rules('custo', 'Custo', 'trim|decimal');
				if ($this->form_validation->run() == FALSE){
					$data["erro"]= "ERRO: ".validation_errors();
					$data['post_data']=$_POST;
					$this->load->view('aluguel_devolucao_view',$data);
				} else {
					$aluguel = $this->Aluguel_Model->getAluguel($this->input->post("aluguel"));
					$aluguel->setDataDevEfetiva($this->converte_data($this->input->post("dataDev")));
					$aluguel->setTaxa($aluguel->getTaxa()+$this->input->post("taxa"));

					if($this->input->post("manut")=="S"){
						$dataSaida = date_create(date('Y-m-d'));
						date_add($dataSaida, date_interval_create_from_date_string($this->input->post("tempo").' days'));
						$manutencao = new Manutencao(NULL,date('Y-m-d'),date_format($dataSaida, 'Y-m-d'),$this->input->post("custo"),$aluguel->getIdMaquina());
						
						$id=$this->Manutencao_Model->inserirManutencao($manutencao);
						if($id==NULL){
							$data['erro']="ERRO INSERINDO MANUTENCAO";
							$data['post_data']=$_POST;
							$this->load->view('aluguel_devolucao_view',$data);
						} else {
							$aluguel->setIdManutencao($id);
							$custoTotal = $aluguel->getTaxa();
							if($aluguel->getTemSeguro() == 0){
								$custoTotal += $this->input->post("custo");
							}
							if($aluguel->getIdMaquina()!=NULL){
								$maq = $this->Maquina_Model->getMaquina($aluguel->getIdMaquina());
								$tipoMaq = $this->TipoMaquina_Model->getTipoMaquina($maq->getIdTipo());
								$custoTotal += $tipoMaq->getValorAluguel();
							}
							if($aluguel->getIdOperador() != NULL){
								$op = $this->Operador_Model->getOperador($aluguel->getIdOperador());
								$inicio = new DateTime($aluguel->getDataRetEfetiva());
								$fim = new DateTime($aluguel->getDataDevEfetiva());
								$horas = $fim->diff($inicio)->d * 8;
								$custoTotal += $op->getValorHora()*$horas;
							}
							$aluguel->setValorTotal($custoTotal);
							$id = $this->Aluguel_Model->editarAluguel($aluguel);
							if($id==NULL){
								$data['erro']="ERRO EDITANDO ALUGUEL";
								$data['post_data']=$_POST;
								$this->load->view('aluguel_devolucao_view',$data);
							} else {
								$data['sucesso'] = "Dados inseridos com Sucesso";
								$this->load->view('aluguel_devolucao_view',$data);
							}
						}
					} else {
						$custoTotal = $aluguel->getTaxa();
						if($aluguel->getIdMaquina()!=NULL){
							$maq = $this->Maquina_Model->getMaquina($aluguel->getIdMaquina());
							$tipoMaq = $this->TipoMaquina_Model->getTipoMaquina($maq->getIdTipo());
							$custoTotal += $tipoMaq->getValorAluguel();
						}
						if($aluguel->getIdOperador() != NULL){
							$op = $this->Operador_Model->getOperador($aluguel->getIdOperador());
							$inicio = new DateTime($aluguel->getDataRetEfetiva());
							$fim = new DateTime($aluguel->getDataDevEfetiva());
							$horas = $fim->diff($inicio)->d * 8;
							$custoTotal += $op->getValorHora()*$horas;
						}
						$aluguel->setValorTotal($custoTotal);
						$id = $this->Aluguel_Model->editarAluguel($aluguel);
						if($id==NULL){
							$data['erro']="ERRO EDITANDO ALUGUEL";
							$data['post_data']=$_POST;
							$this->load->view('aluguel_devolucao_view',$data);
						} else {
							$data['sucesso'] = "Dados inseridos com Sucesso";
							$this->load->view('aluguel_devolucao_view',$data);
						}
					}
				}
			}
		}
		
	}
	
	public function reservas_em_aberto(){
		$data['reservas'] = $this->Reserva_Model->listarReservasAtivasPessoaFisica();
		array_merge($data['reservas'],$this->Reserva_Model->listarReservasAtivasPessoaJuridica());
		$this->load->view('reservas_abertas_view', $data);
	}
	
	public function alugueis_em_andamento(){
		$alugueis = $this->Aluguel_Model->listarAlugueisADevolver();
		$data['alugueis']=array();
		if($alugueis!=NULL)
			foreach($alugueis as $a){
				$fisica = $this->PessoaFisica_Model->getPessoaFisica($a[2]);
				$juridica = $this->PessoaJuridica_Model->getPessoaJuridica($a[2]);
				if($fisica != NULL)
					$data['alugueis'][] = array($a[0],$a[1],$fisica,$a[3]);
				else
					$data['alugueis'][] = array($a[0],$a[1],$juridica,$a[3]);
			}
		$this->load->view('alugueis_em_andamento_view', $data);
	}
	
	public function relatorio_manutencao(){
		$manutencoes = $this->Manutencao_Model->listarManutencoesCompleta();
		$data['manuts']=array();
		if($manutencoes!=NULL)
			foreach($manutencoes as $m){
				$e=$this->Enderecos_Model->getEnderecos($m[2]);
				$data['manuts'][]=array($m[0],$m[1],$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP(),$m[3]);
			}
		$this->load->view('relatorio_manutencao_view', $data);
	}
	
	public function maquinas_novas(){
		$maquinas = $this->Maquina_Model->listarMaquinasNovas();
		$data['maqs']=array();
		if($maquinas!=NULL)
			foreach($maquinas as $m){
				$e=$this->Enderecos_Model->getEnderecos($m[1]);
				$data['maqs'][]=array($m[0],$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP(),$m[2]);
			}
		$this->load->view('maquinas_novas_view', $data);
	}
	
	private function compara_faturamentos($a,$b){
		
	}
	
	public function clientes_faturamento(){
		$pessoasF = $this->PessoaFisica_Model->listarPessoasFisicasByFaturamento();
		$pessoasJ = $this->PessoaJuridica_Model->listarPessoasJuridicasByFaturamento();
		$clientes = array_merge($pessoasF,$pessoasJ);
		usort($clientes,function($a,$b){
							if ($a[1] == $b[1]) {
							return 0;
						}
						return ($a[1] > $b[1]) ? -1 : 1;
			  });
		$data['clientes']=array();
		if($clientes!=NULL)
			foreach($clientes as $c){
				$end=$this->Enderecos_Model->listarEnderecosByCliente($c[0]->getIdCliente());
				foreach($end as $e){
					if($e->getEhPrincipal()==1){
						$data['clientes'][] = array($c[0],$e->getRua().", ".$e->getNumero().", ".$e->getComplemento()." - ".$e->getBairro().", ".$e->getCidade()." - ".$e->getEstado().", ".$e->getCEP(),$c[1]);
						break;
					}
				}
			}
		$this->load->view('clientes_faturamento_view', $data);
	}
	
	
	public function navegacao(){
		$this->load->view('navegacao_view');
	}
	
	public function relatorios(){
		$this->load->view('relatorios_view');
	}
	
	private function converte_data($data){
		$data = explode("/",$data);
		$newData = $data[2].'-'.$data[1].'-'.$data[0];
		return $newData;
	}
	
	
	public function ferramentas_disp($idFilial){
		$data['servicos'] = $this->OperaTipo_Model->listarServicosByFilial($idFilial);
		$data['maquinas'] = $this->Maquina_Model->listarMaquinasByFilial($idFilial);
		$this->load->view('ferramentas_disp_view',$data);
	}
	
	public function tipos_de_ferramentas($idTipo){
		$operatipos = $this->OperaTipo_Model->getOperaTipoByTipo($idTipo);
		if(count($operatipos)>0)
			$data['servicos']=array($this->TipoMaquina_Model->getTipoMaquina($idTipo));
		$data['maquinas'] = $this->Maquina_Model->listarMaquinasByTipo($idTipo);
		$this->load->view('ferramentas_disp_view',$data);
	}
	
}

/* End of file Produtos.php */
/* Location: ./application/controllers/Produtos.php */