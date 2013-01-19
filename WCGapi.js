/** 
 * WCG Javascript Library for Ericsson Leif and Bowser Browser 
 * This version supports ROAP only 
 * 
 * @version 2.1.4 ROAP 
 * Copyright: 2012 Ericsson 
 */

if (typeof Logs === "undefined") {
	Logs = true;
}
	
(function(parent) {
	// noop logger
	// note that all three functions are present in console and can be used
	var logger = {
		log: function(){},
		warn: function(){},
		error: function(){}
	};
	
	// op logger. Only enable due to a flag. At the moment, no flag (true).
	// Change this to disable logging in one place.
	if (Logs)
		logger = console;


	// WCG URL resources
	var SESSION = "session",
		REGISTER_RESOURCE = "register",
		AUDIOVIDEO_RESOURCE = "audiovideo",
		CHANNEL_RESOURCE = "channels"

	// Presence service descriptions. Taken from RCS specs document
	var SERVICE = {
		MESSAGING_STANDALONE : {
			serviceDescription : "org.3gpp.urn:urn-7:3gpp-application.ims.iari.rcs.sm",
			serviceVersion : "1.0"
		},
		MESSAGING_SESSION_MODE : {
			serviceDescription : "org.openmobilealliance:IM-session",
			serviceVersion : "1.0"
		},
		FILE_TRANSFER : {
			serviceDescription : "org.openmobilealliance:File-Transfer",
			serviceVersion : "1.0"
		},
		IMAGE_SHARE : {
			serviceDescription : "org.gsma.imageshare",
			serviceVersion : "1.0"
		},
		VIDEO_SHARE_1 : {
			serviceDescription : "org.gsma.videoshare",
			serviceVersion : "1.0"
		},
		VIDEO_SHARE_2 : {
			serviceDescription : "org.gsma.videoshare",
			serviceVersion : "2.0"
		},
		SOCIAL_PRESENCE : {
			serviceDescription : "org.3gpp.urn:urn-7:3gpp-application.ims.iari.rcse.sp",
			serviceVersion : "1.0"
		},
		CAPABILITY_DISCOVERY : {
			serviceDescription : "org.3gpp.urn:urn-7:3gpp-application.ims.iari.rcse.dp",
			serviceVersion : "1.0"
		},
		VOICE_CALL : {
			serviceDescription : "org.3gpp.urn:urn-7:3gpp-service.ims.icsi.mmtel",
			serviceVersion : "1.0"
		},
		VIDEO_CALL : {
			serviceDescription : "org.3gpp.urn:urn-7:3gpp-service.ims.icsi.mmtel",
			serviceVersion : "1.0"
		},
		GEOLOCATION_PUSH : {
			serviceDescription : "org.3gpp.urn:urn-7:3gpp-application.ims.iari.rcs.geopush",
			serviceVersion : "1.0"
		},
		GEOLOCATION_PULL : {
			serviceDescription : "org.3gpp.urn:urn-7:3gpp-application.ims.iari.rcs.geopull",
			serviceVersion : "1.0"
		}
	};
	
	// TODO: this is a parameter that can be fetched with getParameter from the REST API
	var MAX_MEDIA_SIZE = 51200; // Media message size
	
	// Signature on this can vary. Basically it has a URL to the gateway and some form of access token.
	// It auto-registers after the current event loop
	/**
	Creates a new MediaServices instance. This instance can be used to request new media services and to respond to incoming media requests.
	@class The MediaServices class is the main entry point of the application. It registers with the media gateway, 
	creates outgoing calls, and accepts incoming calls.<br />
	@property {MediaServices.State} state State of the MediaServices.
	@property {String} mediaType The media type(s) supported by this MediaServices object.
	@property {String} turnConfig The TURN server URL. (e.g. "provserver.televolution.net") Defaults to "NONE" if not set.
	@property {String} username (readyonly)
	@param {String} gwUrl URL to the MediaGateway, including the protocol scheme (e.g. "http://127.0.0.1:9191/HaikuServlet/rest/v2/"). This is also described as the base URL.
	@param {String} username Name/identity to register with the Media Gateway. For SIP users, start with "sip:" (e.g. "sip:name@domain.com")
	@param {String} authentication SIP password or authorization token. If registering with oAuth, this parameter should begin with "oauth" (e.g. "oauth mytoken")
	@param {String} services Media services that the user supports. Any combination of "audio,video,ftp,chat".
	@throws {TypeError} Invalid username
	@throws {Error} Invalid user services
	@example
ms = new MediaServices("http://127.0.0.1:9191/HaikuServlet/rest/v2/", "sip:name@domain.com", "0faeb2c", "audio,video");
// or
ms = new MediaServices("http://127.0.0.1:9191/HaikuServlet/rest/v2/", "name@domain.com", "oauth 0faeb2c", "audio");
ms.onclose = function(evt) {};
ms.onerror = function(evt) {};
ms.oninvite = function(evt) {};
ms.onstatechange = function(evt) {};
ms.onready = function(evt) {
	// Perform an action, such as outgoing call
};
	*/
	MediaServices = function(gwUrl, username, authentication, services) {
		var _state = MediaServices.State.INITIALISED,
			_services = services,
			_turnConfig = "NONE",
			_username = username;
			
		if (!gwUrl) gwUrl = "http://10.97.33.50:38080/HaikuServlet/rest/v2";

		/**
		Base URL including session ID ("baseURL"/"sessionID"/)
		@private
		*/
		this._gwUrl = (gwUrl.substr(-1) == "/") ? gwUrl : gwUrl + "/";
		
		/**
		Event channel
		@private
		*/
		this._channel = null;
		
		/*
		Role of the user (Moderator or Normal user)
		@private
		*/
		this._isModerator = null;
		
		/**
		Current Call object
		@private
		*/
		this._call = null;
		
		/**
		Is user a SIP user or Web user
		@private
		*/
		this._isSipUser = (username.indexOf("sip:") == 0) ? true : false;
		
		
		/**
		Session ID (the ID is needed for file transfer)
		@private
		*/
		this._sessionID = null;
		
		/**
		Access token (used for oAuth)
		E.g. "oauth mytoken"
		@private
		*/
		this._accessToken = (authentication.indexOf("oauth ") == 0) ? authentication.substring(6, authentication.length) : null;
		
		/**
		@field state
		Object's state
		*/
		Object.defineProperty(this, "state", {
			get: function()
			{
				return _state;
			},
			
			set: function(newState)
			{
				var evt = {type: "statechange", oldState : _state, state: newState};
				_state = newState;
				
				if (typeof(this.onstatechange) == "function")
					this.onstatechange(evt);
					
				// Dispatch appropriate states
				if (newState == MediaServices.State.READY && typeof(this.onready) == "function")
					this.onready(evt);
				else if (newState == MediaServices.State.CLOSED && typeof(this.onclose) == "function")
					this.onclose(evt);
			}
		});
		
		/**
		@field mediaType
		@readonly
		The media type(s) supported by this MediaServices object
		*/
		Object.defineProperty(this, "mediaType", {
			get: function() { return _services; }
		});
		
		/**
		@field turnConfig
		The TURN server configuration
		*/
		Object.defineProperty(this, "turnConfig", {
			get: function() { return _turnConfig; },
			set: function(turnConfig) { _turnConfig = turnConfig; }
		});
		
		/*
		//@field contactList
		*/
		Object.defineProperty(this, "contactList", {
			get: function() { return this._contactList; }
		});
		
		/*
		//@field willingness
		*/
		Object.defineProperty(this, "willingness", {
			get: function() { return this._willingness; },
			set: function(willingness) {
				this._willingness = willingness;
				this._publish({ willingness : willingness });
			}
		});
		
		/*
		//@field tagline
		*/
		Object.defineProperty(this, "tagline", {
			get: function() { return this._tagline; },
			set: function(tagline) {
				this._tagline = tagline; 
				this._publish({ freeText : tagline });
			}
		});
		
		/*
		//@field homepage
		*/
		Object.defineProperty(this, "homepage", {
			get: function() { return this._homepage; },
			set: function(homepage) {
				this._homepage = homepage;
				if (homepage.url && homepage.label) {
					this._publish({ homepage : homepage });
				}
			}
		});
		
		/**
		@field username
		@readonly
		*/
		Object.defineProperty(this, "username", {
			get: function() { return _username; }
		});

		// Auto register right away
		this._register(username, authentication);
		
		// The following swizzling permits the register to do reg/unreg/rereg to flush out
		// inconsistent states in the network...
		
		var secondReg = false;
		var _realOnReady = null;
		var _realOnClose = null;
		var _realonstatechange = null;
		
		var mt = this;
		
		Object.defineProperty(this, "onready", {
		
			get: function() {
				console.log("onready...");
				if (secondReg)
					return _realOnReady;
					
				console.log("Returning unregister function for onready");
				return function() { setTimeout(function() { mt.unregister() }, 500); };
			},
			
			set: function(newFun) {
				_realOnReady = newFun;
			}
		
		});
		
		Object.defineProperty(this, "onclose", {
		
			get: function() {
				console.log("onclose");
				if (secondReg)
					return _realOnClose;
					
				return function() { 
					secondReg = true;
					setTimeout(function() { 
						mt._gwUrl = (gwUrl.substr(-1) == "/") ? gwUrl : gwUrl + "/";
						mt._register(username, authentication); 
					}, 500); };
			},
			
			set: function(newFun) {
				_realOnClose = newFun;
			}
		
		});
		
		Object.defineProperty(this, "onstatechange", {
			get: function() {
				if (secondReg)
					return _realonstatechange;
				return null;
			},
			
			set: function(fun) { _realonstatechange = fun; }
		});
		
		window.addEventListener("beforeunload", function() { mt.unregister(); }, true);
	};
	
	/**
	TODO: keep this private?
	@private
	*/
	MediaServices.prototype._getVersion = function() {
		var url = this._gwUrl + "application/version";
		var req = new _CreateXmlHttpReq();
			
		req.open("GET", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.send(null);
		
		req.onreadystatechange = function() {
			if (this.readyState == 4) {
				if (this.status == 200) {
					logger.log(this.responseText);
				}
			}
		};	
	};
	
	/**
	TODO: keep this private?
	@private
	*/
	MediaServices.prototype._getInfo = function() {
		var url = this._gwUrl + "application/info";
		var req = new _CreateXmlHttpReq();
			
		req.open("GET", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.send(null);
		
		req.onreadystatechange = function() {
			if (this.readyState == 4) {
				if (this.status == 200) {
					logger.log(this.responseText);
				}
			}
		};	
	};
	
	/**
	WCG user registration
	@private
	@return void
	@throws {Error} Invalid username
	@throws {Error} Invalid authentication
	@throws {Error} Invalid user services
	*/
	MediaServices.prototype._register = function(username, authentication) {
		var mediaService = this;
		var registerURL = this._gwUrl + REGISTER_RESOURCE;
		
		logger.log("Media service initialised");

		if (typeof(username) != "string" || username == "") {
			throw new Error(MediaServices.Error.INVALID_CREDENTIALS);
		//} else if (typeof(authentication) != "string" || authentication == "") {
		//	throw new Error(MediaServices.Error.INVALID_CREDENTIALS);
		} else if (typeof(this.mediaType) != "string") {
			throw new TypeError(MediaServices.Error.INVALID_SERVICES);
		} else {
			// Check if user services are valid
			var _services = [];
		
			var tokens = this.mediaType.toLowerCase().replace(/(\s)/g, "").split(",");
			
			for (var i = 0; i < tokens.length; i++) {
				if (tokens[i] == "audio") {
					_services.push("ip_voice_call");
				} else if (tokens[i] == "video") {
					_services.push("ip_video_call");
				} else if (tokens[i] == "ftp") {
					_services.push("file_transfer");
				} else if (tokens[i] == "chat") {
					_services.push("im_chat");
				}
			}
			
			if (_services.length < 1) {
				throw new Error("Invalid user services");
			}
			
			var body = null;
			if (this._isSipUser) {
				// Remove "sip:" prefix
				// username = username.slice(4, username.length);
			
				// SIP users supports Address Book and Presence by default
				//_services.push("ab");
				//_services.push("presence");
				
				body = {
					username : username,
					password : authentication,
					mediaType : "rtmp",
					services : _services
				};
			} else {
				body = {
					username : username,
					mediaType : "rtmp",
					services : _services
				};
			}
				
			// Create and send a register request
			var req = new _CreateXmlHttpReq(this._accessToken);
			
			req.open("POST", registerURL, true);
			req.setRequestHeader("Content-Type", "application/json");
			req.setRequestHeader("Accept", "application/json, text/html");
			req.send(JSON.stringify(body, null, " "));
			
			// On response
			req.onreadystatechange = function() {
				if (this.readyState == 4) {
					mediaService.state = MediaServices.State.REGISTERING;
					logger.log("Registering...");
					
					// Success response 201 Created
					if (this.status == 201) {
						// Extract the sessionID from JSON body
						var json = JSON.parse(this.responseText);
						var tokens = json.resourceURL.split("/");
						var index = tokens.indexOf("session");
						
						mediaService._sessionID = tokens[index + 1];
						mediaService._gwUrl += SESSION + '/' + mediaService._sessionID + '/';
						
						// Start polling the event channel
						mediaService._channel = new _Channel(mediaService);
						mediaService._channel.pollChannel();					
						
						logger.log("Registration successful");
						
						mediaService.state = MediaServices.State.READY;
					} else {
						logger.log("Registration unsuccessful: " + this.status + " " + this.statusText);
						
						switch (this.status) {
							case 401: // 401 Unauthorized
							case 403: // 403 Forbidden
								_InternalError(mediaService, MediaServices.Error.INVALID_CREDENTIALS);
								break;
							default:
								_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
								break;
						}
					}
				}
			};
		}
	};
	
	/**
	@namespace Describes the possible states of the MediaServices object.
	*/
	MediaServices.State = {};
	
	/**
	The MediaServices object is initialised, but has not yet begun registration with the media gateway
	*/
	MediaServices.State.INITIALISED = 0;
	
	/**
	The MediaServices object registration and authentication are in progress
	*/
	MediaServices.State.REGISTERING = 1;
	
	/**
	The MediaServices object has registered and authenticated, and can now be used to create and receive media
	*/
	MediaServices.State.READY = 2;
	
	/**
	The MediaServices object unregistration is in progress
	*/
	MediaServices.State.UNREGISTERING = 3;
	
	/**
	The MediaServices object session has ended in a controlled and expected manner, and the object can no longer be used
	*/
	MediaServices.State.CLOSED = 4;
	
	/**
	The MediaServices object session has ended abruptly, in an unexpected manner (network failure, server error, etc), and the object can no longer be used
	*/
	MediaServices.State.ERROR = 5;
	
	/**
	@namespace Describes the possible errors of the MediaServices object.
	*/
	MediaServices.Error = {};
	
	/**
	Generic network failure.
	*/
	MediaServices.Error.NETWORK_FAILURE = 0;
	
	/**
	Registration failed due to invalid credentials. 
	*/
	MediaServices.Error.INVALID_CREDENTIALS = 1;
	
	/**
	Registration failed due to invalid services. 
	*/
	MediaServices.Error.INVALID_SERVICES = 2;
	
	/**
	Re-registers the client. 
	@function
	@return void
	@example
ms.reregister();
	*/
	MediaServices.prototype.reregister = function() {
		var mediaService = this;
		var reregisterURL = mediaService._gwUrl + REGISTER_RESOURCE;
		
		logger.log("Reregistering...");
		
		this.state = MediaServices.State.REGISTERING;
		
		// Create a new logout request
		var req = new _CreateXmlHttpReq(this._accessToken);
		
		req.open("PUT", reregisterURL, true);
		req.setRequestHeader("X-http-method-override", "PUT");
		req.setRequestHeader("Accept", "application/json, text/html");
		req.send(null);
		
		// On response
		req.onreadystatechange = function() {
			if (this.readyState == 4) {
				var json = JSON.parse(this.responseText);
			
				// Success response 200 OK
				if (this.status == 200) {
					logger.log("Reregistration successful " + json.expires);
					
					mediaService.state = MediaServices.State.READY;
				} else {
					logger.log("Reregistration unsuccessful: " + this.status + " " + this.statusText);
					
					_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
				}
			}
		};
	};
	
	/**
	Unregisters the user from the current media service session. When completed successfully, MediaServices will change state to CLOSED.
	@function
	@return void
	@example
ms.unregister();
	*/
	MediaServices.prototype.unregister = function() {
		var mediaService = this;
		var unregisterURL = mediaService._gwUrl + REGISTER_RESOURCE;
		
		logger.log("Deregistering...");
		
		this.state = MediaServices.State.UNREGISTERING;
		
		// Create a new logout request
		var req = new _CreateXmlHttpReq();
		
		req.open("DELETE", unregisterURL, true);
		req.setRequestHeader("X-http-method-override", "DELETE");
		req.setRequestHeader("Accept", "application/json, text/html");
		req.send(null);
		
		// On response
		req.onreadystatechange = function() {
			if (this.readyState == 4) {
				// Success response 204 No content
				if (this.status == 204) {
					mediaService._clean();
					
					logger.log("Deregistration successful");
					
					mediaService.state = MediaServices.State.CLOSED;
				} else {
					logger.log("Deregistration unsuccessful: " + this.status + " " + this.statusText);
					_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
				}
			}
		};
	};
	
	/*
	TODO: is this function useful?
	*/
	MediaServices.prototype.anonymousSubscribe = function() {
		var mediaService = this;
		
		var url = this._gwUrl + PRESENCE_RESOURCE + '/' + PRESENCE_RESOURCE_USER + '/' + PRESENCE_RESOURCE_USER_ANONYMOUS 
			+ '/' + PRESENCE_RESOURCE_USER_SUBSCRIBE;
		
		logger.log("Anonymous subscribing...");
		
		var list = [];
		
		if (this._contactList) {
			for (var i in this._contactList.contact) {
				list.push("tel:+" + this._contactList.contact[i]._id);
			}
		}
		
		if (list.length == 0) {
			logger.log("No one to subscribe to");
			return;
		}
		
		var body = {
			entities : list
		};
		
		// Create and send a follow contact request
		var req = new _CreateXmlHttpReq();
		
		req.open("POST", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.setRequestHeader("Content-Type", "application/json");
		req.send(JSON.stringify(body, null, " "));
	
		// On response
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// Success response 202 Accepted
				if (req.status == 202) {
					logger.log("Anonymous subscribe successful");
				} else {
					var json = JSON.parse(req.responseText);
					logger.log("Anonymous subscribe failed: " + json.reason);
					_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
				}
			}
		};
	};
	
	/*
	Obtain to the Presence information of your subscription list (contacts with follow relationship). Done automatically upon registration
	//@function
	//@return void
	//@example
ms.subscribe();
	*/
	MediaServices.prototype.subscribe = function() {
		var mediaService = this;
		
		var url = this._gwUrl + PRESENCE_RESOURCE + '/' + PRESENCE_RESOURCE_USER + '/' + PRESENCE_RESOURCE_USER_SUBSCRIBE;
		
		logger.log("Subscribing...");
		
		// Create and send a follow contact request
		var req = new _CreateXmlHttpReq();
		
		req.open("POST", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.send(null);
	
		// On response
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// Success response 201 Created
				if (req.status == 201) {
					logger.log("Subscribe successful");
				} else {
					var json = JSON.parse(req.responseText);
					logger.log("Subscribe failed: " + json.reason);
					_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
				}
			}
		};
	};
	
	/*
	Publish willingness, tagline and homepage
	//@private
	*/
	MediaServices.prototype._publish = function(presenceData) {
		var mediaService = this;
		
		var url = this._gwUrl + PRESENCE_RESOURCE + '/' + PRESENCE_RESOURCE_USER + '/' + PRESENCE_RESOURCE_USER_PUBLISH;
		
		logger.log("Publishing services...");
		
		var body = {
			person : presenceData
		};
		
		// Create and send a follow contact request
		var req = new _CreateXmlHttpReq();
		
		req.open("POST", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.setRequestHeader("Content-Type", "application/json");
		req.send(JSON.stringify(body, null, " "));
	
		// On response
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// Success response 201 Created
				if (req.status == 201) {
					logger.log("Publish services successful");
				} else {
					var json = JSON.parse(req.responseText);
					logger.log("Publish services failed: " + json.reason);
					
					_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
				}
			}
		};
	};
	
	/*
	Set the avatar for self.
	//@function
	//@param {File} avatar Image avatar file 
	//@param {Function} [callback] Success/failure callback function
	//@throws {TypeError} Invalid avatar file
	//@return void
	//@example
var avatar = document.getElementById("avatar");
ms.setAvatar(avatar.files[0], function(evt) {
	if (evt.success == true) {
		// Set avatar successful
	} else if (evt.failure == true) {
		// Set avatar unsuccessful
	}
});
	*/
	MediaServices.prototype.setAvatar = function(avatar, callback) {
		if (!(avatar instanceof File)) {
			throw new TypeError("Invalid avatar file");
		}
		if (avatar.type.indexOf("image") != 0) {
			throw new TypeError("Invalid avatar file");
		}
	
		var url = this._gwUrl + CONTENT_RESOURCE + '/' + CONTENT_RESOURCE_SETAVATAR;
		
		var body = new FormData(); // Chrome 7+, Firefox 4+, Internet Explorer 10+, Safari 5+
		body.append("Filename", avatar.name);
		body.append("ClientId", this._sessionID);
		body.append("Filedata", avatar);
		body.append("Upload", "Submit Query");
		
		// Create and send a set avatar request
		var req = new _CreateXmlHttpReq();
		
		req.open("POST", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.send(body);
	
		// On response
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				var status = false;
				
				switch (req.status) {
					// Success response 201 Created (no previous avatar)
					case 201:
					// Success response 204 No Content
					case 204:
						logger.log("Set avatar successful");
						status = true;
				
						if (typeof(callback) == "function") {
							var event = {success : true, failure: false};
							callback(event);
						}
						break;
					default:
						var json = JSON.parse(req.responseText);
						logger.log("Set avatar failed: " + json.reason);
						
						if (typeof(callback) == "function") {
							var event = {success : false, failure: true};
							callback(event);
						}
						break;
				}
			}
		};
	};
	
	/*
	Delete the avatar for self.
	//@function
	//@return void
	//@example
ms.deleteAvatar();
	*/
	MediaServices.prototype.deleteAvatar = function() {
		var mediaService = this;
		
		var url = this._gwUrl + CONTENT_RESOURCE + '/' + CONTENT_RESOURCE_DELETEAVATAR;
		
		// Create and send a set avatar request
		var req = new _CreateXmlHttpReq();
		
		req.open("DELETE", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.send(null);
	
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// Success respone 204 No Content
				if (req.status == 204) {
					logger.log("Delete avatar successful");
				} else {
					var json = JSON.parse(req.responseText);
					logger.log("Delete avatar unsuccessful" + json.reason);
					
					_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
				}
			}
		};
	};
	
	/*
	Publish services. Done automatically upon successful registration.
	TODO: keep this private? We only publish the services the user used on registration.
	//@private
	*/
	MediaServices.prototype._publishServices = function() {
		var mediaService = this;
		
		var url = this._gwUrl + PRESENCE_RESOURCE + '/' + PRESENCE_RESOURCE_USER + '/' + PRESENCE_RESOURCE_USER_PUBLISH;
		
		logger.log("Publishing services...");
		
		var _services = [];
		var tokens = this.mediaType.replace(/(\s)/g, "").split(",");
		
		// Check which services the user registered with and publish those
		for (var i = 0; i < tokens.length; i++) {
			if (tokens[i] == "audio") {
				var service = SERVICE.VOICE_CALL;
				service.serviceStatus = "open";
				_services.push(service);
			} else if (tokens[i] == "video") {
				var service = SERVICE.VIDEO_CALL;
				service.serviceStatus = "open";
				_services.push(service);
			} else if (tokens[i] == "ftp") {
				var service = SERVICE.FILE_TRANSFER;
				service.serviceStatus = "open";
				_services.push(service);
			} else if (tokens[i] == "chat") {
				var service = SERVICE.MESSAGING_SESSION_MODE;
				service.serviceStatus = "open";
				_services.push(service);
			} else {
				// Invalid service
				_services = [];
				break;
			}
		}
		
		if (_services.length < 1) {
			throw new Error("Invalid user services");
		}
		
		var body = {
			services : _services
		};
		
		// Create and send a publish services request
		var req = new _CreateXmlHttpReq();
		
		req.open("POST", url, true);
		req.setRequestHeader("Accept", "application/json, text/html");
		req.setRequestHeader("Content-Type", "application/json");
		req.send(JSON.stringify(body, null, " "));
	
		// On response
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// Success response 201 Created
				if (req.status == 201) {
					logger.log("Publish services successful");
				} else {
					var json = JSON.parse(req.responseText);
					logger.log("Publish services failed: " + json.reason);
					
					_InternalError(mediaService, MediaServices.Error.NETWORK_FAILURE);
				}
			}
		};
	};
	
	/*
	Clean parameters on deregistration.
	//@private
	*/
	MediaServices.prototype._clean = function() {
		// Clear channel
		this._channel = null;
		
		// Clear peer connection
		if (this._call) {
			if (this._call._pc && this._call._pc.close) {
				this._call._pc.close();
				this._call._pc = null;
			}
			delete this._call;
			this._call = null;
		}

	};
	
	/**
	Creates a new outgoing call object to a given recipient. The Call will be initialised, but will not ring until the {@link OutgoingCall#ring} method is called.
	@function
	@param {String} recipient An identifier denoting the callee. This can be a WebID, a SIP URI or a tel: URI
	@param {Object} [mediaType] Defines the getUserMedia() type of the Call. If specified, must be of format {audio:true} or {video:true} or {audio:true,video:true}. If unspecified, inherits the full set of media types of the MediaServices object.
	@return {OutgoingCall} A newly initialised OutgoingCall object
	@throws {Error} Recipient must be defined, and must be a string
	@throws {Error} Invalid media types
	@example
var call = ms.createCall("user2", {video:true});
call.onaddstream = function(evt) {};
call.onbegin = function(evt) {};
call.onend = function(evt) {};
call.onerror = function(evt) {};
call.onremovestream = function(evt) {};
call.onstatechange = function(evt) {};
call.ring();
	*/
	MediaServices.prototype.createCall = function(recipient, mediaType) {
		if (typeof(recipient) != "string" || recipient == "")
			throw new Error("Recipient must be defined, and must be a string");
		logger.log("MediaServices.prototype.createCall.... " );
		mediaType = _ParseMediaType(this, mediaType);
		this._isModerator = true;
		
		this._call = new OutgoingCall(this, recipient, mediaType);
		this._call._url = this._gwUrl + AUDIOVIDEO_RESOURCE;
		
		return this._call;
	};

	// Callback functions for MediaServices
	/**
	Called when the MediaServices object is ready to use.
	@event 
	@type function
	@param evt
	@example
ms.onready = function(evt) {
	// Media service is ready to use.
};
	*/
	MediaServices.prototype.onready = function(evt){}; // The MediaServices object is ready to use
	
	/**
	Called when MediaServices has encountered an error
	@event 
	@type function
	@param evt Error event
	@param {String} evt.type "error"
	@param {MediaServices.Error} evt.reason Error code
	@param {MediaServices} evt.target Proximal event target
	@example
var ms = new MediaServices(...);
ms.onerror = function(evt) {
	switch (evt) {
		case MediaServices.Error.NETWORK_FAILURE:
			// Handle
			break;
		case MediaServices.Error.INVALID_CREDENTIALS:
			// Handle
			break;
		// ...
	}
};
	*/
	MediaServices.prototype.onerror = function(evt){}; // An error occurred. See the event for details.
	
	/**
	Called when the MediaServices object has closed in an orderly fashion.
	@event 
	@type function
	@param evt
	@example
ms.onclose = function(evt) {
	// Media service has closed properly.
};
	*/
	MediaServices.prototype.onclose = function(evt){}; // The session has ended and this MediaServices object is no longer available to use
	
	/**
	Called when MediaServices changes its state.
	@event
	@type function
	@param evt Event describing the state change
	@param {Call.State} evt.newState New state
	@param {Call.State} evt.oldState Old state
	@example
ms.onstatechange = function(evt) {
	switch (evt.newState) {
		case MediaServices.State.INITIALISED:
			// Call state has changed to READY
			break;
		case MediaServices.State.REGISTERING:
			// Call state has changed to ENDED
			break;
		// ...
	}
};
	*/
	MediaServices.prototype.onstatechange = function(evt){}; // The MediaServices object has changed state
	
	/**
	Called when the MediaServices object receives a remote media event such as an incoming call.
	@event
	@type function
	@param evt
	@param {IncomingCall} evt.call An IncomingCall object
	@example
ms.oninvite = function(evt) {
	if (evt.call) {
		// We have an incoming call
		// This is a regular IncomingCall object that can be freely manipulated.
		evt.call.answer();
	}
};
	*/
	MediaServices.prototype.oninvite = function(evt){}; // An invitation to a call has been received
	
	/**
	Call is a generic handler for calls. The abstract Call object handles signaling and termination of calls. These calls
	are sessions to another user. This is a private constructor.
	@class Call is a generic handler for calls and includes all methods for dealing with an ongoing call. The abstract Call 
	object can handle signaling and termination of calls.  These calls can be sessions to another user. 
	For outgoing calls to other recipients, see {@link OutgoingCall}. For incoming calls from other users, see {@link IncomingCall}. <br />
	@property {Call.state} state The call's current state (read only).
	@property {MediaStream[]} localStreams Contains a list of local streams being sent on this call (read only).
	@property {MediaStream[]} remoteStreams Contains a list of remote streams being received on this call (read only).
	@property {String} mediaType Type of media for this call. This field can be changed until media has been established.
	@param {MediaServices} mediaServices The object that created this Call object.
	@param {String} recipient Call recipient
	@param {String} mediaType Media types supported in this call (e.g. "audio", "video" or "audio,video").
	*/
	Call = function(mediaServices, recipient, mediaType) {
		var _state;
		
		/**
		@field mediaType
		Call media type 
		*/
		Object.defineProperty(this, "mediaType", {
			get: function() { return mediaType; },
			set: function(newType) { 
				if (this._pc != null) 
					throw "Cannot change media type after established media.";
				mediaType = newType;
			}
		});

		/**
		@field state
		Call state
		*/
		Object.defineProperty(this, "state", {
			get: function()
			{
				return _state;
			},
			
			set: function(newState)
			{
				var evt = {type: "statechange", oldState : _state, state: newState};
				_state = newState;
				
				if (typeof(this.onstatechange) == "function")
					this.onstatechange(evt);
					
				// Dispatch appropriate states
				switch (newState) {
					case Call.State.RINGING:
						if (this instanceof IncomingCall) {
							var evt = { call: this, conf: null };
							if (typeof(mediaServices.oninvite) == "function") { mediaServices.oninvite(evt); }
						}
						break;
					case Call.State.ENDED:
						if (typeof(this.onend) == "function") { this.onend(evt); }
						break;
					case Call.State.ONGOING:
						if (typeof(this.onbegin) == "function") { this.onbegin(evt); }
						break;
					default:
						break;
				}
			}
		});

		/**
		@field remoteStreams
		Remote streams of the call
		*/
		Object.defineProperty(this, "remoteStreams", {
			get: function() {
				if (this._pc) { return this._pc.remoteStreams; }
				else { return []; }
			}
		});

		/**
		@field localStreams
		Local streams of the call
		*/
		Object.defineProperty(this, "localStreams", {
			get: function() {
				if (this._pc) { return this._pc.localStreams; }
				else { return []; }
			}
		});
		
		
		this.recipient = recipient;
		
		/**
		Media service object
		@private
		*/
		this._mediaServices = mediaServices;
		
		/**
		Base URL including session ID ("baseURL"/"sessionID"/)
		@private
		*/
		this._url = null;
		
		/**
		A reference to the local PeerConnection object. The call re-exposes the relevant elements.
		@private
		*/
		this._pc = null;
		
		/**
		Current call ID
		@private
		*/
		this._callID = null;
		
		/**
		Remote SDP object
		@private
		*/
		this._sdp = {};
		
		/**
		Array of Ice candidates
		@private
		*/
		this._candidates = [];
		
		/**
		Has OFFER been sent
		@private
		*/
		this._isSignalingSent = false;
		
		/**
		Mod ID
		@deprecated Used for ROAP support.
		@private
		*/
		this._DEPRECATEDmodID = null;
		
		/**
		ROAP handling object
		@deprecated Used for ROAP support.
		@private
		*/
		this._DEPRECATEDroap = new _DEPRECATEDRoap();
	};
	
	/**
	@namespace Describes the possible states of the call object.
	*/
	Call.State = {};
	
	/**
	Notifies that call object is ready for outgoing calls
	*/
	Call.State.READY = 0;
	
	/**
	Notifies that call object is ringing; an incoming call needs to be answered or an outgoing call needs the remote side to answer
	*/
	Call.State.RINGING = 1;
	
	/**
	Notifies that call object is in progress and media is flowing
	*/
	Call.State.ONGOING = 2;
	
	/**
	Notifies that call object has ended normally; the call was terminated in an expected and controlled manner
	*/
	Call.State.ENDED = 3;
	
	/**
	Notifies that call object has ended with an error; the call was terminated in an unexpected manner (see {@link Call.Error} for more details)
	*/
	Call.State.ERROR = 4;
	
	/**
	@namespace Describes the possible errors of the call object.
	*/
	Call.Error = {};
	
	/**
	General network failure
	*/
	Call.Error.NETWORK_FAILURE = 0;
	
	/**
	Peer Connection setup failure
	*/
	Call.Error.PEER_CONNECTION = 1;
	
	/**
	Webkit media error
	*/
	Call.Error.USER_MEDIA = 2;

	/**
	Gets the string representing the State ID. This can be called at any time and is useful for debugging
	@return {String} State A string representing the state of the Call 
	@example
call.getStringState();
	*/
	Call.prototype.getStringState = function() {
	switch (_state) {
	case Call.State.READY:
		return "READY";
		break;
	case Call.State.RINGING:
		return "RINGING";
		break;
	case Call.State.ONGOING:
		return "ONGOING";
		break;
	case Call.State.ENDED:
		return "ENDED";
		break;

	default:
		return "ERROR";
		break;
	}
	};
	
	/**
	Terminates all media in the call. This can be called at any time
	@return void
	@throws {Error} No active call to end
	@example
call.end();
	*/
	Call.prototype.end = function() {
		var _call = this;
		var audiovideoURL = this._url + '/' + this._callID;
		
		logger.log("Leaving call...");
		
		var req = new _CreateXmlHttpReq();
		
		req.open("DELETE", audiovideoURL, true);
		req.setRequestHeader("X-http-method-override", "DELETE");
		req.send(null);
	
		// On response
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// Success response 204 No content
				if (req.status == 204) {
					logger.log("Leave call successful");
					
					// Clear moderator flag
					_call._mediaServices._isModerator = null;
					
					_call.state = Call.State.ENDED;
				} else {
					var json = JSON.parse(req.responseText);
					logger.log("Leave call unsuccessful: " + json.reason);
					
					// 403 Forbidden, Call-ID does not exist
					if (req.status == 403) {
						throw new Error("No active call to end");
					} else {
						_InternalError(_call, Call.Error.NETWORK_FAILURE);
					}
				}
			}
		};
		
		if (this._pc && this._pc.close)
			this._pc.close();
		this._pc = null;
	};
	
	/**
	Creates a Peer Connection and triggers signaling when ready
	@private
	*/
	Call.prototype._createPeerConnection = function(callback) {
		var mt = this;
		logger.log("in createPeerConnection " + callback);
		var medias= (typeof(mt.mediaType.video) == "undefined")?'audio':'audio, video'; 
		console.log("call with : " + medias);

		// Get the user's media
		navigator.webkitGetUserMedia(medias, function(stream) {
			// Create new PeerConnection
			mt._pc = new webkitPeerConnection00(mt._mediaServices.turnConfig, function(candidate, moreToFollow) {
				// Get all candidates before signaling
				if (candidate) {
					mt._sdp.sdp.addCandidate(candidate);
				}
				
				if (!moreToFollow && !mt._isSignalingSent) {
					mt._sendSignaling(mt._sdp.type, mt._sdp.sdp.toSdp());
					
					mt._isSignalingSent = true;
				}
			});
			
			// Add the local stream
			mt._pc.addStream(stream);
			
			// Propagate the event
			mt._pc.onaddstream = function(evt) { if (typeof(mt.onaddstream) == "function") { evt.call = mt; mt.onaddstream(evt);} };
			mt._pc.onremovestream = function(evt) { logger.log("ONREMOVESTREAM"); if (typeof(mt.onremovestream) == "function")  { evt.call = mt; mt.onremovestream(evt);} };
			mt._pc.onclose = function() { mt.onend(); };
			mt._pc.onopen = function() { mt.state = Call.State.ONGOING; };
			
			if (typeof(callback) === "function") {
				callback();
			}
		}, function(error) {
			logger.log("Error obtaining user media: " + error.toString());
			
			var callType = Call;
			_InternalError(callType, callType.Error.USER_MEDIA);
		});
	};
	
	/**
	WCG signalling
	@private
	*/
	Call.prototype._sendSignaling = function(type, sdp) {
		var _call = this;
		var url = this._url;
		
		var callType = Call;
		
		if (type == "OFFER") {
			logger.log("Sending OFFER");
			
				// Audio video invite
				var body = _ParseSDP(this.recipient, sdp);
				
				var req = new _CreateXmlHttpReq();
				//if(!this._mediaServices._isModerator){
				//	url= url + "/mod";
				//}				
				req.open("POST", url, true);
				req.setRequestHeader("Content-Type", "application/json");
				req.setRequestHeader("Accept", "application/json, text/html");
				req.send(JSON.stringify(body, null, " "));
			
				// On response
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						var json = JSON.parse(req.responseText);
						
						// Success response 201 Created
						if (req.status == 201) {
							logger.log("Audio video invite: " + json.state);
						} else if (req.status == 202) {
							// TODO: remove eventually, this is what is returned from webrtc_trial branch
						} else {
							logger.log("Audio video invite unsuccessful: " + json.reason);
							
							if (req.status == 400) {
								throw new Error("User not found");
							} else {
								_InternalError(_call, _call.Error.NETWORK_FAILURE);
							}
						}
					}
				};
			
		} else if (type == "ANSWER") {
			logger.log("Sending ANSWER");
			url += "/" + this._callID;
			
			var body = _ParseSDP(null, sdp);
			
			var req = new _CreateXmlHttpReq();
			
			req.open("POST", url, true);
			req.setRequestHeader("Content-Type", "application/json");
			req.setRequestHeader("Accept", "application/json, text/html");
			req.send(JSON.stringify(body, null, " "));
			
			// On response
			req.onreadystatechange = function() {
				if (this.readyState == 4) {
					var json = JSON.parse(req.responseText);
					
					// Success response 200 OK
					if (req.status == 200) {
						logger.log("Accept invite: " + json.state);
					} else {
						logger.log("Accept invite unsuccessful: " + json.reason);
						
						_InternalError(_call, _call.Error.NETWORK_FAILURE);
					}
				}
			};
		}
	};
	
	/**
	Create offer
	@private
	*/
	Call.prototype._doOffer = function() {
		// Create offer
		var offer = this._pc.createOffer(this.mediaType);
		this._pc.setLocalDescription(this._pc.SDP_OFFER, offer);
		
		// Start Ice
		this._pc.startIce();
		
		this._sdp.type = "OFFER";
		this._sdp.sdp = offer;
	};
	
	/**
	Create answer
	@private
	*/
	Call.prototype._doAnswer = function() {
		var sd = new SessionDescription(this._sdp.sdp);
		
		// Receive offer
		this._pc.setRemoteDescription(this._pc.SDP_OFFER, sd);
		
		// Create answer
		var answer = this._pc.createAnswer(this._pc.remoteDescription.toSdp(), this.mediaType);
		this._pc.setLocalDescription(this._pc.SDP_ANSWER, answer);
		
		// Start Ice
		this._pc.startIce();
		
		this._sdp.type = "ANSWER";
		this._sdp.sdp = answer;
		
		// Process Ice candidates
		for (index in this._candidates) {
			var candidate = new IceCandidate(this._candidates[index].label, this._candidates[index].candidate);
			this._pc.processIceMessage(candidate);
		}
	};
	
	/**
	Creates a Peer Connection and triggers signaling when ready
	@deprecated Used for ROAP support.
	@private
	*/
	Call.prototype._DEPRECATEDcreatePeerConnection = function(callback, roapMessage) {
		var mt = this;
		var medias= (typeof(mt.mediaType.video) == "undefined")?'audio':'audio, video'; 
		console.log("call with : " + medias);
		navigator.webkitGetUserMedia(medias, function(stream) {
			try {
				mt._pc = new webkitDeprecatedPeerConnection(mt._mediaServices.turnConfig, function(sig) {
				
					logger.log("turnConfig: " + mt._mediaServices.turnConfig + "   sig: " + sig);
					mt._DEPRECATEDsendSignaling(sig, function(event) {
						if (typeof(callback) == "function") {
							callback(event);
						}
					});
				});
			} catch (e) {	
				mt._pc = new webkitPeerConnection00(mt._mediaServices.turnConfig, function(sig) {
					logger.log("turnConfig: " + mt._mediaServices.turnConfig + "   sig: " + sig);
					mt._DEPRECATEDsendSignaling(sig, function(event) {
						if (typeof(callback) == "function") {
							callback(event);
						}
					});
				});
			}
			
			// Add the local stream
			mt._pc.addStream(stream);
			
			// Propagate the event
			mt._pc.onaddstream = function(evt) { if (typeof(mt.onaddstream) == "function") { evt.call = mt; mt.onaddstream(evt);} };
			mt._pc.onremovestream = function(evt) { logger.log("ONREMOVESTREAM"); if (typeof(mt.onremovestream) == "function")  { evt.call = mt; mt.onremovestream(evt);} };
			mt._pc.onclose = function() { mt.onend(); };
			mt._pc.onopen = function() { mt.state = Call.State.ONGOING; };
			logger.log("Event propagated");
			
			if (roapMessage) {
				// Signal the ANSWER
				mt._pc.processSignalingMessage(roapMessage);
			}
		}, function(error) {
			logger.log("Error obtaining user media: " + error.toString());
			
			var callType = Call;
			_InternalError(mt, callType.Error.USER_MEDIA);
		});
	};
	
	/**
	WCG signalling
	@deprecated Used for ROAP support.
	@private
	*/
	Call.prototype._DEPRECATEDsendSignaling = function(sig, callback) {
		var _call = this;
		
		var roap = this._DEPRECATEDroap.parseROAP(sig);
		var url = this._url;
		var callType = Call;
		logger.log("Roap Message Type: " + roap.messageType);
		if (roap.messageType == "OFFER") {
			logger.log("Got OFFER");
				// Audio video invite
				var body = {
					to : this.recipient,
					sdp : roap.SDP.sdp,
					v : roap.SDP.sdp.v,
					o : roap.SDP.sdp.o,
					s : roap.SDP.sdp.s,
					t : roap.SDP.sdp.t
				};
				
				var req = new _CreateXmlHttpReq();
//				if(!this._mediaServices._isModerator){
//					//var roapsdp = "v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=\r\nt=0 0\r\n";
//					var remotesdp= roap.SDP.sdp;
//					for(mediaIndex in roap.SDP.sdp) {
//					   if(roap.SDP.sdp[mediaIndex].c == ""){
//						  roap.SDP.sdp[mediaIndex].c= "IN IP4 10.10.0.55";
//					   }
//					}
//
//					body.v= "0";
//					body.o= "- 0 0 IN IP4 127.0.0.1";
//					body.s= "";
//					body.t= "0 0";
//					
//					url= url + "/" + this._mediaServices._call._callID;// + "/mod";
//				}				
//				
				var stringBody= JSON.stringify(body, null, " ");
//				stringBody= stringBody.replace("RTP/AVPF", "RTP/AVP");
//				stringBody= stringBody.replace("ulpfec", "H264");
//				logger.log("about to send SDP: " + stringBody);

				req.open("POST", url, true);
				req.setRequestHeader("Content-Type", "application/json");
				req.setRequestHeader("Accept", "application/json, text/html");
				req.send(stringBody);
			
				// On response
				req.onreadystatechange = function() {
					if (req.readyState == 4) {
						var json = JSON.parse(req.responseText);
						
						// Success response 202 Accepted
						if (req.status == 202 || req.status == 201) {
							logger.log("Audio video invite: " + json.state);
						} else {
							logger.log("Audio video invite unsuccessful: " + req.status + " " + json.reason);
							
							if (req.status == 400) {
								throw new Error("User not found");
							} else {
								_InternalError(_call, callType.Error.NETWORK_FAILURE);
							}
						}
					}
				};
			
		} else if (roap.messageType == "ANSWER") {
			logger.log("Got ANSWER");
			url += "/" + this._callID;
			
			if (this._modID) {
			        url += "/mod/" + this._modID;
			}
			
			var req = new _CreateXmlHttpReq();
							
			var stringBody= JSON.stringify(roap.SDP, null, " ");
//			stringBody= stringBody.replace("RTP/AVPF", "RTP/AVP");
//			stringBody= stringBody.replace("ulpfec", "H264");
//			logger.log("about to send SDP: " + stringBody);
//
			req.open("POST", url, true);
			req.setRequestHeader("Content-Type", "application/json");
			req.setRequestHeader("Accept", "application/json, text/html");
			req.send(stringBody);
			
			// On response
			req.onreadystatechange = function() {
				if (this.readyState == 4) {
					var json = JSON.parse(req.responseText);
					
					// Success response 200 OK
					if (req.status == 200) {
						logger.log("Accept invite: " + json.state);
					} else {
						logger.log("Accept invite unsuccessful: " + json.reason);
						_InternalError(_call, callType.Error.NETWORK_FAILURE);
					}
				}
			};
		} else if (roap.messageType == "OK") {
			logger.log("Got OK");
			
			_call.state = callType.State.ONGOING;
		} else {
			logger.log("Got ERROR");
			logger.log(roap);
			throw new Error("Failed to setup peer connection");
		}
	};
	
	/**
	Called when the Call object changes its state.
	@event
	@type function
	@param evt An event describing the state change
	@param {String} evt.type "statechange"
	@param {Call.State} evt.newState The new state
	@param {Call.State} evt.oldState The old state
	@example
call.onstatechange = function(evt) {
	switch (evt.newState) {
		case Call.State.READY:
			// Call state has changed to READY
			break;
		case Call.State.ENDED:
			// Call state has changed to ENDED
			break;
		// ...
	}
};
	*/
	Call.prototype.onstatechange = function(evt){};
	
	/**
	Called when the call has begun, the call has started and media is now flowing.
	@event
	@type function
	@param evt
	@example
call.onbegin = function(evt) {
	// Call has begun
};
	*/
	Call.prototype.onbegin = function(evt){};
	
	/**
	Called when the call has ended. Media will no longer be flowing as the call was terminated.
	@event
	@type function
	@param evt
	@example
call.onend = function(evt) {
	// Call has ended
};
	*/
	Call.prototype.onend = function(evt){};
	
	/**
	Called when a remote stream is added.
	@event
	@type function
	@param evt An event containing the call object with localStreams and remoteStreams.
	@param {MediaStream} evt.stream The stream that was added.
	@param {Call} evt.call Call object containing the local and remote media streams list.
	@param {MediaStream[]} evt.call.localStreams Local media stream list.
	@param {MediaStream[]} evt.call.remoteStreams Remote media streams list.
	@example
var call = service.createCall(...);
call.onaddstream = function(evt) {
	if (evt.call.localStreams) {
		// Do stuff with the list of local media stream
	}
	if (evt.call.remoteStreams) {
		// Do stuff with the list of remote media stream
	}
};
	*/
	Call.prototype.onaddstream = function(evt){};
	
	/**
	Called when a remote stream is removed.
	@event
	@type function
	@param evt An event containing the call object with localStreams and remoteStreams.
	@param {MediaStream} evt.stream The stream that was removed.
	@param {MediaStream[]} evt.call.localStreams Local media stream list
	@param {MediaStream[]} evt.call.remoteStreams Remote media streams list
	@example
call.onremovestream = function(evt) {
	if (evt.call.localStreams) {
		// Perform actions with the list of local media stream.
	}
	if (evt.call.remoteStreams) {
		// Perform actions with the list of remote media stream.
	}
};
	*/
	Call.prototype.onremovestream = function(evt){};
	
	/**
	Called when the call has encountered an error. The call has encountered an unexpected behavior.
	@event
	@type function
	@param evt Error event
	@param {String} evt.type "error"
	@param {Call.Error} evt.reason Error code
	@param {Object} evt.target Proximal event target
	@example
call.onerror = function(evt) {
	switch (evt.reason) {
		case Call.Error.NETWORK_FAILURE:
			// Handle
			break;
		case Call.Error.PEER_CONNECTION:
			// Handle
			break;
		// ...
	}
};
	*/
	Call.prototype.onerror = function(evt){};
	
	/**
	The OutgoingCall objects can be used to initiate calling.
	@class <p>OutgoingCall objects are created by {@link MediaServices#createCall} and are used to initiate calls to other parties.</p>
	@extends Call
	@param {MediaServices} mediaServices Object that created this Call object.
	@param {String} recipient Call recipient
	@param {String} mediaType Media types supported in this call (i.e. "audio", "video" or "audio,video")
	*/
	OutgoingCall = function(mediaServices, recipient, mediaType) {
		// call parent constructor
		Call.prototype.constructor.call(this, mediaServices, recipient, mediaType);
		
		this.state = Call.State.READY;
		
		logger.log("OutgoingCall created");
	};
	
	OutgoingCall.prototype = new Call;
	OutgoingCall.prototype.constructor = OutgoingCall;
	
	/**
	Initiates the outgoing call, ringing the recipient.
	@function
	@return void
	@example
var call = ms.createCall("user2", "audio, video");
call.ring();
	*/
	OutgoingCall.prototype.ring = function() {
		var call = this;
		
		logger.log("OutgoingCall ringing...");
/*		
		try {
			this._createPeerConnection(function() {
				call._doOffer();
			});
		} catch (e) {
			this._DEPRECATEDcreatePeerConnection();
		}
*/
		this._DEPRECATEDcreatePeerConnection();
		this.state = Call.State.RINGING;
	};
	
	/**
	The IncomingCall objects are provided by MediaService on an incoming call. This is a private constructor.
	@class <p>The IncomingCall objects are provided by mediaServices on an incoming call and are used to answer them.</p>
	@extends Call
	@param {MediaServices} mediaServices Object that created this Call object.
	@param {String} recipient An identifier denoting the recipient; this can be a WebID, a SIP URI, or a tel: URI.
	@param {String} mediaType Media types supported in this call (i.e. "audio", "video" or "audio,video").
	*/
	IncomingCall = function(mediaServices, recipient, mediaType) {
		mediaServices._isModerator= false;
		// call parent constructor
		Call.prototype.constructor.call(this, mediaServices, recipient, mediaType);
		
		/**
		Remote SDP
		@deprecated Used for ROAP support.
		@private
		*/
		this._DEPRECATEDsdp = null;
		
		this.state = Call.State.READY;
		
		logger.log("IncomingCall created");
	};
	
	IncomingCall.prototype = new Call;
	IncomingCall.prototype.constructor = IncomingCall;
	
	/**
	Acknowledges an incoming call and establishes media. Note that if the mediaType of this call is to be changed, it must be changed before a call to answer().
	@function
	@return void
	@example
service.oninvite = function(evt) {
	if (evt.call) {
		evt.call.answer();
	}
};
	*/
	IncomingCall.prototype.answer = function() {
		var call = this;
/*		
		try {
			this._createPeerConnection(function() {
				call._doAnswer();
			});
		} catch (e) {
			var roapMessage = this._DEPRECATEDroap.processRoapOffer(this._mediaServices, this._DEPRECATEDsdp);
			
			this._DEPRECATEDcreatePeerConnection(null, roapMessage);
		}
*/
		var roapMessage = this._DEPRECATEDroap.processRoapOffer(this._mediaServices, this._DEPRECATEDsdp);
			
		this._DEPRECATEDcreatePeerConnection(null, roapMessage);	
	};

	
	
	

	_InternalError = function(obj, code) {
		try {
			if (obj instanceof MediaServices) {
				obj.state = MediaServices.State.ERROR;
			} else if (obj instanceof Call) {
				obj.state = Call.State.ERROR;
			
			}
			
			if (typeof(obj.onerror) == "function") {
				var event = {type: "error", reason: code, target: obj};
				obj.onerror(event);
			}
		} catch (error) {
			logger.log("Invalid ERROR");
		}
	};

	_Base64encode = function(str) {
		var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
		var out, i, len;
		var c1, c2, c3;

		len = str.length;
		i = 0;
		out = "";
		while (i < len) {
			c1 = str.charCodeAt(i++) & 0xff;
			if (i == len) {
				out += base64EncodeChars.charAt(c1 >> 2);
				out += base64EncodeChars.charAt((c1 & 0x3) << 4);
				out += "==";
				break;
			}
			c2 = str.charCodeAt(i++);
			if (i == len) {
				out += base64EncodeChars.charAt(c1 >> 2);
				out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
				out += base64EncodeChars.charAt((c2 & 0xF) << 2);
				out += "=";
				break;
			}
			c3 = str.charCodeAt(i++);
			out += base64EncodeChars.charAt(c1 >> 2);
			out += base64EncodeChars.charAt(((c1 & 0x3)<< 4) | ((c2 & 0xF0) >> 4));
			out += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >>6));
			out += base64EncodeChars.charAt(c3 & 0x3F);
		}
		return out;
	};
	
	/*
	Parse the media types used in createCall. Also checks for invalid services. 
	For example, if the call is created as an audio/video call, but the user has registered with only audio, 
	the call will be reduced to an audio call.
	@private
	@param {MediaServices} mediaServices The parent MediaServices object
	@param {Object} mediaType Media services object(e.g. {audio:true,video:true})
	@return {Object} Mediatypes allowed for this call
	*/
	function _ParseMediaType(mediaServices, mediaType) {
		var parentMedia = mediaServices.mediaType.replace(/(\s)/g, "").split(",");
		var _mediaType = {};
		
		// Inherit media type, if undefined
		if (typeof(mediaType) == "undefined" || Object.keys(mediaType).length == 0) {
			if (parentMedia.indexOf("audio") != -1)
				_mediaType.audio = true;
			if (parentMedia.indexOf("video") != -1)
				_mediaType.video = true;
			
			return _mediaType;
		} else if (typeof(mediaType) != "object" || mediaType == "") {
			throw new Error("Invalid media types");
		}
		
		// Assert media type is allowed. E.g. If parent is only registered for audio, disallow "video" in mediaType.
		if (mediaType.audio) {
			if (mediaType.audio == true && parentMedia.indexOf("audio") != -1)
				_mediaType.audio = true;
		}
		if (mediaType.video) {
			if (mediaType.video == true && parentMedia.indexOf("video") != -1)
				_mediaType.video = true;
		}
		
		return _mediaType;
	}
	
	/**
	Determine the type(s) of media in the SDP by inspeting the "m" field of the SDP
	@private
	@param {Object} sdp An object containing SDP attributes.
	@return {Array} mediaType An array of media types.
	*/
	function _ParseSDPMedia(sdp) {
		// TODO: can know the media type from the a=group:BUNDLE audio video line
		// Find the a=group:BUNDLE line
		// set mediaType.audio = true and/or mediaType.video = true
		
		var mediaType = {};
		
		for (var j = 0;; j++) {
			// Inspect the "m" field of the SDP
			try {
				var m = sdp[j].m;
				if (m.search("audio") != -1) {
					mediaType.audio = true;
				} else if (m.search("video") != -1) {
					mediaType.video = true;
				}
			} catch(error) {
				// Done
				break;
			}
		}
		
		return mediaType;
	}
	
	/**
	Get the number from a Tel or Sip uri
	@private
	*/
	function _GetNumber(uri) {
		if (uri.indexOf("tel:+") == 0) {
			// Tel uri
			return uri.substring(5, uri.length);
		} else if (uri.indexOf("sip:") == 0) {
			// Sip uri
			return uri.substring(4, uri.indexOf("@"));
		} else {
			return "";
		}
	}
	
	/**
	Create an HTTP request
	@private
	@return {XMLHttpRequest} xmlhttp An XML/HTTP request
	*/
	function _CreateXmlHttpReq(token) {
		var xmlhttp = null;

		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else if (window.ActiveXObject) {
			// Users with ActiveX off
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (error) {
				// Do nothing
			}
		}

		if (token) {
			xmlhttp.o = xmlhttp.open;
			xmlhttp.open = function(a, b, c)
			{
				this.o(a,b + "?access_token=" + token,c);
				//this.setRequestHeader('Authorization', 'Bearer ' + token);
			};
		}
		//xmlhttp.withCredentials = true;
		
		return xmlhttp;
	}
	
	/**
	The event channel
	@private
	@param {MediaServices} The MediaServices object
	*/
	function _Channel(mediaService) {
		var timer = 2000,
			channel = this,
			_ms = mediaService;
		
		// Poll the channel
		this.pollChannel = function() {
			var channelURL = _ms._gwUrl + CHANNEL_RESOURCE;
			
			logger.log("Querying channel...");
			
			// Create and send a channel query request
			var req = new _CreateXmlHttpReq();
			
			req.open("GET", channelURL, true);
			req.setRequestHeader('Accept', 'application/json, text/html');
			req.setRequestHeader('Cache-Control', 'no-cache');
			req.setRequestHeader('Pragma', 'no-cache');
			req.send(null);
			
			// On response
			req.onreadystatechange = function() {
				if (this.readyState == 4) {
					// Success response 200 OK
					if (this.status == 200) {
						logger.log("Get channel successful: " + this.status + " " + this.statusText + " " + this.responseText);
					
						var json = JSON.parse(this.responseText);
						
						// Parse channel events
						for (var i = 0;; i++) {
							var eventObject = null;
							
							// Get the event
							try {
								eventObject = json.events.list[i].eventObject;
							} catch (error) {
								// No more events in the list, get out
								break;
							}
							
							var type = eventObject["@type"],
								state = eventObject.state,
								reason = eventObject.reason,
								from = eventObject.from;
							
							// Channel Handlers
							if (type == "audiovideo") {
								var sdp = eventObject.sdp,
									resourceURL = eventObject.resourceURL;
								
								// Tokenize the resourceURL
								var tokens = resourceURL.split("/");
								
								if (state.toLowerCase() == "session-open" || state.toLowerCase() == "session-modified" ) {
									// Audio video call session established
									var mediaConfIndex = tokens.indexOf("mediaconf");
									var audioVideoIndex = tokens.indexOf("audiovideo");
									
									if (mediaConfIndex != -1) {
										_ms._call.confID = tokens[mediaConfIndex + 1];
									} else if (audioVideoIndex != -1) {
										_ms._call._callID = tokens[audioVideoIndex + 1];
									}
									
										// DEPRECATED: to remove this if case
									try {	
										if (_ms._call._pc instanceof webkitDeprecatedPeerConnection) {
											var modIndex = tokens.indexOf("mod");
											if (modIndex != -1) {
												_ms._call._modID = tokens[modIndex + 1];
												
												if (_ms._isModerator) {
													// Nothing
												} else {
													var roapMessage = _ms._call._DEPRECATEDroap.processRoapAnswer(_ms, sdp);
													_ms._call._pc.processSignalingMessage(roapMessage);
												}
											} else {
												if (_ms._isModerator) {
													var roapMessage = _ms._call._DEPRECATEDroap.processRoapAnswer(_ms, sdp);
													_ms._call._pc.processSignalingMessage(roapMessage);
												} else {
													var roapMessage = _ms._call._DEPRECATEDroap.processRoapOK(_ms);
													_ms._call._pc.processSignalingMessage(roapMessage);
												}
											}
										} else {
											if (_ms._isModerator) {
												var sd = new SessionDescription(_SDPToString(sdp));
												
												// Get Ice candidates
												var candidates = _GetCandidates(sd.toSdp());
												_ms._call._candidates = candidates;
												
												// Receive ANSWER SDP of callee
												_ms._call._pc.setRemoteDescription(_ms._call._pc.SDP_ANSWER, sd);
												
												// Process the Ice Candidates
												for (index in candidates) {
													var candidate= new IceCandidate(candidates[index].label, candidates[index].candidate);
													_ms._call._pc.processIceMessage(candidate);
												}
											}
										}
									} catch (e) {
										if (_ms._isModerator) {
											var sd = new SessionDescription(_SDPToString(sdp));
											
											// Get Ice candidates
											var candidates = _GetCandidates(sd.toSdp());
											_ms._call._candidates = candidates;
											
											// Receive ANSWER SDP of callee
											_ms._call._pc.setRemoteDescription(_ms._call._pc.SDP_ANSWER, sd);
											
											// Process the Ice Candidates
											for (index in candidates) {
												var candidate= new IceCandidate(candidates[index].label, candidates[index].candidate);
												_ms._call._pc.processIceMessage(candidate);
											}
										}
									}
								} else if (state.toLowerCase() == "session-terminated") {
									// Audio video call terminated
									if (_ms._call.state != Call.State.ENDED) {
										// Cleanup the Peer Connection
										if (_ms._call) {
											if (_ms._call._pc && _ms._call._pc.close) {
												_ms._call._pc.close();
												_ms._call._pc = null;
											}
										}
										
										// Clear moderator flag
										_ms._isModerator = null;
										
										_ms._call.state = Call.State.ENDED;										

									}
								} else if (state.toLowerCase() == "invitation-received") {
									// Receive audio video call invitation
									var index = tokens.indexOf("audiovideo");
									var mediaType = _ParseSDPMedia(sdp);
									_ms._isModerator= false;
									
									// Set the media type of the call invitation
									mediaType = _ParseMediaType(_ms, mediaType);
									
									// Create a new IncomingCall object and save the remote SDP
									_ms._call = new IncomingCall(_ms, from, mediaType);
									_ms._call._url = _ms._gwUrl + AUDIOVIDEO_RESOURCE;
									_ms._call._callID = tokens[index + 1];
									
									// Parse the SDP
									_ms._call._sdp.type = "ANSWER";
									_ms._call._sdp.sdp = _SDPToString(sdp);
									logger.log(_ms._call._sdp.sdp);
									
									// DEPRECATED: to remove
									_ms._call._DEPRECATEDsdp = sdp;
									
									// Grab the Ice candidates
									_ms._call._candidates = _GetCandidates(_ms._call._sdp.sdp);
									
									_ms._call.state = Call.State.RINGING;
								} else if (state.toLowerCase() == "mod-received") {
									// DEPRECATED: to remove (Reinvite received)
									var index = tokens.indexOf("mod");
									
									_ms._call._modID = tokens[index + 1];
									
									if (_ms._isModerator) {
										var roapMessage = _ms._call._DEPRECATEDroap.processRoapOffer(_ms, sdp);
										_ms._call._pc.processSignalingMessage(roapMessage);
									}
								} else {
									// Unhandled event
									logger.log("Unhandled audio video channel event: " + type + " " + state);
								}
							} else {
								// Unhandled event
								logger.log("Unhandled channel event: " + type + " " + state);
							}
						}
						
						// Poll again
						if (_ms._channel != null) {
							channel.pollChannel();
							timer = 2000;
						}
					}
					// Success response 204 No Content
					else if (this.status == 204) {
						logger.log("Get channel successful: " + this.status + " " + this.statusText + " " + this.responseText);
						
						// Poll again
						if (_ms._channel != null) {
							channel.pollChannel();
							timer = 2000;
						}
					}
					// Error response
					else {
						if (timer >= 128000) {
							// Try to logout since channel hasn't responded for 4 minutes
							_ms.unregister();
						} else {
							// If we are unable to poll the channel, attempt to poll for 2 minutes exponentially, then stop
							if (_ms._channel != null) {
								timer *= 2;
								logger.log("Get channel unsuccessful: " + this.responseText);
								setTimeout(function(){channel.pollChannel();},timer);
							}
						}
					}
				}
			};
		};
	}
	
	/**
	Build WCG signaling SDP object from SDP string
	@private
	@param {String} recipient The recipient of the call
	@param {String} Offer SDP
	@return {Object} The SDP in accepted WCG json format
	*/
	function _ParseSDP(recipient, sdp) {
		var SDP = {};
		
		if (recipient) {
			SDP = {
				to : recipient,
				sdp : []
			};
		} else {
			SDP = {
				sdp : []
			};
		}
		
		var sdp_string = JSON.stringify(sdp);
		// Get the v line
		var v_pattern = /v=(.*?)(?=\\r\\n)/g;
		var v_match = v_pattern.exec(sdp_string);

		// Get the o line
		var o_pattern = /o=(.*?)(?=\\r\\n)/g;
		var o_match = o_pattern.exec(sdp_string);

		// Get the s line
		var s_pattern = /s=(.*?)(?=\\r\\n)/g;
		var s_match = s_pattern.exec(sdp_string);

		// Get the t line
		var t_pattern = /t=(.*?)(?=\\r\\n)/g;
		var t_match = t_pattern.exec(sdp_string);

		// Get the a line
		var a_pattern = /a=(.*?)(?=\\r\\n)/g;
		var a_match = a_pattern.exec(sdp_string);
		
		// Get all media
		var media_pattern = /m=(.*)/g;
		var media_match = media_pattern.exec(sdp_string);
		var media = media_match[1];

		// Split all media
		var media_line_array = media.split("m=");
		
		for (var index in media_line_array) {
			var m = "m=" + media_line_array[index];
			var lines_array = m.split("\\r\\n");
			lines_array.pop();
			
			// For each media, split all the lines
			// Find the m, the c, and the a
			var m_struct = {};
			if (index == 0) {
				m_struct = {
					v : v_match[1],
					o : o_match[1],
					s : s_match[1],
					t : t_match[1],
					a : a_match[1],
					m : "",
					c : "",
					attributes : []
				};
			} else {
				m_struct = {
					m : "",
					c : "",
					attributes : []
				};
			}
			
			for(var i in lines_array) {
				var line = lines_array[i];
						
				if (line[0] == "m") {
					m_struct.m = line.substring(2);
				}
				
				if (line[0] == "c") {
					m_struct.c = line.substring(2);
				}
				
				if (line[0] == "a") { 
					var a_line = {
                                        	a : line.substring(2)
                                        }

					m_struct.attributes.push(a_line);
				}
			}
			
			SDP.sdp.push(m_struct);
		}
		
		logger.log(JSON.stringify(SDP,null, " "));
		
		return SDP;
	}
	
	
	/**
	Build SDP string from SDP object
	@private
	@param {Object} sdp WCG json SDP
	@returns {String} SDP as string
	*/
	function _SDPToString(sdp) {
		// TODO: WCG should return v= o= s= t= a= lines, parse them
		// Hardcode this for now
		var roapsdp = "v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=\r\nt=0 0\r\na=group:BUNDLE audio video\r\n";
		for (mediaIndex in sdp) {
			roapsdp += "m=" + sdp[mediaIndex].m + "\r\n";
			roapsdp += "c=" + sdp[mediaIndex].c + "\r\n";
			for(attributeIndex in sdp[mediaIndex].attributes) {
				roapsdp += "a=" + sdp[mediaIndex].attributes[attributeIndex].a + "\r\n";
			}
		}
		
		return roapsdp;
	}
	
	/**
	Retrieve candidates from sdp
	@private
	@param {String} sdp SDP as string
	@returns {Array} Array of Ice candidates
	*/
	function _GetCandidates(sdp) {
		var candidates = [];
		
		var lines = sdp.split("\r\n");
		var labelIndex = -1;
		
		for (i in lines) {
			if (lines[i].indexOf("m=") == 0) {
				labelIndex++;
			} else if (lines[i].indexOf("a=candidate") == 0) {
				candidates.push({label: labelIndex, candidate: lines[i]});
			}
		}
		
		return candidates;
	}
	
	
	/**
	ROAP message handling object
	@deprecated Used for ROAP support.
	@private
	*/
	function _DEPRECATEDRoap() {
		// WCG roap object 
		var _H2SRoap = {
			messageType : "",
			SDP : [],
			offererSessionId : "" ,
			answererSessionId : "",
			
			reset : function() {
				messageType = "",
				SDP = [],
				offererSessionId = "" ,
				answererSessionId = "";
			}
		};
		
		// Parse a ROAP message and return an SDP
		this.parseROAP = function(message) {
			var json = JSON.parse(message.slice(message.indexOf("{")), message.lastIndexOf("}"));
			_H2SRoap.reset();
			
			_H2SRoap.messageType = json.messageType;
			_H2SRoap.offererSessionId = json.offererSessionId;
			_H2SRoap.answererSessionId = json.answererSessionId;
			_H2SRoap.SDP = null;
				
			if (json.sdp) {
				var SDP = {
					v : "",
					o : "",
					s : "",
					t : "",
					sdp : []
				};
			
				var sdp_string = JSON.stringify(json.sdp);
				// Get the v line
				var v_pattern = /v=(.*?)(?=\\r\\n)/g;
				var v_match = v_pattern.exec(sdp_string);
				SDP.v = v_match[1];

				// Get the o line
				var o_pattern = /o=(.*?)(?=\\r\\n)/g;
				var o_match = o_pattern.exec(sdp_string);
				SDP.o = o_match[1];

				// Get the s line
				var s_pattern = /s=(.*?)(?=\\r\\n)/g;
				var s_match = s_pattern.exec(sdp_string);
				SDP.s = s_match[1];

				// Get the t line
				var t_pattern = /t=(.*?)(?=\\r\\n)/g;
				var t_match = t_pattern.exec(sdp_string);
				SDP.t = t_match[1];

				// Get all media
				var media_pattern = /m=(.*)/g;
				var media_match = media_pattern.exec(sdp_string);
				var media = media_match[1];

				// Split all media
				var media_line_array = media.split("m=");
				
				for (var index in media_line_array) {
					var m = "m=" + media_line_array[index];
					var lines_array = m.split("\\r\\n");
					lines_array.pop();
					
					// For each media, split all the lines
					// Find the m, the c, and the a
					var m_struct = {
						m : "",
						c : "",
						attributes : []
					};
					
					for(var i in lines_array) {
						var line = lines_array[i];
						
						if (line[0] == "m") {
							m_struct.m = line.substring(2);
						}
						
						if (line[0] == "c") {
							m_struct.c = line.substring(2);
						}
						if (line[0] == "a") { 
							var a_line = {
                                		        	a : line.substring(2)
		                                        }
							m_struct.attributes.push(a_line);
						}
						
					}
					
					SDP.sdp.push(m_struct);
				}
				
				_H2SRoap.SDP = SDP;
			}
			
			return _H2SRoap;
		};
		
		// Build the OFFER ROAP message and process it
		this.processRoapOffer = function(mediaServices, sdp) {
			logger.log("Processing an OFFER...");
			var offererSessionId = null;
			var answererSessionId = null;
			var seq = 1;
			if (mediaServices._isModerator) {
				seq = 2;
				offererSessionId = _H2SRoap.offererSessionId;
				answererSessionId = _H2SRoap.answererSessionId;
			} else {
				offererSessionId = this.idGenerator();
				seq = 1;
			}
			var tieBreaker = this.tieBreakerGenerator();

			//build the sdp

			//build the ROAP message
			//the sdp has been set on invitation received
			var roapsdp = "v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=\r\nt=0 0\r\n";
			for (mediaIndex in sdp) {
				roapsdp += "m=" + sdp[mediaIndex].m + "\r\n";
				roapsdp += "c=" + sdp[mediaIndex].c + "\r\n";
				for(attributeIndex in sdp[mediaIndex].attributes) {
					roapsdp += "a=" + sdp[mediaIndex].attributes[attributeIndex].a + "\r\n";
				}
			}

			var roapStruct = {
				"messageType" : "OFFER",
				"offererSessionId" : offererSessionId,
				"answererSessionId" : answererSessionId,
				"sdp" : roapsdp,
				"seq" : seq,
				"tieBreaker" : tieBreaker
			};

			var roapMessage = "SDP\n" + JSON.stringify(roapStruct);
			
			return roapMessage;
		};
		
		// Build the ANSWER ROAP message and process it
		this.processRoapAnswer = function(mediaServices, sdp) {
			logger.log("Processing an ANSWER...");
			var offererSessionId = null;
			var answererSessionId = null;
			var seq = 2;

			if (mediaServices._isModerator) {
				seq = 1;
				offererSessionId = _H2SRoap.offererSessionId;
				answererSessionId = this.idGenerator();
			} else {
				seq = 2;
				offererSessionId = _H2SRoap.offererSessionId;
				answererSessionId = _H2SRoap.answererSessionId;
			}

			//build the sdp

			//build the ROAP message
			//the sdp has been set on invitation received
			var roapsdp = "v=0\r\no=- 0 0 IN IP4 127.0.0.1\r\ns=\r\nt=0 0\r\n";
			for(mediaIndex in sdp) {
				roapsdp += "m=" + sdp[mediaIndex].m + "\r\n";
				roapsdp += "c=" + sdp[mediaIndex].c + "\r\n";
				for(attributeIndex in sdp[mediaIndex].attributes) {
					roapsdp += "a=" + sdp[mediaIndex].attributes[attributeIndex].a + "\r\n";
				}
			}

			var roapStruct = {
				"messageType" : "ANSWER",
				"offererSessionId" : offererSessionId,
				"answererSessionId" : answererSessionId,
				"sdp" : roapsdp,
				"seq" : seq
			};

			var roapMessage = "SDP\n" + JSON.stringify(roapStruct);
			
			return roapMessage;
		};
		
		// Build the OK ROAP message and process it
		this.processRoapOK = function(mediaServices) {
			logger.log("Processing an OK...");

			if(!_H2SRoap.answererSessionId) {
				_H2SRoap.answererSessionId = this.idGenerator();
			}
			var offererSessionId = _H2SRoap.answererSessionId;
			var answererSessionId = _H2SRoap.offererSessionId;
			var seq = 1;
			if (mediaServices._isModerator) {
				seq = 2;
			} else {
				seq = 1;
			}
			var roapStruct = {
				"messageType" : "OK",
				"offererSessionId" : offererSessionId,
				"answererSessionId" : answererSessionId,
				"seq" : seq
			};

			var roapMessage = "SDP\n" + JSON.stringify(roapStruct);
			logger.log("roap message: " + roapMessage);
			return roapMessage;
		};
		
		// The offererSessionId and the answererSessionId must be of 32 characters
		this.idGenerator = function() {
			var S4 = function() {
				return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
			};
			return (S4() + S4() + S4() + S4() + S4() + S4() + S4() + S4());
		};
		
		// The tieBreaker must be of 10 digits
		this.tieBreakerGenerator = function() {
			var id = Math.floor(Math.random() * 90000) + 1000000000;
			return id;
		};
	}

	/**
	Hashmap implementation
	@private
	*/
	var _HashMap = function() {
		var obj = [];
		obj.size = function () {
			return this.length;
		};
		obj.isEmpty = function () {
			return this.length == 0;
		};
		obj.contains = function (key) {
			for (i in this) {
				if (this[i].key == key) {
					return i;
				}
			}
			return -1;
		};
		obj.get = function (key) {
			var i = this.contains(key);
			if (i !== -1) {
				return this[i].value;
			}
		};
		obj.put = function (key, value) {
			if (this.contains(key) == -1) {
				this.push({'key': key, 'value': value});
				return true;
			}
			return false;
		};
		obj.clear = function () {
			for (i in this) {
				this.pop(i);
			}
		};
		obj.remove = function(key) {
			var i = this.contains(key);
			if (i) {
				this.splice(i,1);
			}
		};
		obj.getAll = function() {
			return this;
		};
		return obj;
	};
})(window);