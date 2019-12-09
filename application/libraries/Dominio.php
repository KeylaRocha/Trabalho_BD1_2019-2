<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *---------------------------------------------------------------
 * DOMÍNIO
 *---------------------------------------------------------------
 * 
 * A Library 'Domínio' é usada para incluir automaticamente todas
 * as classes que são usadas no código, de forma semelhante ao
 * recurso Auto-load do CodeIgniter, com a vantagem de que
 * podemos escolher quando carregar ou não essas classes.
 *
 */

class Dominio {
	
	public function __construct()
	{
		require_once('Administrador.php');
		require_once('Aluguel.php');
		require_once('Enderecos.php');
		require_once('Filial.php');
		require_once('Manutencao.php');
		require_once('Maquina.php');
		require_once('Operador.php');
		require_once('OperaTipo.php');
		require_once('PessoaFisica.php');
		require_once('PessoaJuridica.php');
		require_once('Reserva.php');
		require_once('ReservaTipo.php');
		require_once('TipoMaquina.php');
	}
}

/* End of file Dominio.php */
/* Location: ./application/libraries/Dominio.php */