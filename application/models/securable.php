<?php

class Securable extends Eloquent{

	/**
	 * A method or function to save securable information to the db
	 * @param  [object] $client_data [an object containing json form data]
	 * @return [json]              []
	 */
	public static function create_securable($client_data){

		try{

		$inputs = array('name'=>$client_data->name,'display_name'=>$client_data->displayName);
		$validation = MyValidator::validate_user_input($inputs,HelperFunction::get_config_value('create_securable_rule'));
			if($validation->fails())
				return HelperFunction::catch_error(null,false,HelperFunction::format_message($validation->errors->all()));

		$securable_array = DataHelper::create_audit_entries(HelperFunction::get_user_id());
		$securable_array['name'] = $client_data->name;
		$securable_array['display_name'] = $client_data->displayName;
		

		return DataHelper::insert_record('securables',$securable_array);

	}catch(Exception $e){
		return HelperFunction::catch_error($e,true);
	}
}
	public static function update_securable($client_data){

		try{

		$inputs = array('name'=>$client_data->name,'display_name'=>$client_data->displayName);
		$validation = MyValidator::validate_user_input($inputs,HelperFunction::get_config_value('create_module_rule'));
			if($validation->fails())
				return HelperFunction::catch_error(null,false,HelperFunction::format_message($validation->errors->all()));

		$securable_array = DataHelper::update_audit_entries(HelperFunction::get_user_id());
		$securable_array['name'] = $client_data->name;
		$securable_array['display_name'] = $client_data->displayName;
		

		return DataHelper::update_record('securables',$securable_array);

	}catch(Exception $e){
		return HelperFunction::catch_error($e,true);
	}
}
	public static function delete_securable(){



	}
	public static function get_securables($client_data){

			$filter_array = array();
			if(array_key_exists('id', $client_data))
				$filter_array['id'] = $client_data['id'];
			if(array_key_exists('name', $client_data))
				$filter_array['name'] = $client_data['name'];
			if(array_key_exists('displayName', $client_data))
				$filter_array['display_name'] = $client_data['displayName'];
		
			$query_result = DB::table('securables')
							->join('modules','module_id','=','modules.id')
							->where(function($query) use ($filter_array){

								$query = DataHelper::filter_data($query,'id',$filter_array,'int');
								$query = DataHelper::filter_data($query,'name',$filter_array,'string');

							})->order_by('securables.id','desc');

			$total = $query_result->count();
			$result = $query_result->get(

					array('securables.id','securables.name as securable_name','securables.display_name',
								'securables.module_id','modules.name as modul_name')
				);

			$out = array_map(function($data){

			$arr = array();
			$arr['id'] 			= $data->id;
			$arr['name']		= $data->securable_name;
			$arr['displayName']	= $data->display_name;
			$arr['moduleName']  = $data->modul_name;
			$arr['moduleId']  = $data->module_id;
			$arr['securableName']  = $data->securable_name;

			return $arr;
		},$result);
				
		$data = HelperFunction::return_json_data($out,true,'record loaded',$total);
		return $data;
			
	}
	public static function get_securables_array(){
		
		$data = DataHelper::return_json_data(HelperFunction::get_config('secuable_permissions'),true,"data loaded");
		return $data;
	}
}