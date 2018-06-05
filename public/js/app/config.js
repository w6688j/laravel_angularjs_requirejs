var config = {
    tpl: function (tpl) {
        return '//' + window.location.host + "/js/app/views/" + tpl + '.tpl.html';
    },
    parse: function (query) {
        return '//' + window.location.host + "/ajax/" + query + '.html';
    }
};

angular.forEach(config.url, function (v, k) {
    config['url'][k] = 'http://' + window.location.host + v;
});
