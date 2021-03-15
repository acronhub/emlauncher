<?php
require_once APP_ROOT.'/model/Config.php';
require_once APP_ROOT.'/model/Storage.php';

use Google\Cloud\Storage\StorageClient;

class GCS implements StorageImpl {

	protected $bucket;
	protected $client;

	public function __construct()
	{
		$config = Config::get('gcp');
		$this->bucket = $config['bucket_name'];

		$this->client = new StorageClient(
			array(
				'projectId' => $config['project_id'],
				'keyFile' => json_decode(file_get_contents($config['secret_json'], TRUE), true),
			));
	}

	public function saveIcon($key,$data)
	{
		$options = [
			'name' => $key
		];

		$bucket = $this->client->bucket($this->bucket);
		$r = $bucket->upload(
			GuzzleHttp\Psr7\stream_for($data->getImageBlob()),
			$options
		);
		return $r;
	}

	public function saveFile($key,$filename,$mime)
	{
		$options = [
			'name' => $key
		];

		$fp = fopen($filename,'rb');

		$bucket = $this->client->bucket($this->bucket);
		$r = $bucket->upload(
			$fp,
			$options
		);

		fclose($fp);
		return $r;
	}

	public function rename($srckey,$dstkey)
	{
		$options = [
			'name' => $key
		];

		$bucket = $this->client->bucket($this->bucket);
		$object = $bucket->object(
			$options['name']
		);

		$object->rename($dstkey);
	}

	public function delete($key)
	{
		$options = [
			'name' => $key
		];

		$bucket = $this->client->bucket($this->bucket);
		$object = $bucket->object(
			$options['name']
		);

		if($object->exists()){
			$object->delete();
		}
	}

	public function url($key,$expires=null,$filename=null)
	{
		$bucket = $this->bucket;
		return "https://storage.cloud.google.com/${$bucket}/${key}";
	}
}
