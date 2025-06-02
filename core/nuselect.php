<?php

require_once('nucommon.php');

nuJSInclude('../third_party/jquery/jquery-3.7.1.min.js');
nuJSInclude('nuselectclass.js');
nuJSInclude('nuformclass.js');
nuJSInclude('nuform.js');
nuJSInclude('nuformdrag.js');
nuJSInclude('nudrag.js');
nuJSInclude('nureportdrag.js');
nuJSIndexInclude('../third_party/vanillajs-datepicker/datepicker-full.min.js');
nuJSInclude('numobile.js');
nuJSInclude('nucommon.js');
nuJSInclude('nuajax.js');				//-- calls to server
nuJSInclude('nureportjson.js');

nuCSSInclude('css/nubuilder4.css');
nuCSSInclude('css/nudrag.css');
nuCSSIndexInclude('../third_party/vanillajs-datepicker/datepicker.min.css');

?>

<!DOCTYPE html>
<html>
<head>

<style>

	body{
		background-image: url("graphics/grid.png");
	}

</style>

<script>

	window.nuSuffix				= 1000;
	window.nuSQL				= new nuSelectObject();
	window.nuCurrentID			= '';
	window.nuY					= 0;
	window.nuX					= 0;

	function nuLoad(){

		if(!nuSQL.rebuildGraphic()){
			return;
		}

			$(document).mousemove(function(event){
				nuMove(event);
			});

			$(document).mousedown(function(event){
					nuDown(event);
			});

			$(document).mouseup(function(event){
					nuUp(event);
			});

		parent.nuHasNotBeenEdited();

	}

</script>
</head><body onload='nuLoad()'></body></html>