require('jsdom-global')();

global.expect = require('expect');
global.axios = require('axios');
global.Vue = require('vue');
global.bus = new Vue();
global.moment = require('moment/moment.js');