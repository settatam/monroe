<?
class TBHLifeStyle {

	public $webServiceURL ="https://www.tollbrothers.com/api/community/446";
	protected $comm_data;
	public $communities;
	public $models;
	public $homeImages;
	public $qdhList;
	public $communityPrices;
	//protected $models;

	public function getCommuniytList() {

	}

	public function makeRequest() {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$this->webServiceURL);
		$result=curl_exec($ch);
		$comm_data = json_decode($result, true);
		$this->comm_data = $comm_data;
		return $comm_data;
	}


	public function getJDEnumber() {
		return $this->comm_data['jdeNum'];
	}

	public function communities(){
		

		$model = [];
		$communities = [];
		$homeImages = [];
		$qdhLists = [];
		$modelPrices = [];
		$allModels = [];

		foreach($this->comm_data['models'] as $models) {

			//filter the prices to be used as index. 

			$model[$this->makeArrayKey($models['name'])] = $models['name'];

			$modelPrices[$this->makeArrayKey($models['name'])] = $models['pricedFrom'];

			$allModels[] = $models['name'];


				if(is_array($models['QDHList'])) {

					for($i=0; $i<sizeof($models['QDHList']); $i++) {

						$qdhLists[] = $models['QDHList'][$i]['name'];
						
					}

				}	

 		}


 		// var_dump($qdhLists);
 		$this->modelPrices = $modelPrices;
 		$this->models = $model;
 		$this->qdhList = $qdhLists;
 		$this->allModels = $allModels;
	}


	public function makeArrayKey($string) {
		$str = $this->makeName($string);
		return strtolower(str_replace(" ", "-", trim($str)));
	}

	public function getCommunityPrices() {
		return $this->communityPrices;
	}

	public function makeName($string) {
		$notAllowed = array("Julington Lakes -", "Collection");
		$str = str_replace($notAllowed, "", $string);
		return trim($str);
	}

	public function setCommunityName($name) {
		return "Julington Lakes - " .ucfirst($name) . " Collection";
	}

	public function getModels() {
		$model = [];
		foreach($this->comm_data['communityList'] as $community) {

				if(is_array($community['models'])) {
					foreach($community['models'] as $models) {
						if($models['name']) $model[$this->makeArrayKey($community['name'])."_".$models['name']] = $models['name'];
					}
			}
		}

		return $model;
	}

	public function getModelPrices() {
		$model = [];
		foreach($this->comm_data['communityList'] as $community) {

				if(is_array($community['models'])) {
					foreach($community['models'] as $models) {
						if($models['name'] && is_numeric($models['pricedFrom'])) $model[$this->makeArrayKey($community['name'])."_".$models['name']] = $models['pricedFrom'];
					}
			}
		}

		return $model;
	}

	public function getModelSizes() {
		$model = [];
		foreach($this->comm_data['communityList'] as $community) {

				if(is_array($community['models'])) {
					foreach($community['models'] as $models) {
						if($models['name']) $model[$this->makeArrayKey($community['name'])."_".$models['name']] = $models['sqFt'];
					}
			}
		}

		sort($model);

		return $model;
	}

	public function getCommunityModels($name) {
		$model = [];
		$community = $this->getCommunityDetails($name);
			if(is_array($community['models'])) {
				foreach($community['models'] as $models) {
					if($models['name']) $model[$this->makeArrayKey($community['name'])."_".$models['name']] = $models['name'];
				}
			}

			sort($model);

		return $model;
	}

	public function getCollectionsQDH($collection) {
		$qdh = [];
		foreach($this->comm_data['communityList'] as $community) {
				if($community['name'] == $collection) {
					if(is_array($community['models'])) {
					foreach($community['models'] as $models) {
							if(is_array($models['QDHList'])) {
								foreach($models['QDHList'] as $qd_homes) {
									$qdh[] = $qd_homes['name'];
								}
							}
						}
					}
				}
			}

		return $qdh;
	}

	public function getQDHCollection($name) {
		
		foreach($this->comm_data['communityList'] as $community) {
					if(is_array($community['models'])) {
					foreach($community['models'] as $models) {
							if(is_array($models['QDHList'])) {
								foreach($models['QDHList'] as $qd_homes) {
									if($qd_homes['name'] == $name) return $community['name'];
								}
							}
						}
					}
			}

	}

	public function getMainModelImages($model, $size) {
		
		$images = [];
		$details = $this->getModelDetails($model);

		if(is_array($details['multimediaCollection']['otherMultimedia'])) {
			foreach($details['multimediaCollection']['otherMultimedia'] as $image) { 
				if ($image['type'] == "1012") {
					$subarray['desc'] = $image['name'];
					$subarray['link'] = $image[$size];
					$images[] = (object)$subarray;
				}
			}	
		}

		
		if(is_array($details['multimediaCollection']['homeImages'])) {
			foreach($details['multimediaCollection']['homeImages'] as $image) { 
				$subarray['desc'] = $image['name'];
				$subarray['link'] = $image[$size];
				$images[] = (object)$subarray;
			}	
		}

		return $images;

	}

	public function getAllImages($model, $size, $collection) {
		
		$images = [];
		$details = $this->getModelDetails($model);
		$link = [];

		if(is_array($details['multimediaCollection']['otherMultimedia'])) {
			foreach($details['multimediaCollection']['otherMultimedia'] as $image) { 
				if ($image['type'] == "1012") {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$link[] = $image[$size];
					$subarray['category'] = "photos";
					$subarray['interactive'] = false;
					$subarray['desc'] = $image['name'];
					$subarray['link'] = $image[$size];
					$images[] = (object)$subarray;
				}

				if ($image['type'] == "10006") {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$link[] = $image[$size];
					$subarray['category'] = "videos";
					$subarray['interactive'] = false;
					$subarray['desc'] = "3d Walkthrough";
					$subarray['link'] = $image[$size];
					$subarray['src'] = $image['name'];
					$images[] = (object)$subarray;
				}

			}	
		}

		
		if(is_array($details['multimediaCollection']['homeImages'])) {
			foreach($details['multimediaCollection']['homeImages'] as $image) { 
				if(!in_array($image[$size], $link)) {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$subarray['category'] = "photos";
					$subarray['interactive'] = false;
					$subarray['desc'] = $image['name'];
					$subarray['link'] = $image[$size];
				
					$images[] = (object)$subarray;
				}
			}	
		}

		if(is_array($details['multimediaCollection']['additionalImages'])) {
			foreach($details['multimediaCollection']['additionalImages'] as $image) { 
				if(!in_array($image[$size], $link)) {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$subarray['category'] = "photos";
					$subarray['interactive'] = false;
					$subarray['desc'] = $image['name'];
					$subarray['link'] = $image[$size];
				
					$images[] = (object)$subarray;
				}
			}	
		}

		if(is_array($details['multimediaCollection']['floorPlans'])) {
			foreach($details['multimediaCollection']['floorPlans'] as $image) { 
				//list($width, $height, $type, $attr) = getimagesize($image[$size]);
				$subarray['category'] = "floorplans";
				$subarray['desc'] = $image['name'];
				$subarray['interactive'] = false;
				$subarray['link'] = $image[$size];
				$images[] = (object)$subarray;
			}	
		}

		$communityDetails = $this->getCommunityDetails($this->setCommunityName($collection));
		if(is_array($communityDetails['sitePlans'])) {
			foreach($communityDetails['sitePlans'] as $image) { 
				$subarray['category'] = "sitemaps";
				if (isset($image['interactive']) || array_key_exists('interactive', $image)) { 
                    $subarray['interactive'] = true;
                } else {
                    $subarray['interactive'] = false;
                }
				$subarray['desc'] = $image['base']['description'];
				$subarray['link'] = $image['base'][$size];
				$subarray['map_name'] = $image['interactive']['map_name'];
				$subarray['src'] = $image['interactive']['src'];
				$images[] = (object)$subarray;
			}	
		}

		return $images;

	}

	public function getAllImagesQDH($model, $size, $collection, $fullname = false, $qdh=false) {
		
		$images = [];
		$details = $this->getModelDetails($model);
		$link = [];

		if($qdh) {
			$qdhDetails = $this->getQDHDetails($qdh);
			$qdhImage = $qdhDetails['multimediaCollection']['homeImages'][0]['S1920x1080'];
			$link[] = $qdhImage;
			$subarray['category'] = "photos";
			$subarray['interactive'] = false;
			$subarray['desc'] = $qdh;
			$subarray['link'] = $qdhImage;
			$images[] = (object)$subarray;

		}

		if(is_array($details['multimediaCollection']['otherMultimedia'])) {
			foreach($details['multimediaCollection']['otherMultimedia'] as $image) { 
				if ($image['type'] == "1012") {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$link[] = $image[$size];
					$subarray['category'] = "photos";
					$subarray['interactive'] = false;
					$subarray['desc'] = $image['name'];
					$subarray['link'] = $image[$size];
					$images[] = (object)$subarray;
				}

				if ($image['type'] == "10006") {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$link[] = $image[$size];
					$subarray['category'] = "videos";
					$subarray['interactive'] = false;
					$subarray['desc'] = "3d Walkthrough";
					$subarray['link'] = $image[$size];
					$subarray['src'] = $image['name'];
					$images[] = (object)$subarray;
				}

			}	
		}

		if(is_array($details['multimediaCollection']['additionalImages'])) {
			foreach($details['multimediaCollection']['additionalImages'] as $image) { 
				if(!in_array($image[$size], $link)) {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$subarray['category'] = "photos";
					$subarray['interactive'] = false;
					$subarray['desc'] = $image['name'];
					$subarray['link'] = $image[$size];
				
					$images[] = (object)$subarray;
				}
			}	
		}
		
		if(is_array($details['multimediaCollection']['homeImages'])) {
			foreach($details['multimediaCollection']['homeImages'] as $image) { 
				if(!in_array($image[$size], $link)) {
					//list($width, $height, $type, $attr) = getimagesize($image[$size]);
					$subarray['category'] = "photos";
					$subarray['interactive'] = false;
					$subarray['desc'] = $image['name'];
					$subarray['link'] = $image[$size];
				
					$images[] = (object)$subarray;
				}
			}	
		}

		if(is_array($details['multimediaCollection']['floorPlans'])) {
			foreach($details['multimediaCollection']['floorPlans'] as $image) { 
				//list($width, $height, $type, $attr) = getimagesize($image[$size]);
				$subarray['category'] = "floorplans";
				$subarray['desc'] = $image['name'];
				$subarray['interactive'] = false;
				$subarray['link'] = $image[$size];
				$images[] = (object)$subarray;
			}	
		}

		$communityDetails = $this->getCommunityDetails($collection);
		if(is_array($communityDetails['sitePlans'])) {
			foreach($communityDetails['sitePlans'] as $image) { 
				$subarray['category'] = "sitemaps";
				if (isset($image['interactive']) || array_key_exists('interactive', $image)) { 
                    $subarray['interactive'] = true;
                } else {
                    $subarray['interactive'] = false;
                }
				$subarray['desc'] = $image['base']['description'];
				$subarray['link'] = $image['base'][$size];
				$subarray['map_name'] = $image['interactive']['map_name'];
				$subarray['src'] = $image['interactive']['src'];
				$images[] = (object)$subarray;
			}	
		}

		return $images;

	}

	public function getCommunitySitePlans($size) {
		$images = [];
			foreach($this->comm_data['sitePlans'] as $image) { 
				$subarray['category'] = "siteplans";
				if (isset($image['interactive']) || array_key_exists('interactive', $image)) { 
                    $subarray['interactive'] = true;
                } else {
                    $subarray['interactive'] = false;
                }
				$subarray['desc'] = $image['base']['description'];
				$subarray['link'] = $image['base'][$size];
				$subarray['map_name'] = $image['interactive']['map_name'];
				$subarray['src'] = $image['interactive']['src'];
				$images[] = (object)$subarray;	
		}

		return $images;
	}

	public function getQDHModel($name) {
		
		foreach($this->comm_data['communityList'] as $community) {
					if(is_array($community['models'])) {
					foreach($community['models'] as $models) {
							if(is_array($models['QDHList'])) {
								foreach($models['QDHList'] as $qd_homes) {
									if($qd_homes['name'] == $name) return $models['name'];
								}
							}
						}
					}
			}

	}

	public function getModelss($name) {
		foreach($this->comm_data['communityList'] as $community) {
			//if($name == $community['name']) {
				return $community['models'];
			//}
		}
	}


	public function getCommunities() {
		return $this->models;
	}

	public function getModelImages() {
		return $this->homeImages;
	}

	public function getQDHList() {
		return $this->qdhList;
	}

	public function getModelDetails($name) {
		foreach($this->comm_data['models'] as $model) {
			if($model['name'] == $name)
			return $model;
		}
	}

	public function getModelDetailsComm($name, $collection) {
		$collName = $this->setCommunityName($collection);
		$collDetails = $this->getCommunityDetails($collName);

		$models = $collDetails['models'];

			foreach($models as $model) {
				if($model['name'] == $name)
				return $model;
			}
	}

	public function getDYOH($name) {
					foreach($this->comm_data['models'] as $model) {
						if($model['name'] == $name) {
							if(is_array($model['multimediaCollection']['otherMultimedia'])) {
								foreach($model['multimediaCollection']['otherMultimedia'] as $mmid) {
									if($mmid['type'] == 10001) {
										return $mmid['name'];
									}
								}
							}
						}
				}
		return false;
	}

	public function getCommunityName($name) {
		for($i=0; $i<sizeof($this->comm_data['communityList']); $i++) {
			$models = $this->comm_data['communityList'][$i]['models'];
			if(is_array($models)) {
				foreach($models as $model) {
					if($model['name'] == $name)
					return $this->comm_data['communityList'][$i]['name'];
				}
			}
		}
	}

	public function getQDHDetails($id) {
			
			foreach ($this->comm_data['models'] as $index => $model) {
				if(is_array($model['QDHList'])) {
					foreach($model['QDHList'] as $qdh) {
						//echo $qdh['masterPlanId'];
						if($id == $qdh['name']) return $qdh;
					}
				}

			}
		
	}

	public function getCommunityDetails($name) {
		foreach($this->comm_data['communityList'] as $community) {
			if($name == $community['name']) {
				return $community;
			}
		}
	}

	public function text_shortener($text, $length) {
	    
	    if(strlen($text) > $length) {
	        $text = substr($text, 0, strpos($text, ' ', $length)) . "...";
	    }

    	return $text;
	}

	public function homeCollectionImages() {
		$images['ambassador'] = "https://cdn.tollbrothers.com/communities/12760/images/020_COCM_12_3_12_Ana_CC_920.jpg";
		 $images['estate'] = "https://cdn.tollbrothers.com/communities/12760/images/020_COCM_12_3_12_Ana_CC_920.jpg";
		 $images['heritage'] = "https://cdn.tollbrothers.com/communities/12760/images/020_COCM_12_3_12_Ana_CC_920.jpg";
	}

}
