# Leaflet plugin 0.6.2

*I wanted a collaborative map, where users can add markers with description and link to a page. For events, or anything else !*

Embed map and add markers with leaflet & Openstreetmap - Plugin for Yellow CMS - https://github.com/datenstrom

http://leafletjs.com - *An open-source JavaScript library for mobile-friendly interactive maps*

![screenshot](https://raw.githubusercontent.com/nibreh/yellow-plugin-leaflet/master/screenshot-leaflet.png)

## How do I install this?

1. [Download and install Yellow](https://github.com/datenstrom/yellow/).
2. [Download plugin](https://github.com/nibreh/yellow-plugin-leaflet/archive/master.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy `master.zip` into your `system/plugins` folder.

To uninstall delete the plugin files.

## How to embed the map?

Create a `[leaflet]` shortcut to embed the map.

To change the default values, following arguments are available:

`LONGITUDE` = set view center, default is 48.000  
`LATITUDE` = set view center, default is 2.000  
`HEIGHT` = map height, pixel, default is 500px  
`ZOOM` = zoom value, default is 5, max is 18

You can also change default values in your configuration.

## How to add markers on the map?

Create a `[marker longitude latitude]` shortcut to add marker on the map.

The following arguments are available: 

`LONGITUDE` = set longitude for the marker   
`LATITUDE` = set latitude for the marker  
`CITY` = name your city or anything else, **in bold** - wrap multiple words into quotes  
`ADRESS` = precise address or anything else - wrap multiple words into quotes  
`TEXTLINK` = description for the link  - wrap multiple words into quotes  
`URL` = url for the link, absolute or relative

## How to get longitude/latitude?

1. Go to [openstreetmap.org](https://www.openstreetmap.org) and enter your adress
2. Look the url in the browser: 
`https://www.openstreetmap.org/way/5013364#map=5/48.000/2.000`
3. Longitude and latitude are the last numbers : 48.000 2.000

To be more precise, use the **query features** as explained [on this blog post](https://blog.openstreetmap.org/2014/12/01/new-query-feature/)

## Example

Embedding a map:

    [leaflet] 
    [leaflet 48.000 2.000]
    [leaflet 48.000 2.000 300px 4]
   
Adding markers on the map:

    [marker 52.5175 13.3882 Berlin]
    [marker 48.85828 2.29450 "Paris, France" "Eiffel Tower"]
    [marker 51.495 -0.083 London "Capital of England" "More on Wikipedia" https://en.wikipedia.org/wiki/London]
