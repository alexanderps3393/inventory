<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('BarangModel', 'MBarang');
	}

	public function dropdown()
	{
		$this->data['listBarang'] = $this->MBarang->get_data('type_barang','');
		$this->load->view('v_tes',$this->data);
	}

	public function tes()
	{

	}
	
	public function hasil()
	{
		if( $_REQUEST["jenis_barang"] ){

	  		$jenis_barang = $_REQUEST['jenis_barang'];
	   		if($jenis_barang == 1){
	   			$this->data['listCPU'] = $this->MBarang->get_data_table('cpu',array('cpu_status' => 0),'cpu_id','desc');
	   			$this->load->view('v_drop1',$this->data);
	   		}elseif($jenis_barang == 100){
	   			$this->data['listLaptop'] = $this->MBarang->get_data_table('laptop',array('laptop_status' => 0),'laptop_id','desc');
	   			$this->load->view('v_drop2',$this->data);
	   		}
		}
	}

	public function multi()
	{
		$this->load->view('v_tes');
	}

	public function pc()
	{

		//status belum ditambahin
		$this->db->trans_start();
		//APPPATH."third_party\PHPExcel.php"
		//$file = APPPATH."..\assets\upload/ex.xlsx";
		$file = "./assets/upload/tes/pc.xlsx";
		$this->load->library('excel');

		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);

		$objWorksheet = $objPHPExcel->getActiveSheet();

		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10

		$row = 3;
		for ($i = 1; $i < $highestRow-1; $i++) {
		   	$service_tag[$i] = $objWorksheet->getCell("E".$row)->getValue();
		   	$cpu_id[$i] = $this->_get_cpu_id($service_tag[$i]);

		   	//monitor
		   	$sn_mon[$i] = $objWorksheet->getCell("I".$row)->getValue();
		   	$mon_id[$i] = $this->_get_sn_barang($sn_mon[$i]);

		   	//keyboard
		   	$sn_key[$i] = $objWorksheet->getCell("M".$row)->getValue();
		   	$key_id[$i] = $this->_get_sn_barang($sn_key[$i]);

		   	//mouse
		   	$sn_mouse[$i] = $objWorksheet->getCell("P".$row)->getValue();
		   	$mouse_id[$i] = $this->_get_sn_barang($sn_mouse[$i]);

		   	//ups
		   	$sn_ups[$i] = $objWorksheet->getCell("S".$row)->getValue();
		   	$ups_id[$i] = $this->_get_sn_barang($sn_ups[$i]);

		   	$hostname[$i] = $objWorksheet->getCell("F".$row)->getValue();
		   	$user[$i] = $objWorksheet->getCell("A".$row)->getValue();
		   	$department[$i] = $objWorksheet->getCell("Z".$row)->getValue();
		   	$lokasi[$i] = $objWorksheet->getCell("X".$row)->getValue();
		   	$sublokasi[$i] = $objWorksheet->getCell("Y".$row)->getValue();
			$row++;
			
			echo " pc : ".$service_tag[$i]." - ".$cpu_id[$i];
			echo " mon : ".$sn_mon[$i]." - ".$mon_id[$i];
			echo " key : ".$sn_key[$i]." - ".$key_id[$i];
			echo " mouse : ".$sn_mouse[$i]." - ".$mouse_id[$i];
			echo " ups : ".$sn_ups[$i]." - ".$ups_id[$i];
			echo " hostname : ".$hostname[$i];
			echo " user : ".$user[$i]." ".$department[$i]." ".$lokasi[$i]." ".$sublokasi[$i];
			
			echo "<br />";

			$data = array('as_cpu_cpu_id' => $cpu_id[$i],
							'as_cpu_mon1_id' => $mon_id[$i],
							'as_cpu_keyboard_id' => $key_id[$i],
							'as_cpu_mouse_id' => $mouse_id[$i],
							'as_cpu_ups_id' => $ups_id[$i],
							'as_cpu_id_creator' => 1,
							'as_cpu_time_create' => date('Y-m-d H:i:s')
			);

			//update cpu
			$data_cpu = array('cpu_hostname' => $hostname[$i],
								'cpu_user' => $user[$i],
								'cpu_department' => $department[$i],
								'cpu_location' => $lokasi[$i],
								'cpu_sub_location' => $sublokasi[$i],
								'cpu_id_editor' => 1,
								'cpu_status' => 1,
								'cpu_time_edit' => date('Y-m-d H:i:s')
				);
			$this->MBarang->update_table('cpu_id', $cpu_id[$i], 'cpu', $data_cpu);
			
			//update monitor
			$data_mon = array( 'barang_user' => $user[$i],
								'barang_department' => $department[$i],
								'barang_location' => $lokasi[$i],
								'barang_sub_location' => $sublokasi[$i],
								'barang_id_editor' => 1,
								'barang_status' => 1,
								'barang_time_edit' => date('Y-m-d H:i:s')
				);
			$this->MBarang->update_table('barang_id', $mon_id[$i], 'barang', $data_mon);

			//update keyboard
			$data_key = array( 'barang_user' => $user[$i],
								'barang_department' => $department[$i],
								'barang_location' => $lokasi[$i],
								'barang_sub_location' => $sublokasi[$i],
								'barang_id_editor' => 1,
								'barang_status' => 1,
								'barang_time_edit' => date('Y-m-d H:i:s')
				);
			$this->MBarang->update_table('barang_id', $key_id[$i], 'barang', $data_key);

			//update mouse
			$data_mouse = array( 'barang_user' => $user[$i],
								'barang_department' => $department[$i],
								'barang_location' => $lokasi[$i],
								'barang_sub_location' => $sublokasi[$i],
								'barang_id_editor' => 1,
								'barang_status' => 1,
								'barang_time_edit' => date('Y-m-d H:i:s')
				);
			$this->MBarang->update_table('barang_id', $mouse_id[$i], 'barang', $data_mouse);

			//update ups
			$data_ups = array( 'barang_user' => $user[$i],
								'barang_department' => $department[$i],
								'barang_location' => $lokasi[$i],
								'barang_sub_location' => $sublokasi[$i],
								'barang_id_editor' => 1,
								'barang_status' => 1,
								'barang_time_edit' => date('Y-m-d H:i:s')
				);
			$this->MBarang->update_table('barang_id', $ups_id[$i], 'barang', $data_ups);

			$query = $this->MBarang->add('as_cpu', $data);
		}
		$this->db->trans_complete();
	}


	public function laptop()
	{

		//status belum ditambahin
		$this->db->trans_start();
		//APPPATH."third_party\PHPExcel.php"
		//$file = APPPATH."..\assets\upload/ex.xlsx";
		$file = "./assets/upload/tes/laptop.xlsx";
		$this->load->library('excel');

		//read file from path
		$objPHPExcel = PHPExcel_IOFactory::load($file);

		$objWorksheet = $objPHPExcel->getActiveSheet();

		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10

		$row = 3;
		for ($i = 1; $i < $highestRow-1; $i++) {
		   	$sn_lp[$i] = $objWorksheet->getCell("A".$row)->getValue();
		   	$laptop_id[$i] = $this->_get_laptop_id($sn_lp[$i]);

		   	//mouse
		   	$sn_mouse[$i] = $objWorksheet->getCell("D".$row)->getValue();
		   	$mouse_id[$i] = $this->_get_sn_barang($sn_mouse[$i]);

		   	$hostname[$i] = $objWorksheet->getCell("B".$row)->getValue();
		   	$kode[$i] = $objWorksheet->getCell("C".$row)->getValue();
		   	$user[$i] = $objWorksheet->getCell("E".$row)->getValue();
		   	$ket[$i] = $objWorksheet->getCell("F".$row)->getValue();
			$row++;
			
			echo " sn : ".$sn_lp[$i]." - ".$laptop_id[$i];
			echo " mouse : ".$sn_mouse[$i]." - ".$mouse_id[$i];
			echo " hostname : ".$hostname[$i];
			echo " kode : ".$kode[$i];
			echo " user : ".$user[$i];
			
			echo "<br />";

			$data = array('as_laptop_laptop_id' => $laptop_id[$i],
							'as_laptop_mouse_id' => $mouse_id[$i],
							'as_laptop_id_creator' => 1,
							'as_laptop_time_create' => date('Y-m-d H:i:s')
			);

			//update cpu
			$data_laptop = array('laptop_nama' => $hostname[$i],
								'laptop_kode' => $kode[$i],
								'laptop_user' => $user[$i],
								'laptop_ket' => $ket[$i],
								'laptop_status' => 1,
								'laptop_id_editor' => 1,
								'laptop_time_edit' => date('Y-m-d H:i:s')
				);
			$this->MBarang->update_table('laptop_id', $laptop_id[$i], 'laptop', $data_laptop);
	
		
			//update mouse
			$data_mouse = array( 'barang_user' => $user[$i],
								'barang_status' => 1,
								'barang_id_editor' => 1,
								'barang_time_edit' => date('Y-m-d H:i:s')
				);
			$this->MBarang->update_table('barang_id', $mouse_id[$i], 'barang', $data_mouse);


			$query = $this->MBarang->add('as_laptop', $data);
		}
		$this->db->trans_complete();
	}


	private function _get_cpu_id($sn = null)
	{
		$query = $this->MBarang->get_data('cpu', array('cpu_service_tag' => $sn) );

		$row = $query->row();

		if(isset($row)){
			foreach($query->result() as $row){
				$id = $row->cpu_id;
			}
		}else{
			$id = 0 ;
		}
		

		return $id;
	}

	private function _get_laptop_id($sn = null)
	{
		$query = $this->MBarang->get_data('laptop', array('laptop_sn_lp' => $sn) );

		$row = $query->row();

		if(isset($row)){
			foreach($query->result() as $row){
				$id = $row->laptop_id;
			}
		}else{
			$id = 0 ;
		}
		

		return $id;
	}

	private function _get_sn_barang($sn = null)
	{
		$query = $this->MBarang->get_data('barang', array('barang_sn' => $sn) );

		$row = $query->row();

		if(isset($row)){
			foreach($query->result() as $row){
				$id = $row->barang_id;
			}
		}else{
			$id = 0 ;
		}
		
		

		return $id;
	}

	public function faktorial($angka)
	{
		$num = 1;
		for($i=$angka; $i>0; $i--){
			if($angka % $i == 0){
				$fact[$num] = $i;
				$num++;
			}
		}

		print_r($fact);
	}

	public function wow()
	{
		echo "tess";
	}

	public function create()
	{
		$this->load->library('excel');
		$file = "./assets/upload/tes/template.xls";

		echo "string";
		//load Excel template file
		$objTpl = PHPExcel_IOFactory::load($file);
		// $objTpl->setActiveSheetIndex(0);  //set first sheet as active
		 
		// $objTpl->getActiveSheet()->setCellValue('C2', date('Y-m-d'));  //set C1 to current date
		// $objTpl->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); //C1 is right-justified
		 
		// $objTpl->getActiveSheet()->setCellValue('C3', stripslashes($_POST['txtName']));
		// $objTpl->getActiveSheet()->setCellValue('C4', stripslashes($_POST['txtMessage']));
		 
		// $objTpl->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);  //set wrapped for some long text message
		 
		// $objTpl->getActiveSheet()->getColumnDimension('C')->setWidth(40);  //set column C width
		// $objTpl->getActiveSheet()->getRowDimension('4')->setRowHeight(120);  //set row 4 height
		// $objTpl->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP); //A4 until C4 is vertically top-aligned
		 
		//prepare download
		$filename = 'asdhj.xls'; //just some random filename
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		 
		$objWriter = PHPExcel_IOFactory::createWriter($objTpl, 'Excel5');  //downloadable file is in Excel 2003 format (.xls)
		$objWriter->save('php://output');  //send it to user, of course you can save it to disk also!
		 
		//exit; //done.. exiting!
	}

	private function _create_no_dok()
	{
		$query = $this->MBarang->get_data('no', array('no_id' => 1) );

		$row = $query->row();

		if(isset($row)){
			foreach($query->result() as $row){
				$no = $row->no_val;
				$val = $no;
			}

			if($val < 10 AND $val >= 1){
				$val = "00".$val;
			}elseif($val < 100 AND $val >= 10){
				$val = "0".$val;
			}
		}

		$month = $this->_convert_month(date("m"));
		$year = date("Y");
		$no_dok = "FFFB/".$val."/".$month."/".$year;

		//$this->MBarang->update_table('barang_id', $ups_id[$i], 'barang', $data_ups);
		//update no on table
		$this->MBarang->update_table('no_id', 1, 'no', array('no_val' => $no+1));
		return $no_dok;
	}

	public function wew()
	{

		echo $this->_create_no_dok();
	}

	private function _convert_month($val)
	{	
		if($val == 1){
			return "I";
		}elseif($val == 2){
			return "II";
		}elseif($val == 3){
			return "III";
		}elseif($val == 4){
			return "IV";
		}elseif($val == 5){
			return "V";
		}elseif($val == 6){
			return "VI";
		}elseif($val == 7){
			return "VII";
		}elseif($val == 8){
			return "VIII";
		}elseif($val == 9){
			return "IX";
		}elseif($val == 10){
			return "X";
		}elseif($val == 11){
			return "XI";
		}elseif($val == 12){
			return "XII";
		}
	}


}