// get reference of all gallery items
const el_gallery = document.getElementById('gallery'),
			els_galleryItems = document.getElementsByClassName('gallery-item'),
			els_scrollDown = document.getElementsByClassName('gallery-item-page-control--down'),
			els_scrollUp = document.getElementsByClassName('gallery-item-page-control--up');
			
// loop down navigation buttons adding scroll events
for(const el_scrollDown of els_scrollDown){
	el_scrollDown.addEventListener('click', scrollToNext);
}
// loop up navigation buttons adding scroll events
for(const el_scrollUp of els_scrollUp){
	el_scrollUp.addEventListener('click', scrollToPrev);
}

// loop gallery items setting timeout load of detailed image
for(const el_galleryItem of els_galleryItems){
	// set timeout to display hd image while it loads in the background
	setTimeout(()=>{ revealHdPhoto(el_galleryItem); }, 3000);
}

function revealHdPhoto(el_galleryItem) {
	// get reference to drawing and hd image
	const el_imageContainer = el_galleryItem.querySelector('.gallery-item-display'),
				el_itemDrawing = el_galleryItem.querySelector('.gallery-item-display-drawing'),
				el_itemPhoto = el_galleryItem.querySelector('.gallery-item-display-photo'),
				el_itemNote = el_galleryItem.querySelector('.gallery-item-detail-note');
	
	// only hide drawing if a photo is set
	if(el_itemPhoto !== null){
		// if drawing exists, hide
		if(el_itemDrawing !== null){
			el_itemDrawing.classList.add('gallery-item-display--invisible');
			el_itemNote.classList.add('gallery-item-display--invisible');
		}
		
		// reveal photo
		el_itemPhoto.classList.remove('gallery-item-display--invisible');
		

		new ImageZoom(el_imageContainer,
									{ fillContainer: true, zoomWidth: 150,
										offset: {vertical: 0, horizontal: 10},
										img: el_itemPhoto.src, zoomPosition: 'original'});
	}
}

function scrollToNext() {
	el_gallery.scrollBy({ top: el_gallery.clientHeight,
												left: 0,
												behavior: 'smooth' });
}
function scrollToPrev() {
	el_gallery.scrollBy({ top: -el_gallery.clientHeight,
												left: 0,
												behavior: 'smooth' });
}