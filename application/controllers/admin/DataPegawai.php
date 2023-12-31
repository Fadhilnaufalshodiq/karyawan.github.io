<?php 
	class dataPegawai extends CI_Controller{
		public function index()
		{
			$data['title'] = "Data Pegawai";
			$data['pegawai']= $this->penggajianModel->get_data('data_pegawai')->result();
		$this->load->view('admin/dataPegawai',$data);
		$this->load->view('tamplates_admin/header',$data);
		$this->load->view('tamplates_admin/footer');
		}

		public function tambahData()
		{
			$data['title'] = "Tambah Data Pegawai";
			$data['jabatan']= $this->penggajianModel->get_data('data_jabatan')->result();
		$this->load->view('admin/formTambahPegawai',$data);
		$this->load->view('tamplates_admin/header',$data);
		$this->load->view('tamplates_admin/footer');
		}

		public function tambahDataAksi()
		{
			$this->_rules();

			if ($this->form_validation->run()==FALSE){
				$this->tambahData();
			}else{
				$nik 				=$this->input->post('nik');
				$nama_pegawai		=$this->input->post('nama_pegawai');
				$jenis_kelamin  	=$this->input->post('jenis_kelamin');
				$tanggal_masuk 		=$this->input->post('tanggal masuk');
				$jabatan 			=$this->input->post('jabatan');
				$status 			=$this->input->post('status');
				$photo		 		=$_FILES['photo']['name'];
				if($photo=''){}else{
					$config['upload_path']		='./assets/photo';
					$config['allowed_types']	='JPG|jpeg|png|tiff';
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('photo')){
						echo "Photo Gagal Diupload";
					}else{
						$photo=$this->upload->data('file_name');
					}
				}
				$data = array(
					'nik'				=>$nik,
					'nama_pegawai'		=>$nama_pegawai,
					'jenis_kelamin'		=>$jenis_kelamin,
					'tanggal_masuk'		=>$tanggal_masuk,
					'jabatan'			=>$jabatan,
					'status'			=>$status,
					'photo'				=>$photo,
				);

				$this->penggajianModel->insert_data($data,'data_pegawai');
				$this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible fade show" role="alert">
				  <strong>Data Berhasil Ditambah</strong>
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>');
				redirect('dataPegawai');
			}
		}
		public function _rules()
		{
			$this->form_validation->set_rules('nik','nik','required');
			$this->form_validation->set_rules('nama_pegawai','Nama Pegawai','required');
			$this->form_validation->set_rules('jenis_kelamin','Jenis Kelamin','required');
			$this->form_validation->set_rules('tanggal_masuk','Tanggal Masuk','required');
			$this->form_validation->set_rules('jabatan','Jabatan','required');
			$this->form_validation->set_rules('status','Status','required');
		}
	
	}
 ?>