define(["require", "exports", './app/app'], function (require, exports, app) {
    "use strict";
    var application = new app.App();
    application.show();
});
