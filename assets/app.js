/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

const $ = require('jquery');

// any CSS you import will output into a single css file (app.css in this case)
import './styles/main.scss';

// start the Stimulus application
import './bootstrap';

import './styles/Backend/admin.scss';

import './JS/Frontend/addMessageCollection';

import './JS/Frontend/displayForm';

import './JS/Backend/addCollectionInput';

require('bootstrap');

$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});

import './JS/Backend/CKEditor5';