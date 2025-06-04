import './bootstrap';
import MicroModal from 'micromodal';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


MicroModal.init({
  disableScroll: true,
  awaitOpenAnimation: true, 
  awaitCloseAnimation: false, 
  disableOverlayClose: true,
});

