<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipostatusconstrucao extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dci/Tipostatusconstrucao_model');
	}

	/**
	*	Função para validar se o ID enviado via GET representa um registro existente no banco de dados
	*	@access private
	*	@return false se o objeto não existir e o objeto caso existir
	*/
	
	private function validateGetId()
	{
		$tsc = Tipostatusconstrucao_model::getById($this->input->get('id'));
		if (!$tsc){
			$this->session->set_flashdata('erro','Registro não localizado');	
			redirect(makeUrl('dci','tipostatusconstrucao','visualizar'));
			exit();
		}
		return $tsc;
	}

	/**
	* Inserir registro
	*/

	public function inserir()
	{
		$this->title = "Inserir tipo de status de construção - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipostatusconstrucao/inserir');
	}

	/**
	* Editar registro
	*/

	public function editar()
	{
		$tsc = $this->validateGetId();
		$this->data['tipostatusconstrucao'] = $tsc;
		$this->title = "Editar tipo de status de construção - Yoopay - Soluções Tecnológicas";
		$this->loadview('dci/tipostatusconstrucao/inserir');
	}

	/**
	* Chamada ao controlador sem nenhum método
	*/

	public function index()
	{
		$this->visualizar();
	}

	/**
	* Lista de registros
	*/

	public function visualizar()
	{
		$this->title = "Visualizar tipos de status de construção - Yoopay - Soluções Tecnológicas";
		$this->data['tipos'] = $this->Tipostatusconstrucao_model->getAll();
		$this->loadview('dci/tipostatusconstrucao/lista');
	}

	/**
	* Validar registro e adicionar ao banco
	*/

	public function insert()
	{
		$this->Tipostatusconstrucao_model->descricao = $this->input->post('cnometsc');
		if ($this->Tipostatusconstrucao_model->validaInsercao()){
			$this->Tipostatusconstrucao_model->save();
			$this->session->set_flashdata('sucesso','Tipo cadastrado com sucesso');
			redirect(makeUrl('dci','tipostatusconstrucao','visualizar'));
		} else {
			$this->session->set_flashdata('erro',$this->Tipostatusconstrucao_model->error);
			$this->session->set_flashdata('cnometsc',$this->Tipostatusconstrucao_model->descricao);
			redirect(makeUrl('dci','tipostatusconstrucao','inserir'));
			return;
		}
	}

	/**
	* Atualizar registro
	*/

	public function update()
	{
		$this->Tipostatusconstrucao_model->id = $this->validateGetId()->nidtbxtsc;
		$this->Tipostatusconstrucao_model->descricao = $this->input->post('cnometsc');
		if ($this->Tipostatusconstrucao_model->validaAtualizacao()){
			$this->Tipostatusconstrucao_model->save();
			$this->session->set_flashdata('sucesso','Tipo atualizado com sucesso');
			redirect(makeUrl('dci','tipostatusconstrucao','editar','?id='.$this->Tipostatusconstrucao_model->id));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipostatusconstrucao_model->error);
		$this->session->set_flashdata('cnometsc',$this->Tipostatusconstrucao_model->descricao);
		redirect(makeUrl('dci','tipostatusconstrucao','editar','?id='.$this->Tipostatusconstrucao_model->id));
		return;
	}

	/**
	* Excluir cadastro (Setar data de exclusão e mudar campo ativo para 0)
	*/

	public function excluir()
	{
	 	$this->Tipostatusconstrucao_model->id = $this->validateGetId()->nidtbxtsc;
		if ($this->Tipostatusconstrucao_model->isAtivo()){
			$this->Tipostatusconstrucao_model->nidtbxsegusu_exclusao = $this->session->userdata('nidtbxsegusu');
			$this->Tipostatusconstrucao_model->delete();
			$this->session->set_flashdata('sucesso','Tipo desativado com sucesso');
			redirect(makeUrl('dci','tipostatusconstrucao','visualizar'));
			return;
		}
		$this->session->set_flashdata('erro',$this->Tipostatusconstrucao_model->error);
		redirect(makeUrl('dci','tipostatusconstrucao','visualizar'));
	}
}