<?php
// Copyright (c) 2013-2016 Datenstrom, http://datenstrom.se
// This file may be used and distributed under the terms of the public license.

// Leaflet plugin by nibreh - http://leafletjs.com/
class YellowLeaflet
{
	const VERSION = "0.7.1";
	var $yellow;			//access to API

	// Handle initialisation
	function onLoad($yellow)
	{
		$this->yellow = $yellow;
		$this->yellow->config->setDefault("LeafletJs", "https://unpkg.com/leaflet@1.1.0/dist/leaflet.js");
		$this->yellow->config->setDefault("LeafletCss", "https://unpkg.com/leaflet@1.1.0/dist/leaflet.css");
		$this->yellow->config->setDefault("ClusterJs", "https://unpkg.com/leaflet.markercluster@1.0.6/dist/leaflet.markercluster.js");
		$this->yellow->config->setDefault("ClusterCss", "https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.css");
		$this->yellow->config->setDefault("ClusterCssDefault", "https://unpkg.com/leaflet.markercluster@1.0.6/dist/MarkerCluster.Default.css");
		$this->yellow->config->setDefault("FullscreenCss", "https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css");
		$this->yellow->config->setDefault("FullscreenJs", "https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js");
		$this->yellow->config->setDefault("LeafletLongitude", "48.000");
		$this->yellow->config->setDefault("LeafletLatitude", "2.000");
		$this->yellow->config->setDefault("LeafletHeight", "500px");
		$this->yellow->config->setDefault("LeafletZoom", "5");
	}

	// Handle page content parsing of custom block
	function onParseContentBlock($page, $name, $text, $shortcut)
	{
		$output = null;
		if($name=="leaflet" && $shortcut)
		{
			list($longitude, $latitude, $height, $zoom ) = $this->yellow->toolbox->getTextArgs($text);
			if(empty($longitude)) $longitude = $this->yellow->config->get("LeafletLongitude");
			if(empty($latitude)) $latitude = $this->yellow->config->get("LeafletLatitude");
			if(empty($height)) $height = $this->yellow->config->get("LeafletHeight");
			if(empty($zoom)) $zoom = $this->yellow->config->get("LeafletZoom");
			$output = "<div id=\"leaflet\" style=\"height:".htmlspecialchars($height)."; z-index:0;\"></div>\n";
			$output .= "<script type=\"text/javascript\"> \n";
			// TILE LAYER
			$output .= "var tileLayer = new L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {";
        	$output .= "attribution: '&copy; <a href=\"https://www.openstreetmap.org\">OpenStreetMap</a>'}); \n";	
			// CLUSTERGROUP AND SUBGROUP
			$output .= "var markers = new L.markerClusterGroup(); \n";
			// VAR MAP
			$output .= "var map = L.map('leaflet', {\n";
			$output .= "center: [".strencode($longitude).", ".strencode($latitude)."], \n";
			$output .= "zoom: ".strencode($zoom).", \n";
			$output .= "layers: [tileLayer, markers]}); \n";
			// FULLSCREEN
			$output .= "map.addControl(new L.Control.Fullscreen());\n";
			$output .= "</script>\n";
		}

		if($name=="marker" && $shortcut)
		{
			list($longitude, $latitude, $city, $adress, $textlink, $url) = $this->yellow->toolbox->getTextArgs($text);
			$output .= "<script type=\"text/javascript\">\n";
			$output .= "var marker = L.marker([".strencode($longitude).", ".strencode($latitude)."]);\n";
			$output .= "marker.bindPopup(\"";
			$output .= "<b>".htmlspecialchars($city)."</b><br />";
			if(!empty($adress)) $output .= htmlspecialchars($adress)."<br />";
			if(!empty($textlink)) $output .= "<a href='".htmlspecialchars($url)."'>".htmlspecialchars($textlink)."</a>";
			$output .= "\").closePopup();\n";
			$output .= "marker.addTo(markers);\n";
			$output .= "</script>\n";
		}
		return $output;
	}

	// Handle page extra HTML data
	function onExtra($name)
	{
		$output = null;
		if($name=="header")
		{
			$LeafletJs = $this->yellow->config->get("LeafletJs");
			$LeafletCss = $this->yellow->config->get("LeafletCss");
			$ClusterJs = $this->yellow->config->get("ClusterJs");
			$ClusterCss = $this->yellow->config->get("ClusterCss");
			$ClusterCssDefault = $this->yellow->config->get("ClusterCssDefault");
			$FullscreenCss = $this->yellow->config->get("FullscreenCss");
			$FullscreenJs = $this->yellow->config->get("FullscreenJs");
			$output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$LeafletCss}\">\n";
			$output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$ClusterCss}\">\n";
			$output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$ClusterCssDefault}\">\n";
			$output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$FullscreenCss}\">\n";
			$output .= "<script type=\"text/javascript\" src=\"{$LeafletJs}\"></script>\n";
			$output .= "<script type=\"text/javascript\" src=\"{$ClusterJs}\"></script>\n";
			$output .= "<script type=\"text/javascript\" src=\"{$FullscreenJs}\"></script>\n";
		}
		return $output;
	}
}

$yellow->plugins->register("leaflet", "YellowLeaflet", YellowLeaflet::VERSION);
?>
