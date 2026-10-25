import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Bundle the map library locally so its controls and styling do not depend on a CDN.
window.L = L;
