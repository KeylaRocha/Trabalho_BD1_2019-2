<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------------------
 * CONTROLLER PRODUTO
 *---------------------------------------------------------------------------
 * 
 * Responsável por controlar toda a lógica computacional da função
 * relacionadas a tela de Inicio. Tem a função de se comunicar
 * com as models e as views, fazendo as chamadas nos momentos necessários.
 *
 */

class Produto extends CI_Controller {

    /**
     * Construtor
     */
	function __construct() {

        // Chama todas as models e bibliotecas necessárias no controller
        parent::__construct();
        $this->load->model('maquina_model', 'Maquina_Model');
        $this->load->model('operatipo_model', 'OperaTipo_Model');
    }

    /**
     * Carrega a página de inicio dos congressistas
     */
    public function index() {
		$data['servicos'] = $this->OperaTipo_Model->listarServicos();
		$data['maquinas'] = $this->Maquina_Model->listarMaquinas();
    	$this->load->view('produtos_view', $data);
    }
}

/* End of file Produtos.php */
/* Location: ./application/controllers/Produtos.php */