var $button = document.querySelector('.button');
$button.addEventListener('click', function() {
  var duration = 0.3,
      delay = 0.08;
  TweenMax.to($button, duration, {scaleY: 1.6, ease: Expo.easeOut});
  TweenMax.to($button, duration, {scaleX: 1.2, scaleY: 1, ease: Back.easeOut, easeParams: [3], delay: delay});
  TweenMax.to($button, duration * 1.25, {scaleX: 1, scaleY: 1, ease: Back.easeOut, easeParams: [6], delay: delay * 3 });
});

const docStyle = document.documentElement.style
const aElem = document.querySelector('a')
const boundingClientRect = aElem.getBoundingClientRect()

aElem.onmousemove = function(e) {

	const x = e.clientX - boundingClientRect.left
	const y = e.clientY - boundingClientRect.top
	
	const xc = boundingClientRect.width/2
	const yc = boundingClientRect.height/2
	
	const dx = x - xc
	const dy = y - yc
	
	docStyle.setProperty('--rx', `${ dy/-1 }deg`)
	docStyle.setProperty('--ry', `${ dx/10 }deg`)
	
}

aElem.onmouseleave = function(e) {
	
	docStyle.setProperty('--ty', '0')
	docStyle.setProperty('--rx', '0')
	docStyle.setProperty('--ry', '0')
	
}

aElem.onmousedown = function(e) {
	
	docStyle.setProperty('--tz', '-25px')
	
}

document.body.onmouseup = function(e) {
	
	docStyle.setProperty('--tz', '-12px')
	
}