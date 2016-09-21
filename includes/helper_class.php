<?php

class helpers {

	public function getLargestImage($imgObj) {

		$imgLink = $imgObj['link'];

		if (isset($imgObj['S1920x1080'])) {
			$imgLink = $imgObj['S1920x1080'];
			$w = 1920;
			$h = 1080;
		} else if (isset($imgObj['S1800x815'])) {
			$imgLink = $imgObj['S1800x815'];
			$w = 1800;
			$h = 815;
		} else if (isset($imgObj['S920x630'])) {
			$imgLink = $imgObj['S920x630'];
			$w = 920;
			$h = 630;
		} else if (isset($imgObj['S600x355'])) {
			$imgLink = $imgObj['S600x355'];
			$w = 600;
			$h = 355;
		} else if (isset($imgObj['S450x266'])) {
			$imgLink = $imgObj['S450x266'];
			$w = 450;
			$h = 266;
		} else if (isset($imgObj['S300x177'])) {
			$imgLink = $imgObj['S300x177'];
			$w = 300;
			$h = 177;
		} else if (isset($imgObj['S220x130'])) {
			$imgLink = $imgObj['S220x130'];
			$w = 220;
			$h = 130;
		} 

		$imgData = array("link" => $imgLink, "w" => $w, "h" => $h);
		return $imgData;
	}

	function URLifyString($dirty) {
		$clean = str_replace(" ","-",str_replace(" - ","-",$dirty));

		return urlencode($clean);
	}

}


class sitePlans {

	//This outputs the required siteplan JS.
	//It's expecting the $communityList
	public function outputJSdata($communityList) {

		echo '<link rel="stylesheet" type="text/css" href="//cdn.tollbrothers.com/tb/ws_siteplan/css/toll.ws_site_plan.min.css" />';
        echo '<script type="text/javascript" src="https://cdn.tollbrothers.com/tb/ws_siteplan/js/toll.ws_site_plan.min.js"></script>';

        echo '<script type="text/javascript">';
            echo 'var spByComm = {};';
            echo 'var siteplans = [];'; 

			foreach ($communityList as $community) {

				echo "siteplans = [];\n";

				foreach ( $community['sitePlans'] as $sitePlan) {
					echo "siteplans.push(";
					echo json_encode($sitePlan);
					echo ");";
				}

				echo "spByComm.comm_";
				echo $community['communityId'];
				echo"={'siteplans' : siteplans, 'url' : '" . $community['url'] . "'};\n";

			}

        echo '</script>'; 

	}
}


class commDataObj {


	//public $helpers = new helpers;

	private $theData = null;
	private $isMasterComm = false;

	private $modelList = array();
	private $qdhList = array();

	public function initData($data) {

		if (isset($data['communityList'])) {
			$isMasterComm = true;
			$theData = $data['communityList'];
		} else {
			$theData = array($data);
		}


		//Set Models & QDHs:
		foreach ( $theData as $community) {
			if (isset($community['models'])) {
				foreach ( $community['models'] as $model) {

					if (!$model['nobts']) { //Check for FarmHouses and the like.
						$modelWithComm = $model;
						$modelWithComm["communityId"] = $community['communityId']; //adding communityId for filtering...

						//$helpers->getLargestImage("sdfsdfdsf");
						$modelWithComm["localLink"] = "makeLinkHere";
						array_push($this->modelList,$modelWithComm);
					}

					if (isset($model['QDHList'])) {
						foreach ( $model['QDHList'] as $QDH) {
							$QDHWithComm = $QDH;
							$QDHWithComm["communityId"] = $community['communityId']; //adding communityId for filtering...
							array_push($this->qdhList,$QDHWithComm);
						} //QDHs
					}  //end of isset for QDHs

				} //For Each Models
			} //models isSet
		} //foreach community


	}


	public function getModels($communityId = 0) { //might need a communityID and a default arg? $commID = 0;
		if ($communityId == 0) {
			$commModel = array();
			foreach ( $this->modelList as $model) {
				//return $this->modelList;
				$model["localLink"] = "makeLinkHere";
				array_push($commModel,$model);
			}
			return $commModel;

		} else {
			$commModel = array();
			foreach ( $this->modelList as $model) {
				if ($model["communityId"] == $communityId) {
					array_push($commModel,$model);
				}
			}	
			return $commModel;
		}
	}

	public function getQDHs($communityId = 0) { //might need a communityID and a default arg? $commID = 0;
		if ($communityId == 0) {
			return $this->qdhList;
		} else {
			$commQDH = array();
			foreach ( $this->qdhList as $QDH) {
				if ($QDH["communityId"] == $communityId) {
					array_push($commQDH,$QDH);
				}
			}	
			return $commQDH;
		}
	}

}



?>