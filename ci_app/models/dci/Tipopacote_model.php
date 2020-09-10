<?php
	class Tipopacote_model extends MY_Model {

		/* Nome da tabela no banco de dados */	
		protected static $_table = "tbxpac";
		/* Nome do campo id na tabela */
		protected static $_idfield = "nidtbxpac";
		
		/**
		* Função que valida se o registro pode ser adicionado ao banco de dados
		* @access public
		* @return true se o campo não está em branco e se não existe nenhum registro igual no banco, false no contrário
		*/
		
		public function validaInsercao()
		{
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;					
			}
			/* Verifica se já existe um tipo de pacote com esta descrição */
			$pac = $this->db->where(['nativo'=>1, 'cnomepac'=>$this->descricao])->get(self::$_table)->row();
			if ($pac){
				$this->error = 'Já existe um tipo de pacote com a descrição "'.$this->descricao.'"';
				return false;
			}
			return true;
		}
		
		/**
		* Função que valida se o registro pode ser atualizado no banco de dados
		* @access public
		* @return true se não está em branco e se não existe nenhum registro igual no banco (com ID diferente ao dele), false no contrário
		*/		
		
		public function validaAtualizacao()
		{
			if (!$this->descricao){
				$this->error = 'Campo em branco';
				return false;
			}
			/* Verifica se já existe um tipo de pacote com esta descrição e ID diferente deste */
			$pac = $this->db->where(['nativo'=>1, 'cnomepac'=>$this->descricao])->where(self::$_idfield.'!=',$this->id)->get(self::$_table)->row();
			if ($pac){
				$this->error = 'Já existe um tipo de pacote com a descrição "'.$this->descricao.'"';
				return false;
			}
			return true;
		}
		
		/**
		* Função que salva o registro no banco de dados
		* @return ID do registro
		* @access public
		*/		
		
		public function save()
		{
			if ($this->id){
				/* Atualizar */
				$data = array(
					'cnomepac'=>$this->descricao
				);
				$this->db->where(self::$_idfield,$this->id);
				$this->db->update(self::$_table, $data);
				return $this->id;				
			} else {
				/* Criar */
				$data = array(
					'cnomepac'=>$this->descricao,
				);
				$this->db->insert(self::$_table, $data);
				return $this->db->insert_id();
			}
		}

		/**
		* Função que retorna uma lista de pacotes para um dado Imóvel
		* @param integer ID do Imóvel
		* @return array lista de pacotes
		* @access public
		*/	

		public static function getByImovel($imovel_id){
			self::$db->where('nidcadimo', $imovel_id);
			$pci = self::$db->get('tagpci')->result();
			$result = array();
			foreach ($pci as $item){
				self::$db->where('nidtbxpac', $item->nidtbxpac);
				$pac = self::$db->get('tbxpac')->row();
				$result[] = array('cnomepac'=>$pac->cnomepac, 'nvlrdiaria'=>$item->nvlrdiaria, 'nmindias'=>$item->nmindias, 'nvlrpacote'=>$item->nvlrpacote);
			}
			return $result;
		}

	}