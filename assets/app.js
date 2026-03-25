import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import './stimulus_bootstrap.js';
import { trans, initLocale  } from './translator.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

window.trans = trans;

document.addEventListener('turbo:load', () => {
    const locale = document.querySelector('meta[name="locale"]').content;
    document.documentElement.lang = locale;
    document.documentElement.dataset.symfonyUxTranslatorLocale = locale;
    initLocale(locale);
});

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');