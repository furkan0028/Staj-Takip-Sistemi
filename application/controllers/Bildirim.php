<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bildirim extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$this->_check_session();
		$this->load->view("header");
		$this->load->model('Bildirim_Model');
	}
	
		private function _check_session(){
		if($this->session->login!=TRUE){
			$this->session->sess_destroy();
			redirect();
		}
	}
	
	public function bildirim_gorme() {
	$ogrenci_no=$this->input->post('name');
	$data = array('durum' =>"0");
	//$data2["a"]=$abc;
	 /*$return["json"] = json_encode($return);
    echo json_encode($return);*/
	$this->Bildirim_Model->bildirim_Guncelle($ogrenci_no,$data);
	echo json_encode($ogrenci_no);
	}
	
	public function tum_bildirimler($no){
	
		$query=$this->Bildirim_Model->tum_bildirimler($no);
		$data["bildirimler"]=$query;
		$this->load->view("tum_bildirimler",$data);
		$this->load->view("footer");
	}
	
	public function bildirim_gonder()
	{
		
		$alici=$this->input->post('ogr');
		$gonderen=$this->input->post('isim');
		$mesaj=$this->input->post('mesaj');
		$bolum=$this->input->post('bolum');
		$tarih = date('Y-m-d');
		 $data = array('ogrenci_no' =>$alici,
				    	 'baslik' 	     =>"$gonderen bir mesaj yolladı !",
						 'bolum_id'      =>$bolum,
	  					 'icerik'	     =>$mesaj,
	  				     'durum'  		 =>"1",
						 'gonderilme_tarih' =>$tarih,
	  					 'sirket_durumu' =>"0",
						 'staj_durumu'	 =>"0"
							);
		$sonuc=$this->Bildirim_Model->bildirim_Ekle($data);
		if($sonuc)
		{
			$data2['status'] = 'success';  
		} 
		else
		{
			$data2['status'] = 'error';  
		}
		 $arr= array('alici'=>$alici,'gonderen'=>$gonderen,'mesaj'=>$mesaj,'bolum'=>$bolum);
		echo json_encode($data2);
	}

}
?>