/*
* Part of meshmap - kg6wxc 2024
*
*/
function getLocation() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(
			//success!
//			usePosition,
			usePosition, null,
			//error (or nothing, I guess)
			//do nothing, use center position from config
			{
				enableHighAccuracy: true,
				timeout: 5000,
				maximumAge: 0
			}
		);
	}
}

function usePosition(position) {
	mapInfo['mapCenterCoords'] = position.coords.latitude;
}
