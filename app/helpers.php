<?PHP

function get_blockchain(){
	$blockchain = new \Blockchain\Blockchain();
	$blockchain->setUrl('https://blockchainbdgpzk.onion/');
	$blockchain->curl_setopt(CURLOPT_PROXY, "127.0.0.1:9050");
	$blockchain->curl_setopt(CURLOPT_PROXYTYPE, 7);
	$blockchain->curl_setopt(CURLOPT_RETURNTRANSFER, 1);
	$blockchain->curl_setopt(CURLOPT_VERBOSE, 0);
	$blockchain->Wallet->credentials(Settings::get('blockchain_guid'), Settings::get('blockchain_password'));
	return $blockchain;
}

function get_form_boolean($name){
	return Form::select($name,[1=>'Yes',0=>'No'],null,['class'=>'form-control']);
}

function get_form_redirect($var,array $messages){
	return Redirect::back()->with($var,$messages)->withInput();
}

function round_amount($amount){
	return round($amount,AMOUNT_SCALE);
}

function get_currencies(){
	return array_keys(get_rates());
}

function get_currency_options(){
	$options = [];
	
	foreach(get_currencies() as $currency)
		$options[$currency]=$currency;

	return $options;
}

function get_rate(){
	return get_rates()[Settings::get('currency')];
}

function convert_to_btc($amount_fiat){
	return bcdiv($amount_fiat,get_rate(),BC_SCALE);
}

function convert_to_fiat($amount_btc){
	return bcmul($amount_btc,get_rate(),BC_SCALE);
}

function get_rates(){
	return json_decode(file_get_contents(base_path().'/data/rates.json'),true);
}

function is_pgp_message($value){
	$value = trim($value);

    if(!starts_with($value,PGP_MESSAGE_START))
    	return false;

    if(!ends_with($value,PGP_MESSAGE_END))
    	return false;

    return true;
}

function force_type($var,$type){
	switch($type){
		case 'integer':
			return intval($var);
			break;
		case 'string':
			if(!is_string($var))
				return '';
			else
				return $var;
			break;
		case 'boolean':
			return !!intval($var);
			break;
		case 'float':
			return floatval($var);
			break;
		default:
			throw new Exception('Invalid type');
			break;
		}
}

function get_random_string($length = 32){
	
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++)
        $randomString .= $characters[rand(0, strlen($characters)-1)];
    
    return $randomString;
}