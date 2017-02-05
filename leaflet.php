<?php
// Copyright (c) 2013-2016 Datenstrom, http://datenstrom.se
// This file may be used and distributed under the terms of the public license.

// Leaflet plugin by nibreh - http://leafletjs.com/
class YellowLeaflet
{
	const VERSION = "0.6.4";
	var $yellow;			//access to API

	// Handle initialisation
	function onLoad($yellow)
	{
		$this->yellow = $yellow;
		$this->yellow->config->setDefault("LeafletJs", "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/");
		$this->yellow->config->setDefault("LeafletCss", "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.3/");
		$this->yellow->config->setDefault("LeafletLongitude", "48.000");
		$this->yellow->config->setDefault("LeafletLatitude", "2.000");
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
			if(empty($height)) $height = "500px";
			if(empty($zoom)) $zoom = "5";
			$output = "<div id=\"leaflet\" style=\"height:".htmlspecialchars($height)."; z-index:0;\">\n";
			$output .="</div>\n";
			$output .= "<script type=\"text/javascript\">\n";
			$output .= "var map = L.map('leaflet', {";
			$output .= "center: [".strencode($longitude).", ".strencode($latitude)."], ";
			$output .= "zoom: ".strencode($zoom);
			$output .= "});\n";
			$output .= "L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {";
			$output .= "attribution: '&copy; <a href=\"https://www.openstreetmap.org\">OpenStreetMap</a>',";
			$output .= "}).addTo(map);\n";
			$output .= "</script>\n";
		}

		if($name=="marker" && $shortcut)
		{
			list($longitude, $latitude, $city, $adress, $textlink, $url) = $this->yellow->toolbox->getTextArgs($text);
			$output .= "<script type=\"text/javascript\">\n";
			$output .= "var marker = L.marker([".strencode($longitude).", ".strencode($latitude)."]).addTo(map);\n";
			$output .= "marker.bindPopup(\"";
			$output .= "<b>".htmlspecialchars($city)."</b><br />";
			if(!empty($adress)) $output .= htmlspecialchars($adress)."<br />";
			if(!empty($textlink)) $output .= "<a href='".htmlspecialchars($url)."'>".htmlspecialchars($textlink)."</a>";
			$output .= "\").closePopup();\n";
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
			$output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$LeafletCss}leaflet.css\">\n";
			$output .= "<script type=\"text/javascript\" src=\"{$LeafletJs}leaflet.js\"></script>\n";
		}
		return $output;
	}
}

$yellow->plugins->register("leaflet", "YellowLeaflet", YellowLeaflet::VERSION);
?>
