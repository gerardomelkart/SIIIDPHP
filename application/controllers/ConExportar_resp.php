<?php 

class ConExportar extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		//cargar modelo indicado
		$this->load->library('session');
	    $this->load->model('ModActualizaDatos');
	    $this->load->model('ModSeleccionarDatos');
	    $this->load->helper('download'); // Cargar helper para descargas
	  
	}
	


	public function generar_csv_pba($codRef, $inconsistencia) {

		// $obtDatosVict = $this->ModSeleccionarDatos->obtRegInconsistencias($codRef);
	     

	      var_dump($codRef); 
	       var_dump($inconsistencia); 
         
		

	}

	
	
	public function generar_csv($codRef,$inconsistencia) {
        
        $data = $this->ModSeleccionarDatos->obtRegInconsistencias($codRef,$inconsistencia);


/******************** integridad referencial ******************************/


		if ($inconsistencia == 'tot_menosVICvsDEL'){

        	$filename = 'tot_menosVICvsDEL'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('ID_CI', 'ID_DELITO', 'total_delitos', 'total_victimas');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->ID_CI,
	                $row->ID_DELITO,
	                $row->total_delitos,
	                $row->total_victimas
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        if ($inconsistencia == 'tot_Reg_Carp_noExist_delit'){

        	$filename = 'tot_Reg_Carp_noExist_delit'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        if ($inconsistencia == 'tot_Reg_Carp_noExist_vict'){

        	$filename = 'tot_Reg_Carp_noExist_vict'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        if ($inconsistencia == 'tot_Reg_Delit_noExist_carp'){

        	$filename = 'tot_Reg_Delit_noExist_carp'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'tot_Reg_Delit_noExist_vict'){

        	$filename = 'tot_Reg_Delit_noExist_vict'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci','id_delito' );
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'tot_Reg_vict_noExist_carp'){

        	$filename = 'tot_Reg_vict_noExist_carp'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci' );
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'tot_Reg_vict_noExist_delit'){

        	$filename = 'tot_Reg_vict_noExist_delit'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci','id_delito' );
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }




/****************CARPETAS    ******************************************/

		
		if ($inconsistencia == 'id_ci_sinDato'){

        	$filename = 'id_ci_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'ID_CI_duplicados'){

        	$filename = 'ID_CI_duplicados'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'duplicados');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->duplicados
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'nomenclatura_sinDato'){

        	$filename = 'nomenclatura_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'fechaInicio_sinDato'){

        	$filename = 'fechaInicio_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'fmto_fechaInicio_incorrecto'){

        	$filename = 'fmto_fechaInicio_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 

        
        if ($inconsistencia == 'dia_fechaInicio_incorrecto'){

        	$filename = 'dia_fechaInicio_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'FHA_INI_fraRango'){

        	$filename = 'FHA_INI_fraRango'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'fha_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->fha_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'hora_ini_sinDato'){

        	$filename = 'hora_ini_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'hra_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->hra_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'fmto_hra_ini_incorrecto'){

        	$filename = 'fmto_hra_ini_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'hra_de_ini');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->hra_de_ini
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'cve_tipo_exp_incorrecto'){

        	$filename = 'cve_tipo_exp_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'ntra_ci', 'id_texp');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->ntra_ci,
	                $row->id_texp
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


/*************************DELITOS**********************************************************/
		
		if ($inconsistencia == 'ID_CI_enDELITOS_null'){

        	$filename = 'ID_CI_enDELITOS_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	            	$row->id_ci,
	                $row->id_delito,
	                $row->dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'ID_DELITO_null'){

        	$filename = 'ID_DELITO_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	            	$row->id_ci,
	                $row->id_delito,
	                $row->dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }



		if ($inconsistencia == 'ID_DELITO_duplicados'){

        	$filename = 'ID_DELITO_duplicados'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'duplicados');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	            	$row->id_ci,
	                $row->id_delito,
	                $row->duplicados
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'Desc_delito_null'){

        	$filename = 'Desc_delito_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'dto_principal_incorrecto'){

        	$filename = 'dto_principal_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'dto_prin');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->dto_prin
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        if ($inconsistencia == 'CI_masdeuno_o_sin_dto_prin'){

        	$filename = 'Exp_masdeuno_o_sin_dto_prin'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto_prin');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto_prin
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'FCHA_HCHOS_incorrecta'){

        	$filename = 'FCHA_HCHOS_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'Modalidad_dto_null'){

        	$filename = 'Modalidad_dto_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'dto_prin', 'moda_dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->dto_prin,
	                $row->moda_dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }
        
        if ($inconsistencia == 'cve_formaAccionIncorrecta'){

        	$filename = 'cve_formaAccionIncorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'forma_acc');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->forma_acc
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }
        

        if ($inconsistencia == 'fcha_de_hchos_null'){

        	$filename = 'fcha_de_hchos_null'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'fcha_de_hchos_formatoIncorrecto'){

        	$filename = 'fcha_de_hchos_formatoIncorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'dia_fcha_de_hchos_Incorrecto'){

        	$filename = 'dia_fcha_de_hchos_Incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'long_fcha_de_hchos_Incorrecto'){

        	$filename = 'long_fcha_de_hchos_Incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'fha_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->fha_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'hora_de_hchos_sinDatos'){

        	$filename = 'hora_de_hchos_sinDatos'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'hra_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->hra_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        if ($inconsistencia == 'long_hora_hchos_incorrecto'){

        	$filename = 'long_hora_hchos_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'hra_de_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->hra_de_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_emto_com_dto_incorrecta'){

        	$filename = 'cve_emto_com_dto_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'emto_com_dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->emto_com_dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_grdo_cons_incorrecta'){

        	$filename = 'cve_grdo_cons_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'grdo_cons');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->grdo_cons
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_clasfDelito_incorrecta'){

        	$filename = 'cve_clasfDelito_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'clasf_de_dto');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->clasf_de_dto
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'nombre_entidad_sinDato'){

        	$filename = 'nombre_entidad_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'nom_ent_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->nom_ent_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_entFed_incorrecta'){

        	$filename = 'cve_entFed_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'id_ent_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->id_ent_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'nom_mun_hchos_sinDato'){

        	$filename = 'nom_mun_hchos_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'nom_mun_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->nom_mun_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_mun_incorrecta'){

        	$filename = 'cve_mun_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'id_ent_hchos', 'id_mun_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->id_ent_hchos,
	                $row->id_mun_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'nom_colonia_sinDato'){

        	$filename = 'nom_colonia_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'nom_col_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->nom_col_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        
        if ($inconsistencia == 'cve_cp_incorrecta'){

        	$filename = 'cve_cp_incorrecta'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'cp');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->cp
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'coord_x_fmato_incorrecto'){

        	$filename = 'coord_x_fmato_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'coord_x');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->coord_x
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'coord_y_fmato_incorrecto'){

        	$filename = 'coord_y_fmato_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dto', 'coord_y');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dto,
	                $row->coord_y
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

         
        if ($inconsistencia == 'Dom_sinDato'){

        	$filename = 'DomHechos_vacio'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'dom_hchos');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->dom_hchos
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

/**************************validaciones victimas  ****************************/
     
       if ($inconsistencia == 'id_ci_vict_sinDato'){

        	$filename = 'id_ci_vict_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }   

        
        if ($inconsistencia == 'id_delito_vict_sinDato'){

        	$filename = 'id_delito_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }   

        
        if ($inconsistencia == 'id_vicf_sinDato'){

        	$filename = 'id_vicf_sinDato'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_vicf');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf
	                
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        } 


        if ($inconsistencia == 'ID_VICF_duplicados'){

        	$filename = 'ID_VICF_duplicados'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_delito','id_vicf', 'duplicados');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_delito,
	                 $row->id_vicf,
	                $row->duplicados
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }  

        
        if ($inconsistencia == 'cve_tv_incorrecto'){

        	$filename = 'cve_tv_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci','id_delito','id_vicf', 'id_tv');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf,
	                $row->id_tv
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }


        if ($inconsistencia == 'id_tpm_incorrecto'){

        	$filename = 'id_tpm_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_vicf', 'id_tv', 'id_tpm');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf,
	                $row->id_tv,
	                $row->id_tpm
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        if ($inconsistencia == 'dts_incorrectos_si_es_PM'){

        	$filename = 'dts_incorrectos_si_es_PM_'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_vicf', 'id_tv');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_vicf,
	                $row->id_tv
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'cve_sexo_incorrecto'){

        	$filename = 'cve_sexo_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'sexo');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->sexo
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'cve_genero_incorrecto'){

        	$filename = 'cve_genero_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'genero');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->genero
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'dato_poblacion_incorrecto'){

        	$filename = 'dato_poblacion_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'pob');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->pob
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }


        
        if ($inconsistencia == 'dato_discapacidad_incorrecto'){

        	$filename = 'dato_discapacidad_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'disc');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->disc
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        
        if ($inconsistencia == 'fmto_fchaNac_incorrecto'){

        	$filename = 'fmto_fchaNac_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'fha_nac');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->fha_nac
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);  
        }

        if ($inconsistencia == 'edad_incorrecto'){

        	$filename = 'edad_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'edad');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->edad
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'cve_nacionalidad_incorrecto'){

        	$filename = 'cve_nacionalidad_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'nacional');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->nacional
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        
        if ($inconsistencia == 'rel_vict_input_incorrecto'){

        	$filename = 'rel_vict_input_incorrecto'.date('Ymd').'.csv';
	        // Cabeceras CSV
	        $headers = array('id_ci', 'id_delito', 'id_tv', 'rel_vic_vmario');
	        
	        $csvData = implode(',', $headers)."\n";
	        
	        foreach($data as $row) {
	            $lineData = array(
	                $row->id_ci,
	                $row->id_delito,
	                $row->id_tv,
	                $row->rel_vic_vmario
	            );
	            $csvData .= implode(',', $lineData)."\n";
	        }
	        // Forzar descarga
	        force_download($filename, $csvData);
        }

        





  }



   public function generar_csv_ExpedientesEnviados($codRef) {
		    // Cargar helper de ZIP
		    $this->load->library('zip');
		    $this->load->helper('download');

		    // Generar primer CSV
		    $data = $this->ModSeleccionarDatos->obtRegExpedientesEnviados($codRef);
		    $filename1 = '_ExpedientesEnviados.csv';
		    
		    $headers1 = ['id_ci', 'ntra_ci', 'fha_de_ini', 'hra_de_ini', 'rmen_de_hchos', 'usuario_envio', 'fecha_envio'];
		    $csvData1 = implode(',', $headers1)."\n";
		    
		    foreach($data as $row) {
		        $lineData = [
		            $row->id_ci,
		            $row->ntra_ci,
		            $row->fha_de_ini,
		            $row->hra_de_ini,
		            $row->rmen_de_hchos,
		            $row->usuario_envio,
		            $row->fecha_envio
		        ];
		        $csvData1 .= implode(',', $lineData)."\n";
		    }

		    // Generar segundo CSV
		    $data2 = $this->ModSeleccionarDatos->obtRegDelitosEnviados($codRef);
		    $filename2 = '_DelitosEnviados.csv';
		    
		    $headers2 = ['id_ci', 'id_delito', 'dto', 'moda_dto', 'forma_acc', 'fha_de_hchos', 'hra_de_hchos', 'emto_com_dto', 'grdo_cons', 'clasf_de_dto', 'nom_ent_hchos', 'id_ent_hchos', 'nom_mun_hchos', 'id_mun_hchos', 'nom_loc_hchos', 'id_loc_hchos', 'nom_col_hchos', 'id_col_hchos', 'cp', 'coord_x', 'coord_y', 'dom_hchos', 'usuario_envio', 'fecha_envio'];
		    $csvData2 = implode(',', $headers2)."\n";
		    
		    foreach($data2 as $row) {
		        $lineData = [
		            $row->id_ci,
		            $row->id_delito,
		            $row->dto,
		            $row->moda_dto,
		            $row->forma_acc,
		            $row->fha_de_hchos,
		            $row->hra_de_hchos,
		            $row->emto_com_dto,
		            $row->grdo_cons,
		            $row->clasf_de_dto,
		            $row->nom_ent_hchos,
		            $row->id_ent_hchos,
		            $row->nom_mun_hchos,
		            $row->id_mun_hchos,
		            $row->nom_loc_hchos,
		            $row->id_loc_hchos,
		            $row->nom_col_hchos,
		            $row->id_col_hchos,
		            $row->cp,
		            $row->coord_x,
		            $row->coord_y,
		            $row->dom_hchos,
		            $row->usuario_envio,
		            $row->fecha_envio
		        ];
		        $csvData2 .= implode(',', $lineData)."\n";
		    }


		     // Generar segundo CSV
		    $data3 = $this->ModSeleccionarDatos->obtRegVictimasEnviados($codRef);
		    $filename3 = '_VictimasEnviados.csv';
			
			$headers3 = ['id_ci', 'id_delito', 'id_vicf', 'id_tv', 'id_tpm', 'sexo', 'genero', 'pob', 'disc', 'fha_nac', 'edad', 'nacional', 'usuario_envio', 'fecha_envio'];
		    $csvData3 = implode(',', $headers3)."\n";

		    foreach($data3 as $row) {
		        $lineData = [
		            $row->id_ci,
		            $row->id_delito,
		            $row->id_vicf,
		            $row->id_tv,
		            $row->id_tpm,
		            $row->sexo,
		            $row->genero,
		            $row->pob,
		            $row->disc,
		            $row->fha_nac,
		            $row->edad,
		            $row->nacional,
		            $row->usuario_envio,
		            $row->fecha_envio
		        ];
		        $csvData3 .= implode(',', $lineData)."\n";
		    }



		    // Crear ZIP en memoria
		    $this->zip->add_data($filename1, $csvData1);
		    $this->zip->add_data($filename2, $csvData2);
		    $this->zip->add_data($filename3, $csvData3);

		    // Generar nombre único para el ZIP
		    $zipFilename = $codRef.'_RegistrosEnviados'.'.zip';

		    // Forzar descarga del ZIP
		    $this->zip->download($zipFilename);

  }

   





}
?>