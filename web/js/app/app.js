define(["require", "exports"], function (require, exports) {
    "use strict";
    /**
     * Created by Asus on 2016-10-05.
     */
    var App = (function () {
        function App() {
        }
        App.prototype.show = function () {
            console.log(123);
        };
        return App;
    }());
    exports.App = App;
});
