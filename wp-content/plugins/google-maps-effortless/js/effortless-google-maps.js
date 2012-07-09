/*****************************************************************
 * file: effortless-google-maps.js
 *
 * Prep our map interface.
 *
 *****************************************************************/
var map;
var opts;
var markers;

/***************************
  * Cyber Sprocket Labs Namespace
  *
  * For stuff to do awesome stuff
  *
  */
  var csl_egm = {
  	  
      
        /***************************
  	  	 * Location services
  	  	 * usage:
  	  	 * 		gets the users current location
  	  	 */
        LocationServices: function() {
            this.theService = null;
            
            this.__init = function() {
                try {
                    if (typeof navigator.geolocation == 'undefined') {
                        this.theService = google.gears.factory.create('beta.geolocation');
                    }
                    else {
                        this.theService = navigator.geolocation;
                    }
                } catch (e) {}
            };
            
            this.currentLocation = function(callback, errorCallback) {
                if (this.theService) {
                    this.theService.getCurrentPosition(callback, errorCallback);
                }
            };
            
            this.__init();
        },
         
		/***************************
  	  	 * Animation enum technically
  	  	 * usage:
  	  	 * 		Animation enumeration 
  	  	 */
  	  Animation: { Bounce: 1, Drop: 2, None: 0 },
  	  
	  /***************************
  	  	  * Marker for google maps
  	  	  * usage:
  	  	  * create a google maps marker
  	  	  * parameters:
  	  	  * 	animationType: The Animation type to do the animation
		  *		map: the csl.Map type to put it on
		  *		title: the title of the marker for mouse over
		  *		iconUrl: todo: load a custom icon, null for default
		  *		position: the lat/long to put the marker at
  	  	  */
  	  Marker: function (animationType, map, title, iconUrl, position) {
  	  	  this.__animationType = animationType;
  	  	  this.__map = map;
  	  	  this.__title = title;
  	  	  this.__icon = iconUrl;
  	  	  this.__position = position;
  	  	  this.__gmarker = null;
  	  	  
  	  	  this.__init = function() {
  	  	  	 this.__gmarker = new google.maps.Marker(
  	  	  	  	  {
  	  	  	  	  	  position: this.__position,
  	  	  	  	  	  map: this.__map.gmap,
  	  	  	  	  	  animation: this.__animationType,
  	  	  	  	  	  position: this.__position,
  	  	  	  	  	  title: this.__title,
  	  	  	  	  });
  	  	  }
  	  	  
  	  	  this.__init();
  	  },
      
      /***************************
  	 * Popup info window Object
  	 * usage:
  	 * create a google info window
  	 * parameters:
  	 * 	content: the content to show by default
  	 */
  	Info: function (content) {
		this.__content = content;
  	  	this.__position = position;
  	  	
  	  	this.__anchor = null;
  	  	this.__gwindow = null;
  	  	this.__gmap = null;
  	  	
  	  	this.openWithNewContent = function(map, object, content) {
			this.__content = content;
  	  		this.__gwindow = setContent = this.__content;
  	  	  	this.open(map, object);
  	  	}
  	  	  
  	  	this.open = function(map, object) {
			this.__gmap = map.gmap;
  	  	  	this.__anchor = object;
  	  	  	this.__gwindow.open(this.__gmap, this.__anchor);
  	  	}
  	  	  
  	  	this.close = function() {
			this.__gwindow.close();
  	  	}
  	  	  
  	  	this.__init = function() {
			this.__gwindow = new google.maps.InfoWindow(
  	  	  	{
				content: this.__content
  	  	  	});
  	  	}
  	  	  
  	  	this.__init();
  	},
  	  
  	  /***************************
  	  	  * Map Object
  	  	  * usage:
  	  	  * create a google maps object linked to a map/canvas id
  	  	  * parameters:
  	  	  * 	aMapNumber: the id/canvas of the map object to load from php side
  	  	  */
  	  Map: function(aMapNumber) {
  	  	  //private: map number to look up at init
  	  	  this.__mapNumber = aMapNumber;
          this.__locationServices = new csl_egm.LocationServices();
          this.__infoWindow = new google.maps.InfoWindow();
		  
		  //function callbacks
		  this.tilesLoaded = null;
  	  	  
  	  	  //php passed vars set in init
  	  	  this.address = null; //y
  	  	  this.zoom = null; //y
  	  	  this.view = null; //y
  	  	  this.canvasID = null;
  	  	  this.draggable = true; //n
  	  	  this.overviewMapControl = true; //n
  	  	  this.panControl = true; //n
  	  	  this.rotateControl = true; //n
  	  	  this.scaleControl = true; //n
  	  	  this.scrollwheel = true; //n
  	  	  this.streetViewEnabled = true; //n
  	  	  this.tilt = 45; //n
  	  	  this.zoomAllowed = true; //n
  	  	  this.disableDefaultUI = false; //n
  	  	  this.zoomStyle = 0; // 0 = default, 1 = small, 2 = large
          this.includeUserLocation = false; //n
  	  	  
  	  	  //gmap set variables
  	  	  this.options = null;
  	  	  this.gmap = null;
  	  	  this.centerMarker = null;
          this.userMarker = null;
  	  	  
  	  	  /***************************
  	  	  * function: __geocodeResult
  	  	  * usage:
		  * Called when the geocode is complete
  	  	  * parameters:
  	  	  * 	results: some usable results (see google api reference)
  	  	  *		status:  the status of the geocode (ok means g2g)
  	  	  * returns: none
  	  	  */
  	  	  this.__geocodeResult = function(results, status) {
  	  	  	  if (status == 'OK' && results.length > 0)
  	  	  	  {
  	  	  	  	  this.options = {
  	  	  	  	  	  center: results[0].geometry.viewport.getCenter(),
  	  	  	  	  	  zoom: parseInt(this.zoom),
  	  	  	  	  	  MapTypeId: this.view,
  	  	  	  	  	  disableDefaultUI: this.disableDefaultUI
  	  	  	  	  };
  	  	  	  	  this.gmap = new google.maps.Map(document.getElementById("canvas" + this.canvasID), this.options);
				  
				  //this forces any bad css from themes to fix the "gray bar" issue by setting the css max-width to none
				  var _this = this;
				  google.maps.event.addListener(this.gmap, 'bounds_changed', function() {
					_this.__waitForTileLoad.call(_this);
				});
				  
  	  	  	  	  this.addMarkerAtCenter();
                  if (this.includeUserLocation) {
                    this.addMarkerAtUser();
                  }
  	  	  	  } else {
  	  	  	  	  alert("Address could not be processed: " + status);
  	  	  	  }
  	  	  }
  	  	  
		  /***************************
  	  	  * function: __waitForTileLoad
  	  	  * usage:
		  * Notifies as the map changes that we'd like to be nofified when the tiles are completely loaded
  	  	  * parameters:
  	  	  * 	none
  	  	  * returns: none
  	  	  */
		  this.__waitForTileLoad = function() {
			var _this = this;
			if (this.__tilesLoaded == null)
			{
				this.__tilesLoaded = google.maps.event.addListener(this.gmap, 'tilesloaded', function() {
					_this.__tilesAreLoaded.call(_this);
				});
			}
		  }
		  
		  /***************************
  	  	  * function: __tilesAreLoaded
  	  	  * usage:
		  * All the tiles are loaded, so fix their css
  	  	  * parameters:
  	  	  * 	none
  	  	  * returns: none
  	  	  */
		  this.__tilesAreLoaded = function() {
            var canvas0 = document.getElementById("canvas" + this.canvasID);
			jQuery(canvas0).find('img').css({'max-width': 'none'});
			google.maps.event.removeListener(this.__tilesLoaded);
			this.__tilesLoaded = null;
		  }
		  
          /***************************
  	  	  * function: addMarkerAtUser
  	  	  * usage:
  	  	  * Puts a pretty marker right on the user's position
  	  	  * parameters:
  	  	  * 	none
  	  	  * returns: none
  	  	  */
          this.addMarkerAtUser = function() {
            var _this = this;
            this.__locationServices.currentLocation(function(position) {
                var bounds = new google.maps.LatLngBounds();
                var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                bounds.extend(_this.gmap.getCenter());
                bounds.extend(latlng);
                _this.gmap.fitBounds(bounds);
                _this.userMarker = new csl_egm.Marker(csl_egm.Animation.Drop, _this, "your location", null, latlng);
            },
            function (positionError) { });
          }
          
  	  	  /***************************
  	  	  * function: addMarkerAtCenter
  	  	  * usage:
  	  	  * Puts a pretty marker right smack in the middle
  	  	  * parameters:
  	  	  * 	none
  	  	  * returns: none
  	  	  */
  	  	  this.addMarkerAtCenter = function() {
  	  	  	  this.centerMarker = new csl_egm.Marker(csl_egm.Animation.Drop, this, "", null, this.gmap.getCenter());
              _this = this;
              google.maps.event.addListener(this.centerMarker.__gmarker, 'click',
              (function () {
                _this.__infoWindow.open(_this.gmap, _this.centerMarker.__gmarker);
              }));
  	  	  }
  	  	  
  	  	  /***************************
  	  	  * function: __init()
  	  	  * usage:
  	  	  * Called at the end of the 'class' due to some browser's quirks
  	  	  * parameters: none
  	  	  * returns: none
  	  	  */
  	  	  this.__init = function() {
  	  	  	  this.address = egmMaps[this.__mapNumber].address;
  	  	  	  this.zoom = egmMaps[this.__mapNumber].zoom;
  	  	  	  this.view = egmMaps[this.__mapNumber].view;
  	  	  	  this.canvasID = egmMaps[this.__mapNumber].id;
  	  	  	  this.disableDefaultUI = egmMaps[this.__mapNumber].disableUI;
              this.includeUserLocation = egmMaps[this.__mapNumber].useSensor;
              this.__infoWindow.setContent('<div style="margin:10px auto;"><strong>' + egmMaps[this.__mapNumber].name + '</strong><br/><a style="font-family: \'Oswald\',sans-serif;font-size:18px;color:#8e8e8e;" href="http://maps.google.com/maps?daddr=' + egmMaps[this.__mapNumber].address  + '" target = "_blank">Como llegar</a></div>');
  	  	  }
  	  	  
  	  	  /***************************
  	  	  * function doGeocode()
  	  	  * usage:
  	  	  * Call to start the geocode of the address and display it on the map if possible
  	  	  * make sure to call init first
  	  	  * parameters: none
  	  	  * returns: none
  	  	  */
  	  	  this.doGeocode = function() {
  	  	  	  var geocoder = new google.maps.Geocoder();
  	  	  	  var _this = this;
  	  	  	  geocoder.geocode(
  	  	  	  	  {
  	  	  	  	  	  'address': this.address
  	  	  	  	  },
  	  	  	  	  function (result, status) {							// This is a little complicated, 
  	  	  	  	  _this.__geocodeResult.call(_this, result, status); }	// but it forces the callback to keep its scope
  	  	  	  );
  	  	  }
  	  	  
  	  	  //dumb browser quirk trick ... wasted two hours on that one
  	  	  this.__init();
  	  }
  }
 
 /***************************
  * function InitializeTheMap()
  *
  * Setup the map settings and get id rendered.
  *
  */
 function InitializeTheMap() {
    for (egmMap in egmMaps)
    {
    	    var cslmap = new csl_egm.Map(egmMap);
    	    cslmap.doGeocode();
    }
 }

/* 
 * When the document has been loaded...
 *
 */
jQuery(document).ready(function(){
        InitializeTheMap();
});

