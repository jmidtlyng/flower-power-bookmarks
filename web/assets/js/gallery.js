// get reference of all gallery items
const els_galleryItems = document.getElementsByClassName('gallery-item');

// loop gallery items setting timeout load of detailed image
for(const el_galleryItem of els_galleryItems){
	// set timeout to display hd image while it loads in the background
	setTimeout(()=>{ revealHdPhoto(el_galleryItem); }, 3000);
}

function revealHdPhoto(el_galleryItem) {
	// get reference to drawing and hd image
	const el_itemDrawing = el_galleryItem.querySelector('.gallery-item-display-drawing'),
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
	}
}