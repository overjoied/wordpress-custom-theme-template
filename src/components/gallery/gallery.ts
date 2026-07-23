import './gallery.scss';

class Gallery {
  el : HTMLElement | null;

  constructor(el : HTMLElement) {
    this.el = el;
  }
}

export default Gallery;